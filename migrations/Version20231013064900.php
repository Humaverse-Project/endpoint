<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231013064900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organigramme ADD entreprise_id INT NOT NULL');
        $this->addSql('ALTER TABLE organigramme ADD CONSTRAINT FK_9CCC2B10A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9CCC2B10A4AEAFEA ON organigramme (entreprise_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE organigramme DROP CONSTRAINT FK_9CCC2B10A4AEAFEA');
        $this->addSql('DROP INDEX IDX_9CCC2B10A4AEAFEA');
        $this->addSql('ALTER TABLE organigramme DROP entreprise_id');
    }
}
