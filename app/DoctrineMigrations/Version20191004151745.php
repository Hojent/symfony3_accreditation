<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191004151745 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE users_groups (user_id INT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(user_id, event_id))');
        $this->addSql('CREATE INDEX IDX_FF8AB7E0A76ED395 ON users_groups (user_id)');
        $this->addSql('CREATE INDEX IDX_FF8AB7E071F7E88B ON users_groups (event_id)');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP INDEX uniq_4dcbc30d2b36786b');
        $this->addSql('ALTER TABLE user_profile ALTER databorn SET NOT NULL');
        $this->addSql('ALTER TABLE user_profile ALTER passportnum TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_profile ALTER passportnum DROP DEFAULT');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE users_groups');
        $this->addSql('ALTER TABLE user_profile ALTER databorn DROP NOT NULL');
        $this->addSql('ALTER TABLE user_profile ALTER passportnum TYPE INT');
        $this->addSql('ALTER TABLE user_profile ALTER passportnum DROP DEFAULT');
        $this->addSql('CREATE UNIQUE INDEX uniq_4dcbc30d2b36786b ON smi (title)');
    }
}
