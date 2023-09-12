<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230912141643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE briques_contexte ADD rome_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE briques_contexte ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE briques_contexte ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('COMMENT ON COLUMN briques_contexte.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN briques_contexte.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE briques_contexte ADD CONSTRAINT FK_A93185CBEB630B1C FOREIGN KEY (rome_id) REFERENCES rome (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A93185CBEB630B1C ON briques_contexte (rome_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE briques_contexte DROP CONSTRAINT FK_A93185CBEB630B1C');
        $this->addSql('DROP INDEX IDX_A93185CBEB630B1C');
        $this->addSql('ALTER TABLE briques_contexte DROP rome_id');
        $this->addSql('ALTER TABLE briques_contexte DROP created_at');
        $this->addSql('ALTER TABLE briques_contexte DROP updated_at');
    }
}
