<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230921121641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiches_competences ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_competences ADD CONSTRAINT FK_F0C92A0BA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F0C92A0BA4AEAFEA ON fiches_competences (entreprise_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE fiches_competences DROP CONSTRAINT FK_F0C92A0BA4AEAFEA');
        $this->addSql('DROP INDEX IDX_F0C92A0BA4AEAFEA');
        $this->addSql('ALTER TABLE fiches_competences DROP entreprise_id');
    }
}
