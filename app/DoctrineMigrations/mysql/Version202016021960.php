<?php
/** USER_PROFILE TABLE
 * Created by PhpStorm.
 * User: User
 * Date: 2020/02/16
 * Time: 16:40
 */

namespace Application\Migrations\mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version202016021960 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE user_profile (
              id INT NOT NULL,
              user_id integer,
              family varchar(128),
              name varchar(128),
              secondname varchar(128),
              databorn varchar(128) default NULL::character varying,
              privatenum varchar(255) NOT NULL,
              passportnum varchar(255),
              issuedata varchar(128) default NULL::character varying,
              ruvd varchar(256),
              enddata varchar(16),
              place varchar(255),
              phone varchar(32),
              address varchar(255),
              photo varchar(255),
              application varchar(255),             
              PRIMARY KEY (id)) 
              DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_d95ab4056b8ab381 ON user_profile (privatenum)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_d95ab405444f97dd ON user_profile (phone)');
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