<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191007210833 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE event ALTER data_start TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE event ALTER data_start DROP DEFAULT');
        $this->addSql('ALTER TABLE event ALTER data_end TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE event ALTER data_end DROP DEFAULT');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE event ALTER data_start TYPE TIMESTAMP(0) WITH TIME ZONE');
        $this->addSql('ALTER TABLE event ALTER data_start DROP DEFAULT');
        $this->addSql('ALTER TABLE event ALTER data_end TYPE TIMESTAMP(0) WITH TIME ZONE');
        $this->addSql('ALTER TABLE event ALTER data_end DROP DEFAULT');
    }
}
