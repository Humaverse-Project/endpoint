<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231002125011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accreditation ADD fiches_competences_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE accreditation ADD CONSTRAINT FK_3BF9D0D8E7C79C1D FOREIGN KEY (fiches_competences_id) REFERENCES fiches_competences (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3BF9D0D8E7C79C1D ON accreditation (fiches_competences_id)');
        $this->addSql('ALTER TABLE fiches_competences DROP CONSTRAINT fk_f0c92a0b6e70852c');
        $this->addSql('DROP INDEX idx_f0c92a0b6e70852c');
        $this->addSql('ALTER TABLE fiches_competences DROP fic_comp_accreditations_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE accreditation DROP CONSTRAINT FK_3BF9D0D8E7C79C1D');
        $this->addSql('DROP INDEX IDX_3BF9D0D8E7C79C1D');
        $this->addSql('ALTER TABLE accreditation DROP fiches_competences_id');
        $this->addSql('ALTER TABLE fiches_competences ADD fic_comp_accreditations_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_competences ADD CONSTRAINT fk_f0c92a0b6e70852c FOREIGN KEY (fic_comp_accreditations_id) REFERENCES accreditation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f0c92a0b6e70852c ON fiches_competences (fic_comp_accreditations_id)');
    }
}
