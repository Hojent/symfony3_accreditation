<?php
/** EVENT TABLE
 * Created by PhpStorm.
 * User: User
 * Date: 2020/02/16
 * Time: 16:40
 */

namespace Application\Migrations\mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version202016021940 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE event (
              id INTEGER NOT NULL,
              region_id integer DEFAULT NULL ,
              city_id integer DEFAULT NULL ,
              evtip_id integer DEFAULT NULL ,
              title varchar(255) NOT NULL,
              brief TEXT default NULL::character varying,
              data_start timestamp,
              data_end varchar(255),
              data_created timestamp(0) not null,
              address varchar(255) default NULL::character varying,
              organizator TEXT DEFAULT NULL, 
             PRIMARY KEY (id)) 
             DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');
       //this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E981863E41 FOREIGN KEY (userprofile_id) REFERENCES user_profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA798260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA78BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7843F72F2 FOREIGN KEY (evtip_id) REFERENCES evtip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('CREATE INDEX IDX_3bae0aa798260155 ON users (region_id)');
        $this->addSql('CREATE INDEX IDX_3bae0aa78bac62af ON users (city_id)');
        $this->addSql('CREATE INDEX IDX_3bae0aa7843f72f2 ON users (evtip_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP INDEX IDX_3bae0aa798260155');
        $this->addSql('DROP INDEX IDX_3bae0aa78bac62af');
        $this->addSql('DROP INDEX IDX_3bae0aa7843f72f2');

    }






}