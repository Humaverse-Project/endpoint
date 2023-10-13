<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231013080828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organigramme ADD fiches_postes_nplus1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE organigramme ADD CONSTRAINT FK_9CCC2B10DE3AC2BF FOREIGN KEY (fiches_postes_nplus1_id) REFERENCES fiches_postes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9CCC2B10DE3AC2BF ON organigramme (fiches_postes_nplus1_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE organigramme DROP CONSTRAINT FK_9CCC2B10DE3AC2BF');
        $this->addSql('DROP INDEX IDX_9CCC2B10DE3AC2BF');
        $this->addSql('ALTER TABLE organigramme DROP fiches_postes_nplus1_id');
    }
}
