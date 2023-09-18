<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918093905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emploi DROP CONSTRAINT fk_74a0b0fa43994995');
        $this->addSql('DROP INDEX idx_74a0b0fa43994995');
        $this->addSql('ALTER TABLE emploi DROP fiche_competence_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE emploi ADD fiche_competence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emploi ADD CONSTRAINT fk_74a0b0fa43994995 FOREIGN KEY (fiche_competence_id) REFERENCES fiches_competences (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_74a0b0fa43994995 ON emploi (fiche_competence_id)');
    }
}
