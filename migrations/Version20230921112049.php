<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230921112049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fic_comp_competences_client DROP CONSTRAINT fk_d08dde928dc72706');
        $this->addSql('ALTER TABLE fiches_poste_gen_liaison_hierarchique DROP CONSTRAINT fk_ff59f12c81240e07');
        $this->addSql('ALTER TABLE fiches_poste_gen_liaison_fonctionnelle DROP CONSTRAINT fk_5a7a17ce81240e07');
        $this->addSql('ALTER TABLE fiches_poste_gen_convention_collective DROP CONSTRAINT fk_9261f8281240e07');
        $this->addSql('ALTER TABLE fiches_poste_gen_formations DROP CONSTRAINT fk_f18c3edf81240e07');
        $this->addSql('ALTER TABLE fiches_poste_gen_fiches_postes_parcours_professionnel DROP CONSTRAINT fk_684f77ee81240e07');
        $this->addSql('DROP SEQUENCE fichers_competences_client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE fiches_postes_generique_id_seq CASCADE');
        $this->addSql('DROP TABLE fichers_competences_client');
        $this->addSql('DROP TABLE fic_comp_competences_client');
        $this->addSql('DROP TABLE fiches_poste_gen_liaison_hierarchique');
        $this->addSql('DROP TABLE fiches_poste_gen_liaison_fonctionnelle');
        $this->addSql('DROP TABLE fiches_poste_gen_convention_collective');
        $this->addSql('DROP TABLE fiches_postes_generique');
        $this->addSql('DROP TABLE fiches_poste_gen_formations');
        $this->addSql('DROP TABLE fiches_poste_gen_fiches_postes_parcours_professionnel');
        $this->addSql('ALTER TABLE fiches_postes ADD fiches_postes_version DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE fichers_competences_client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE fiches_postes_generique_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE fichers_competences_client (id INT NOT NULL, fic_comp_accreditations_id INT DEFAULT NULL, fic_comp_titre_emploi TEXT NOT NULL, fic_comp_competences_niveau TEXT DEFAULT NULL, fic_comp_version DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_852e172e6e70852c ON fichers_competences_client (fic_comp_accreditations_id)');
        $this->addSql('COMMENT ON COLUMN fichers_competences_client.fic_comp_competences_niveau IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN fichers_competences_client.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN fichers_competences_client.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE fic_comp_competences_client (fichers_competences_client_id INT NOT NULL, briques_competences_id INT NOT NULL, PRIMARY KEY(fichers_competences_client_id, briques_competences_id))');
        $this->addSql('CREATE INDEX idx_d08dde92818828ad ON fic_comp_competences_client (briques_competences_id)');
        $this->addSql('CREATE INDEX idx_d08dde928dc72706 ON fic_comp_competences_client (fichers_competences_client_id)');
        $this->addSql('CREATE TABLE fiches_poste_gen_liaison_hierarchique (fiches_postes_generique_id INT NOT NULL, fiches_postes_id INT NOT NULL, PRIMARY KEY(fiches_postes_generique_id, fiches_postes_id))');
        $this->addSql('CREATE INDEX idx_ff59f12c81240e07 ON fiches_poste_gen_liaison_hierarchique (fiches_postes_generique_id)');
        $this->addSql('CREATE INDEX idx_ff59f12c8c46b39a ON fiches_poste_gen_liaison_hierarchique (fiches_postes_id)');
        $this->addSql('CREATE TABLE fiches_poste_gen_liaison_fonctionnelle (fiches_postes_generique_id INT NOT NULL, fiches_postes_id INT NOT NULL, PRIMARY KEY(fiches_postes_generique_id, fiches_postes_id))');
        $this->addSql('CREATE INDEX idx_5a7a17ce81240e07 ON fiches_poste_gen_liaison_fonctionnelle (fiches_postes_generique_id)');
        $this->addSql('CREATE INDEX idx_5a7a17ce8c46b39a ON fiches_poste_gen_liaison_fonctionnelle (fiches_postes_id)');
        $this->addSql('CREATE TABLE fiches_poste_gen_convention_collective (fiches_postes_generique_id INT NOT NULL, convention_collective_id INT NOT NULL, PRIMARY KEY(fiches_postes_generique_id, convention_collective_id))');
        $this->addSql('CREATE INDEX idx_9261f82a3308d98 ON fiches_poste_gen_convention_collective (convention_collective_id)');
        $this->addSql('CREATE INDEX idx_9261f8281240e07 ON fiches_poste_gen_convention_collective (fiches_postes_generique_id)');
        $this->addSql('CREATE TABLE fiches_postes_generique (id INT NOT NULL, fic_poste_gen_fiche_competence_id INT DEFAULT NULL, fic_poste_gen_fiche_rome_id INT DEFAULT NULL, fic_poste_gen_nplus1_id INT DEFAULT NULL, fic_poste_gen_entreprise_id INT DEFAULT NULL, fic_poste_gen_titre TEXT NOT NULL, fic_poste_gen_validation_at DATE NOT NULL, fic_poste_gen_visa_at DATE DEFAULT NULL, fic_poste_gen_activite TEXT DEFAULT NULL, fic_poste_gen_definition TEXT DEFAULT NULL, fic_poste_gen_agrement TEXT DEFAULT NULL, fic_poste_gen_conditions_generales TEXT DEFAULT NULL, fic_poste_gen_instructions TEXT DEFAULT NULL, fiches_postes_gen_version DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_42f150c5596dcdb7 ON fiches_postes_generique (fic_poste_gen_nplus1_id)');
        $this->addSql('CREATE INDEX idx_42f150c58a08e159 ON fiches_postes_generique (fic_poste_gen_fiche_rome_id)');
        $this->addSql('CREATE INDEX idx_42f150c5ddc41e75 ON fiches_postes_generique (fic_poste_gen_entreprise_id)');
        $this->addSql('CREATE INDEX idx_42f150c58db5881f ON fiches_postes_generique (fic_poste_gen_fiche_competence_id)');
        $this->addSql('COMMENT ON COLUMN fiches_postes_generique.fic_poste_gen_activite IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN fiches_postes_generique.fic_poste_gen_definition IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN fiches_postes_generique.fic_poste_gen_instructions IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN fiches_postes_generique.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN fiches_postes_generique.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE fiches_poste_gen_formations (fiches_postes_generique_id INT NOT NULL, formation_id INT NOT NULL, PRIMARY KEY(fiches_postes_generique_id, formation_id))');
        $this->addSql('CREATE INDEX idx_f18c3edf81240e07 ON fiches_poste_gen_formations (fiches_postes_generique_id)');
        $this->addSql('CREATE INDEX idx_f18c3edf5200282e ON fiches_poste_gen_formations (formation_id)');
        $this->addSql('CREATE TABLE fiches_poste_gen_fiches_postes_parcours_professionnel (fiches_postes_generique_id INT NOT NULL, parcours_professionnel_id INT NOT NULL, PRIMARY KEY(fiches_postes_generique_id, parcours_professionnel_id))');
        $this->addSql('CREATE INDEX idx_684f77ee81240e07 ON fiches_poste_gen_fiches_postes_parcours_professionnel (fiches_postes_generique_id)');
        $this->addSql('CREATE INDEX idx_684f77ee7d110b23 ON fiches_poste_gen_fiches_postes_parcours_professionnel (parcours_professionnel_id)');
        $this->addSql('ALTER TABLE fichers_competences_client ADD CONSTRAINT fk_852e172e6e70852c FOREIGN KEY (fic_comp_accreditations_id) REFERENCES accreditation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fic_comp_competences_client ADD CONSTRAINT fk_d08dde928dc72706 FOREIGN KEY (fichers_competences_client_id) REFERENCES fichers_competences_client (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fic_comp_competences_client ADD CONSTRAINT fk_d08dde92818828ad FOREIGN KEY (briques_competences_id) REFERENCES briques_competences (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_poste_gen_liaison_hierarchique ADD CONSTRAINT fk_ff59f12c81240e07 FOREIGN KEY (fiches_postes_generique_id) REFERENCES fiches_postes_generique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_poste_gen_liaison_hierarchique ADD CONSTRAINT fk_ff59f12c8c46b39a FOREIGN KEY (fiches_postes_id) REFERENCES fiches_postes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_poste_gen_liaison_fonctionnelle ADD CONSTRAINT fk_5a7a17ce81240e07 FOREIGN KEY (fiches_postes_generique_id) REFERENCES fiches_postes_generique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_poste_gen_liaison_fonctionnelle ADD CONSTRAINT fk_5a7a17ce8c46b39a FOREIGN KEY (fiches_postes_id) REFERENCES fiches_postes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_poste_gen_convention_collective ADD CONSTRAINT fk_9261f8281240e07 FOREIGN KEY (fiches_postes_generique_id) REFERENCES fiches_postes_generique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_poste_gen_convention_collective ADD CONSTRAINT fk_9261f82a3308d98 FOREIGN KEY (convention_collective_id) REFERENCES convention_collective (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_postes_generique ADD CONSTRAINT fk_42f150c58db5881f FOREIGN KEY (fic_poste_gen_fiche_competence_id) REFERENCES fiches_competences (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_postes_generique ADD CONSTRAINT fk_42f150c58a08e159 FOREIGN KEY (fic_poste_gen_fiche_rome_id) REFERENCES rome (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_postes_generique ADD CONSTRAINT fk_42f150c5596dcdb7 FOREIGN KEY (fic_poste_gen_nplus1_id) REFERENCES fiches_postes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_postes_generique ADD CONSTRAINT fk_42f150c5ddc41e75 FOREIGN KEY (fic_poste_gen_entreprise_id) REFERENCES entreprise (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_poste_gen_formations ADD CONSTRAINT fk_f18c3edf81240e07 FOREIGN KEY (fiches_postes_generique_id) REFERENCES fiches_postes_generique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_poste_gen_formations ADD CONSTRAINT fk_f18c3edf5200282e FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_poste_gen_fiches_postes_parcours_professionnel ADD CONSTRAINT fk_684f77ee81240e07 FOREIGN KEY (fiches_postes_generique_id) REFERENCES fiches_postes_generique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_poste_gen_fiches_postes_parcours_professionnel ADD CONSTRAINT fk_684f77ee7d110b23 FOREIGN KEY (parcours_professionnel_id) REFERENCES parcours_professionnel (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiches_postes DROP fiches_postes_version');
    }
}
