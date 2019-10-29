<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191028120536 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE actions (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, description LONGTEXT DEFAULT NULL, date_of_work DATE NOT NULL, responsable VARCHAR(255) NOT NULL, email_responsable VARCHAR(255) NOT NULL, phone_number_responsable LONGTEXT NOT NULL, attached_files LONGTEXT DEFAULT NULL, created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(), INDEX IDX_47CC8C9254177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apartments (id INT AUTO_INCREMENT NOT NULL, building_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(), INDEX IDX_4D7E68544D2A7E12 (building_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE buildings (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rooms (id INT AUTO_INCREMENT NOT NULL, apartment_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(), INDEX IDX_729F519B176DFE85 (apartment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actions ADD CONSTRAINT FK_47CC8C9254177093 FOREIGN KEY (room_id) REFERENCES rooms (id)');
        $this->addSql('ALTER TABLE apartments ADD CONSTRAINT FK_4D7E68544D2A7E12 FOREIGN KEY (building_id) REFERENCES buildings (id)');
        $this->addSql('ALTER TABLE rooms ADD CONSTRAINT FK_729F519B176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartments (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rooms DROP FOREIGN KEY FK_729F519B176DFE85');
        $this->addSql('ALTER TABLE apartments DROP FOREIGN KEY FK_4D7E68544D2A7E12');
        $this->addSql('ALTER TABLE actions DROP FOREIGN KEY FK_47CC8C9254177093');
        $this->addSql('DROP TABLE actions');
        $this->addSql('DROP TABLE apartments');
        $this->addSql('DROP TABLE buildings');
        $this->addSql('DROP TABLE rooms');
    }
}
