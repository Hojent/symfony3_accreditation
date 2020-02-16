<?php
/** USER_EVENT
 * Created by PhpStorm.
 * User: User
 * Date: 2020/02/16
 * Time: 16:40
 */

namespace Application\Migrations\mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version202016021970 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE user_event (
               id INT NOT NULL, 
               user_id integer not null,
               event_id integer not null,
               status smallint default 0,
               date timestamp default now(),
		       PRIMARY KEY (user_id, event_id)) 
               DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT fk_d96cf1ffa76ed395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE on delete cascade');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT fk_d96cf1ff71f7e88b FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE on delete cascade');
        $this->addSql('CREATE INDEX IDX_d96cf1ff71f7e88b ON user_event (event_id)');
        $this->addSql('CREATE INDEX IDX_d96cf1ffa76ed395 ON user_event (user_id)');

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP TABLE user_event');
        $this->addSql('DROP INDEX IDX_d96cf1ffa76ed395');
        $this->addSql('DROP INDEX IDX_d96cf1ff71f7e88b');
    }






}