<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231002125242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fiches_competences_accreditation (fiches_competences_id INT NOT NULL, accreditation_id INT NOT NULL, PRIMARY KEY(fiches_competences_id, accreditation_id))');
        $this->addSql('CREATE INDEX IDX_167E0325E7C79C1D ON fiches_competences_accreditation (fiches_competences_id)');
        $this->addSql('CREATE INDEX IDX_167E0325A0822E24 ON fiches_competences_accreditation (accreditation_id)');
        $this->addSql('ALTER TABLE fiches_competences_accreditation ADD CONSTRAINT FK_167E0325E7C79C1D FOREIGN KEY (fiches_competences_id) REFERENCES fiches_competences (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_competences_accreditation ADD CONSTRAINT FK_167E0325A0822E24 FOREIGN KEY (accreditation_id) REFERENCES accreditation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE accreditation DROP CONSTRAINT fk_3bf9d0d8e7c79c1d');
        $this->addSql('DROP INDEX idx_3bf9d0d8e7c79c1d');
        $this->addSql('ALTER TABLE accreditation DROP fiches_competences_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE fiches_competences_accreditation');
        $this->addSql('ALTER TABLE accreditation ADD fiches_competences_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE accreditation ADD CONSTRAINT fk_3bf9d0d8e7c79c1d FOREIGN KEY (fiches_competences_id) REFERENCES fiches_competences (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_3bf9d0d8e7c79c1d ON accreditation (fiches_competences_id)');
    }
}
