<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190925085913 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE users ADD username_canonical VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE users ADD email_canonical VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE users ADD enabled BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE users ADD salt VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD confirmation_token VARCHAR(180) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE users ALTER username TYPE VARCHAR(180)');
        $this->addSql('ALTER TABLE users ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users ALTER email TYPE VARCHAR(180)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E992FC23A8 ON users (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9A0D96FBF ON users (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9C05FB297 ON users (confirmation_token)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');


        $this->addSql('DROP INDEX UNIQ_1483A5E992FC23A8');
        $this->addSql('DROP INDEX UNIQ_1483A5E9A0D96FBF');
        $this->addSql('DROP INDEX UNIQ_1483A5E9C05FB297');
        $this->addSql('ALTER TABLE users DROP username_canonical');
        $this->addSql('ALTER TABLE users DROP email_canonical');
        $this->addSql('ALTER TABLE users DROP enabled');
        $this->addSql('ALTER TABLE users DROP salt');
        $this->addSql('ALTER TABLE users DROP last_login');
        $this->addSql('ALTER TABLE users DROP confirmation_token');
        $this->addSql('ALTER TABLE users DROP password_requested_at');
        $this->addSql('ALTER TABLE users ALTER username TYPE VARCHAR(25)');
        $this->addSql('ALTER TABLE users ALTER email TYPE VARCHAR(254)');
        $this->addSql('ALTER TABLE users ALTER password TYPE VARCHAR(64)');
        $this->addSql('CREATE UNIQUE INDEX uniq_1483a5e9f85e0677 ON users (username)');
        $this->addSql('CREATE UNIQUE INDEX uniq_1483a5e9e7927c74 ON users (email)');
    }
}



