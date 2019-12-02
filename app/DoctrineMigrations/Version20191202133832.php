<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191202133832 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE smi ADD region_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE smi ADD body VARCHAR(512) DEFAULT NULL');
        $this->addSql('ALTER TABLE smi ADD CONSTRAINT FK_4DCBC30D98260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4DCBC30D98260155 ON smi (region_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE smi DROP CONSTRAINT FK_4DCBC30D98260155');
        $this->addSql('DROP INDEX IDX_4DCBC30D98260155');
        $this->addSql('ALTER TABLE smi DROP region_id');
        $this->addSql('ALTER TABLE smi DROP body');
    }
}
