<?php
/** SMI TABLE
 * Created by PhpStorm.
 * User: User
 * Date: 2020/02/16
 * Time: 16:40
 */

namespace Application\Migrations\mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version202016021950 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE smi (
              id INT NOT NULL, 
              title varchar(255) NOT NULL,
              owner varchar(255) NOT NULL,
              unp INTEGER NOT NULL,
              region_id integer DEFAULT NULL ,
              body VARCHAR (512) default NULL::character varying,
              head varchar(255) default NULL,
              tel varchar(255) default NULL,
              address varchar(255) default NULL::character varying,              
              PRIMARY KEY (id)) 
              DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE smi ADD CONSTRAINT FK_4dcbc30d98260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4dcbc30d98260155 ON smi (region_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4dcbc30d60044bc ON smi (unp)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP TABLE smi');
        $this->addSql('DROP INDEX IDX_4dcbc30d98260155');
        $this->addSql('DROP INDEX UNIQ_4dcbc30d60044bc');
    }






}