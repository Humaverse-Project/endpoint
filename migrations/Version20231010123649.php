<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010123649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiches_postes ADD fiches_poste_definition TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_postes ADD fiches_post_formations TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_postes ADD fiches_postes_activite TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_postes DROP instructions');
        $this->addSql('ALTER TABLE fiches_postes RENAME COLUMN access TO fiches_postes_convention');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE fiches_postes ADD instructions TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_postes ADD access TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_postes DROP fiches_postes_convention');
        $this->addSql('ALTER TABLE fiches_postes DROP fiches_poste_definition');
        $this->addSql('ALTER TABLE fiches_postes DROP fiches_post_formations');
        $this->addSql('ALTER TABLE fiches_postes DROP fiches_postes_activite');
        $this->addSql('COMMENT ON COLUMN fiches_postes.instructions IS \'(DC2Type:array)\'');
    }
}
