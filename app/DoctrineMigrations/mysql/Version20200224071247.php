<?php

namespace Application\Migrations\Mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200224071247 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE banner (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, file_name VARCHAR(128) DEFAULT NULL, publish TINYINT(1) NOT NULL, link VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_event ADD status INT DEFAULT 0, ADD date DATETIME DEFAULT CURRENT_TIMESTAMP');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE banner');
        $this->addSql('ALTER TABLE user_event ADD status INT DEFAULT 0, ADD date DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE user_profile CHANGE passportnum passportnum VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
