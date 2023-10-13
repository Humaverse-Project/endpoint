<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231013063921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE organigramme_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE organigramme (id INT NOT NULL, fiches_postes_id INT DEFAULT NULL, personnes_id INT DEFAULT NULL, org_intitule_poste TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9CCC2B108C46B39A ON organigramme (fiches_postes_id)');
        $this->addSql('CREATE INDEX IDX_9CCC2B10146AD7BC ON organigramme (personnes_id)');
        $this->addSql('COMMENT ON COLUMN organigramme.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN organigramme.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE organigramme ADD CONSTRAINT FK_9CCC2B108C46B39A FOREIGN KEY (fiches_postes_id) REFERENCES fiches_postes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organigramme ADD CONSTRAINT FK_9CCC2B10146AD7BC FOREIGN KEY (personnes_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE organigramme_id_seq CASCADE');
        $this->addSql('DROP TABLE organigramme');
    }
}
