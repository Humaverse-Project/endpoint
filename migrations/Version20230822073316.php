<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230822073316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE proposition (id INT AUTO_INCREMENT NOT NULL, creation DATETIME NOT NULL, createdby INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE proposition_poste ADD proposition_id INT NOT NULL');
        $this->addSql('ALTER TABLE proposition_poste ADD CONSTRAINT FK_C2D9BD7BDB96F9E FOREIGN KEY (proposition_id) REFERENCES proposition (id)');
        $this->addSql('CREATE INDEX IDX_C2D9BD7BDB96F9E ON proposition_poste (proposition_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE proposition_poste DROP FOREIGN KEY FK_C2D9BD7BDB96F9E');
        $this->addSql('DROP TABLE proposition');
        $this->addSql('DROP INDEX IDX_C2D9BD7BDB96F9E ON proposition_poste');
        $this->addSql('ALTER TABLE proposition_poste DROP proposition_id');
    }
}
