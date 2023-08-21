<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230821093537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE proposition_poste (id INT AUTO_INCREMENT NOT NULL, metier_id INT NOT NULL, competance_id INT NOT NULL, creation DATETIME NOT NULL, createdby INT NOT NULL, type VARCHAR(30) NOT NULL, INDEX IDX_C2D9BD7BED16FA20 (metier_id), INDEX IDX_C2D9BD7BE13939B8 (competance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote_proposition (id INT AUTO_INCREMENT NOT NULL, proposition_id INT NOT NULL, votepar INT NOT NULL, creation DATETIME NOT NULL, value TINYINT(1) NOT NULL, INDEX IDX_7440F507DB96F9E (proposition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE proposition_poste ADD CONSTRAINT FK_C2D9BD7BED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id)');
        $this->addSql('ALTER TABLE proposition_poste ADD CONSTRAINT FK_C2D9BD7BE13939B8 FOREIGN KEY (competance_id) REFERENCES competance (id)');
        $this->addSql('ALTER TABLE vote_proposition ADD CONSTRAINT FK_7440F507DB96F9E FOREIGN KEY (proposition_id) REFERENCES proposition_poste (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote_proposition DROP FOREIGN KEY FK_7440F507DB96F9E');
        $this->addSql('DROP TABLE proposition_poste');
        $this->addSql('DROP TABLE vote_proposition');
    }
}
