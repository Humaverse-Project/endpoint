<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230926064547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE briques_competences_niveau_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE briques_competences_niveau (id INT NOT NULL, briquescompetances_id INT NOT NULL, fichescompetances_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_78AA75BE67A2A0FD ON briques_competences_niveau (briquescompetances_id)');
        $this->addSql('CREATE INDEX IDX_78AA75BE2E2DDA27 ON briques_competences_niveau (fichescompetances_id)');
        $this->addSql('ALTER TABLE briques_competences_niveau ADD CONSTRAINT FK_78AA75BE67A2A0FD FOREIGN KEY (briquescompetances_id) REFERENCES briques_competences (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE briques_competences_niveau ADD CONSTRAINT FK_78AA75BE2E2DDA27 FOREIGN KEY (fichescompetances_id) REFERENCES fiches_competences (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE briques_competences_niveau_id_seq CASCADE');
        $this->addSql('DROP TABLE briques_competences_niveau');
    }
}
