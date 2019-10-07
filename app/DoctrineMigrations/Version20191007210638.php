<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191007210638 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE users_groups');
        $this->addSql('ALTER TABLE event ADD address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_event DROP CONSTRAINT FK_D96CF1FFA76ED395');
        $this->addSql('ALTER TABLE user_event DROP CONSTRAINT FK_D96CF1FF71F7E88B');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FFA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FF71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE users_groups (user_id INT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(user_id, event_id))');
        $this->addSql('CREATE INDEX idx_ff8ab7e0a76ed395 ON users_groups (user_id)');
        $this->addSql('CREATE INDEX idx_ff8ab7e071f7e88b ON users_groups (event_id)');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT fk_ff8ab7e0a76ed395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT fk_ff8ab7e071f7e88b FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event DROP address');
        $this->addSql('ALTER TABLE user_event DROP CONSTRAINT fk_d96cf1ffa76ed395');
        $this->addSql('ALTER TABLE user_event DROP CONSTRAINT fk_d96cf1ff71f7e88b');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT fk_d96cf1ffa76ed395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT fk_d96cf1ff71f7e88b FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
