<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230822084734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote_proposition DROP FOREIGN KEY FK_7440F507DB96F9E');
        $this->addSql('ALTER TABLE vote_proposition ADD CONSTRAINT FK_7440F507DB96F9E FOREIGN KEY (proposition_id) REFERENCES proposition (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote_proposition DROP FOREIGN KEY FK_7440F507DB96F9E');
        $this->addSql('ALTER TABLE vote_proposition ADD CONSTRAINT FK_7440F507DB96F9E FOREIGN KEY (proposition_id) REFERENCES proposition_poste (id)');
    }
}
