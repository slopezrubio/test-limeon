<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191126102248 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE actions (id INT AUTO_INCREMENT NOT NULL, building_id INT NOT NULL, apartment_id INT NOT NULL, room_id INT DEFAULT NULL, description LONGTEXT NOT NULL, date_of_work DATE NOT NULL, responsable VARCHAR(255) NOT NULL, email_responsable VARCHAR(255) DEFAULT NULL, phone_number_responsable LONGTEXT NOT NULL, attached_files VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_548F1EF4D2A7E12 (building_id), INDEX IDX_548F1EF176DFE85 (apartment_id), INDEX IDX_548F1EF54177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apartments (id INT AUTO_INCREMENT NOT NULL, building_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_7745248E4D2A7E12 (building_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Buildings (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rooms (id INT AUTO_INCREMENT NOT NULL, apartment_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_7CA11A96176DFE85 (apartment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actions ADD CONSTRAINT FK_548F1EF4D2A7E12 FOREIGN KEY (building_id) REFERENCES Buildings (id)');
        $this->addSql('ALTER TABLE actions ADD CONSTRAINT FK_548F1EF176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartments (id)');
        $this->addSql('ALTER TABLE actions ADD CONSTRAINT FK_548F1EF54177093 FOREIGN KEY (room_id) REFERENCES rooms (id)');
        $this->addSql('ALTER TABLE apartments ADD CONSTRAINT FK_7745248E4D2A7E12 FOREIGN KEY (building_id) REFERENCES Buildings (id)');
        $this->addSql('ALTER TABLE rooms ADD CONSTRAINT FK_7CA11A96176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartments (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actions DROP FOREIGN KEY FK_548F1EF176DFE85');
        $this->addSql('ALTER TABLE rooms DROP FOREIGN KEY FK_7CA11A96176DFE85');
        $this->addSql('ALTER TABLE actions DROP FOREIGN KEY FK_548F1EF4D2A7E12');
        $this->addSql('ALTER TABLE apartments DROP FOREIGN KEY FK_7745248E4D2A7E12');
        $this->addSql('ALTER TABLE actions DROP FOREIGN KEY FK_548F1EF54177093');
        $this->addSql('DROP TABLE actions');
        $this->addSql('DROP TABLE apartments');
        $this->addSql('DROP TABLE Buildings');
        $this->addSql('DROP TABLE rooms');
    }
}
