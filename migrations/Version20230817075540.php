<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230817075540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competance (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(20) NOT NULL, class VARCHAR(255) NOT NULL, description_c LONGTEXT DEFAULT NULL, description_l LONGTEXT DEFAULT NULL, creation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metier (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(20) NOT NULL, nom VARCHAR(255) NOT NULL, description_c LONGTEXT DEFAULT NULL, description_l LONGTEXT DEFAULT NULL, creation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste (id INT AUTO_INCREMENT NOT NULL, metier_id INT NOT NULL, competance_id INT NOT NULL, niveau_competance INT NOT NULL, creation DATETIME NOT NULL, INDEX IDX_7C890FABED16FA20 (metier_id), INDEX IDX_7C890FABE13939B8 (competance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE poste ADD CONSTRAINT FK_7C890FABED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id)');
        $this->addSql('ALTER TABLE poste ADD CONSTRAINT FK_7C890FABE13939B8 FOREIGN KEY (competance_id) REFERENCES competance (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poste DROP FOREIGN KEY FK_7C890FABE13939B8');
        $this->addSql('ALTER TABLE poste DROP FOREIGN KEY FK_7C890FABED16FA20');
        $this->addSql('DROP TABLE competance');
        $this->addSql('DROP TABLE metier');
        $this->addSql('DROP TABLE poste');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
