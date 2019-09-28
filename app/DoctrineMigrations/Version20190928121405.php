<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190928121405 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE smi_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE smi (id INT NOT NULL, title VARCHAR(255) NOT NULL, owner VARCHAR(255) NOT NULL, unp INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4DCBC30D2B36786B ON smi (title)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4DCBC30D60044BC ON smi (unp)');
        $this->addSql('CREATE TABLE users_groups (user_id INT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(user_id, event_id))');
        $this->addSql('CREATE INDEX IDX_FF8AB7E0A76ED395 ON users_groups (user_id)');
        $this->addSql('CREATE INDEX IDX_FF8AB7E071F7E88B ON users_groups (event_id)');
        $this->addSql('CREATE TABLE user_event (id INT NOT NULL, user_id INT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_profile (id INT NOT NULL, user_id INT DEFAULT NULL, family VARCHAR(128) DEFAULT NULL, name VARCHAR(128) DEFAULT NULL, secondname VARCHAR(128) DEFAULT NULL, databorn DATE DEFAULT NULL, privatenum INT DEFAULT NULL, passportnum INT DEFAULT NULL, issuedata DATE DEFAULT NULL, ruvd VARCHAR(256) DEFAULT NULL, enddata DATE DEFAULT NULL, place TEXT DEFAULT NULL, phone INT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, application VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D95AB4056B8AB381 ON user_profile (privatenum)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D95AB405444F97DD ON user_profile (phone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D95AB40514B78418 ON user_profile (photo)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D95AB405A76ED395 ON user_profile (user_id)');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB405A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD smi_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E982F8C99B FOREIGN KEY (smi_id) REFERENCES smi (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1483A5E982F8C99B ON users (smi_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E982F8C99B');
        $this->addSql('DROP SEQUENCE smi_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_profile_id_seq CASCADE');
        $this->addSql('DROP TABLE smi');
        $this->addSql('DROP TABLE users_groups');
        $this->addSql('DROP TABLE user_event');
        $this->addSql('DROP TABLE user_profile');
        $this->addSql('DROP INDEX IDX_1483A5E982F8C99B');
        $this->addSql('ALTER TABLE users DROP smi_id');
    }
}
