<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010123111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE briques_contexte_metiers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE briques_contexte_metiers (id INT NOT NULL, contexte_id INT NOT NULL, fiches_postes_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C4EAF6AB99B36A86 ON briques_contexte_metiers (contexte_id)');
        $this->addSql('CREATE INDEX IDX_C4EAF6AB8C46B39A ON briques_contexte_metiers (fiches_postes_id)');
        $this->addSql('ALTER TABLE briques_contexte_metiers ADD CONSTRAINT FK_C4EAF6AB99B36A86 FOREIGN KEY (contexte_id) REFERENCES contextes_travail (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE briques_contexte_metiers ADD CONSTRAINT FK_C4EAF6AB8C46B39A FOREIGN KEY (fiches_postes_id) REFERENCES fiches_postes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_postes ADD access TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_postes DROP fiches_postes_activite');
        $this->addSql('ALTER TABLE fiches_postes DROP fiches_postes_definition');
        $this->addSql('ALTER TABLE fiches_postes DROP fiches_postes_agrement');
        $this->addSql('ALTER TABLE fiches_postes DROP conditions_generales');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE briques_contexte_metiers_id_seq CASCADE');
        $this->addSql('DROP TABLE briques_contexte_metiers');
        $this->addSql('ALTER TABLE fiches_postes ADD fiches_postes_activite TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_postes ADD fiches_postes_definition TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_postes ADD conditions_generales TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_postes RENAME COLUMN access TO fiches_postes_agrement');
        $this->addSql('COMMENT ON COLUMN fiches_postes.fiches_postes_activite IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN fiches_postes.fiches_postes_definition IS \'(DC2Type:array)\'');
    }
}
