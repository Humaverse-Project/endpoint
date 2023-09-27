<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230927081526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiches_competences ADD appelation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiches_competences ADD CONSTRAINT FK_F0C92A0BF9E65DDB FOREIGN KEY (appelation_id) REFERENCES emploi (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F0C92A0BF9E65DDB ON fiches_competences (appelation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE fiches_competences DROP CONSTRAINT FK_F0C92A0BF9E65DDB');
        $this->addSql('DROP INDEX IDX_F0C92A0BF9E65DDB');
        $this->addSql('ALTER TABLE fiches_competences DROP appelation_id');
    }
}
