<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231016135243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organigramme DROP CONSTRAINT FK_9CCC2B105FADECFD');
        $this->addSql('ALTER TABLE organigramme ADD CONSTRAINT FK_9CCC2B105FADECFD FOREIGN KEY (organigramme_nplus_1_id) REFERENCES organigramme (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE organigramme DROP CONSTRAINT fk_9ccc2b105fadecfd');
        $this->addSql('ALTER TABLE organigramme ADD CONSTRAINT fk_9ccc2b105fadecfd FOREIGN KEY (organigramme_nplus_1_id) REFERENCES organigramme (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
