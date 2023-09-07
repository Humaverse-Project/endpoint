<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230907110032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE accreditation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE briques_contexte_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE compte_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contextes_travail_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE entreprise_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rome_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE accreditation (id INT NOT NULL, accre_titre VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN accreditation.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN accreditation.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE briques_contexte (id INT NOT NULL, contexte_id INT DEFAULT NULL, brq_ctx_titre TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A93185CB99B36A86 ON briques_contexte (contexte_id)');
        $this->addSql('CREATE TABLE compte (id INT NOT NULL, compte_entreprise_id_id INT DEFAULT NULL, compte_nom VARCHAR(50) NOT NULL, compte_prenom VARCHAR(50) NOT NULL, compte_email VARCHAR(100) NOT NULL, compte_nom_utilisateur VARCHAR(100) NOT NULL, compte_mot_de_passe TEXT NOT NULL, compte_role VARCHAR(20) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CFF65260B1672396 ON compte (compte_entreprise_id_id)');
        $this->addSql('COMMENT ON COLUMN compte.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN compte.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE contextes_travail (id INT NOT NULL, ctx_trv_titre TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN contextes_travail.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN contextes_travail.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE entreprise (id INT NOT NULL, entreprise_nom TEXT DEFAULT NULL, entreprise_siret VARCHAR(14) NOT NULL, entreprise_ape_naf VARCHAR(5) DEFAULT NULL, entreprise_url TEXT DEFAULT NULL, entreprise_adresse TEXT DEFAULT NULL, entreprise_code_postal VARCHAR(5) DEFAULT NULL, entreprise_ville VARCHAR(50) NOT NULL, entreprise_pays VARCHAR(30) NOT NULL, entreprise_telephone VARCHAR(50) NOT NULL, entreprise_email VARCHAR(50) NOT NULL, entreprise_effectif INT NOT NULL, entreprise_etablissement INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN entreprise.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN entreprise.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE rome (id INT NOT NULL, rome_titre TEXT NOT NULL, rome_coderome VARCHAR(20) NOT NULL, rome_definition TEXT NOT NULL, rome_acces_metier TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN rome.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN rome.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE rome_proches (rome_source INT NOT NULL, rome_target INT NOT NULL, PRIMARY KEY(rome_source, rome_target))');
        $this->addSql('CREATE INDEX IDX_C152F0D7E3D78A81 ON rome_proches (rome_source)');
        $this->addSql('CREATE INDEX IDX_C152F0D7FA32DA0E ON rome_proches (rome_target)');
        $this->addSql('CREATE TABLE rome_evolution (rome_source INT NOT NULL, rome_target INT NOT NULL, PRIMARY KEY(rome_source, rome_target))');
        $this->addSql('CREATE INDEX IDX_885DB720E3D78A81 ON rome_evolution (rome_source)');
        $this->addSql('CREATE INDEX IDX_885DB720FA32DA0E ON rome_evolution (rome_target)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE briques_contexte ADD CONSTRAINT FK_A93185CB99B36A86 FOREIGN KEY (contexte_id) REFERENCES contextes_travail (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260B1672396 FOREIGN KEY (compte_entreprise_id_id) REFERENCES entreprise (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rome_proches ADD CONSTRAINT FK_C152F0D7E3D78A81 FOREIGN KEY (rome_source) REFERENCES rome (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rome_proches ADD CONSTRAINT FK_C152F0D7FA32DA0E FOREIGN KEY (rome_target) REFERENCES rome (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rome_evolution ADD CONSTRAINT FK_885DB720E3D78A81 FOREIGN KEY (rome_source) REFERENCES rome (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rome_evolution ADD CONSTRAINT FK_885DB720FA32DA0E FOREIGN KEY (rome_target) REFERENCES rome (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE briques_contexte DROP CONSTRAINT FK_A93185CB99B36A86');
        $this->addSql('ALTER TABLE compte DROP CONSTRAINT FK_CFF65260B1672396');
        $this->addSql('ALTER TABLE rome_proches DROP CONSTRAINT FK_C152F0D7E3D78A81');
        $this->addSql('ALTER TABLE rome_proches DROP CONSTRAINT FK_C152F0D7FA32DA0E');
        $this->addSql('ALTER TABLE rome_evolution DROP CONSTRAINT FK_885DB720E3D78A81');
        $this->addSql('ALTER TABLE rome_evolution DROP CONSTRAINT FK_885DB720FA32DA0E');
        $this->addSql('DROP SEQUENCE accreditation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE briques_contexte_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE compte_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contextes_travail_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE entreprise_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rome_id_seq CASCADE');
        $this->addSql('DROP TABLE accreditation');
        $this->addSql('DROP TABLE briques_contexte');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE contextes_travail');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE rome');
        $this->addSql('DROP TABLE rome_proches');
        $this->addSql('DROP TABLE rome_evolution');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
