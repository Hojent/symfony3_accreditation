<?php
/** USERS TABLE
 * Created by PhpStorm.
 * User: User
 * Date: 2020/02/16
 * Time: 16:40
 */

namespace Application\Migrations\mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version202016021930 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE users (
               id INT NOT NULL, 
               username VARCHAR(180) NOT NULL, 
               password VARCHAR(64) NOT NULL, 
               email VARCHAR(254) NOT NULL, 
               pict_file_name VARCHAR (128),
               is_active BOOLEAN NOT NULL,
               roles TEXT NOT NULL,
               username_canonical VARCHAR(180) NOT NULL,
               email_canonical VARCHAR(180) NOT NULL,
               enabled BOOLEAN NOT NULL,
               salt VARCHAR(255) DEFAULT NULL,
               last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
               confirmation_token VARCHAR(180) DEFAULT NULL,
               password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
               userprofile_id INT DEFAULT NULL,
               smi_id INT DEFAULT NULL,       
               PRIMARY KEY (id)) 
               DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB');

        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E981863E41 FOREIGN KEY (userprofile_id) REFERENCES user_profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E982F8C99B FOREIGN KEY (smi_id) REFERENCES smi (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E992FC23A8 ON users (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9A0D96FBF ON users (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9C05FB297 ON users (confirmation_token)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E981863E41 ON users (userprofile_id)');
        $this->addSql('CREATE INDEX IDX_1483A5E982F8C99B ON users (smi_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP INDEX UNIQ_1483A5E992FC23A8');
        $this->addSql('DROP INDEX UNIQ_1483A5E9A0D96FBF');
        $this->addSql('DROP INDEX UNIQ_1483A5E9C05FB297');
        $this->addSql('DROP INDEX UNIQ_1483a5e9f85e0677');
        $this->addSql('DROP INDEX UNIQ_1483a5e9e7927c74');
        $this->addSql('DROP INDEX UNIQ_1483A5E981863E41');
        $this->addSql('DROP INDEX IDX_1483A5E982F8C99B');
    }






}