<?php declare(strict_types=1);

namespace Application\Migrations\Mysql;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200225130526 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE banner (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, file_name VARCHAR(128) DEFAULT NULL, publish TINYINT(1) NOT NULL, link VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, INDEX IDX_2D5B023498260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(256) NOT NULL, file_name VARCHAR(128) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, city_id INT DEFAULT NULL, evtip_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, brief LONGTEXT DEFAULT NULL, organizator LONGTEXT DEFAULT NULL, data_start VARCHAR(255) DEFAULT NULL, data_end VARCHAR(255) DEFAULT NULL, data_created DATETIME NOT NULL, address VARCHAR(255) DEFAULT NULL, INDEX IDX_3BAE0AA798260155 (region_id), INDEX IDX_3BAE0AA78BAC62AF (city_id), INDEX IDX_3BAE0AA7843F72F2 (evtip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evtip (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_6E66913E5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smi (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, owner VARCHAR(255) NOT NULL, body VARCHAR(512) DEFAULT NULL, head VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, unp INT NOT NULL, UNIQUE INDEX UNIQ_4DCBC30D60044BC (unp), INDEX IDX_4DCBC30D98260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smitip (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_AC3AB4E75E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, userprofile_id INT DEFAULT NULL, smi_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', is_active TINYINT(1) NOT NULL, pict_file_name VARCHAR(128) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_1483A5E9A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_1483A5E9C05FB297 (confirmation_token), UNIQUE INDEX UNIQ_1483A5E981863E41 (userprofile_id), INDEX IDX_1483A5E982F8C99B (smi_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_event (user_id INT NOT NULL, event_id INT NOT NULL, status INT DEFAULT 0, date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_D96CF1FFA76ED395 (user_id), INDEX IDX_D96CF1FF71F7E88B (event_id), PRIMARY KEY(user_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_profile (id INT AUTO_INCREMENT NOT NULL, family VARCHAR(128) DEFAULT NULL, name VARCHAR(128) DEFAULT NULL, secondname VARCHAR(128) DEFAULT NULL, databorn VARCHAR(255) DEFAULT NULL, privatenum VARCHAR(255) DEFAULT NULL, passportnum VARCHAR(255) NOT NULL, issuedata VARCHAR(255) DEFAULT NULL, ruvd TEXT DEFAULT NULL, enddata VARCHAR(255) DEFAULT NULL, place VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, application VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_D95AB4056B8AB381 (privatenum), UNIQUE INDEX UNIQ_D95AB405444F97DD (phone), UNIQUE INDEX UNIQ_D95AB40514B78418 (photo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B023498260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA798260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA78BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7843F72F2 FOREIGN KEY (evtip_id) REFERENCES evtip (id)');
        $this->addSql('ALTER TABLE smi ADD CONSTRAINT FK_4DCBC30D98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E981863E41 FOREIGN KEY (userprofile_id) REFERENCES user_profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E982F8C99B FOREIGN KEY (smi_id) REFERENCES smi (id)');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FFA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FF71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA78BAC62AF');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FF71F7E88B');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7843F72F2');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B023498260155');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA798260155');
        $this->addSql('ALTER TABLE smi DROP FOREIGN KEY FK_4DCBC30D98260155');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E982F8C99B');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FFA76ED395');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E981863E41');
        $this->addSql('DROP TABLE banner');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE evtip');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE smi');
        $this->addSql('DROP TABLE smitip');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE user_event');
        $this->addSql('DROP TABLE user_profile');
    }
}
