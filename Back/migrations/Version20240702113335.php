<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702113335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paiement_niveau_etude_annee_scolaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, niveau_etude_id INTEGER DEFAULT NULL, annee_scolaire_id INTEGER DEFAULT NULL, mensualite_id INTEGER DEFAULT NULL, montant VARCHAR(255) NOT NULL, CONSTRAINT FK_29299FD6FEAD13D1 FOREIGN KEY (niveau_etude_id) REFERENCES niveau_etude (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_29299FD69331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_29299FD6B5B467BF FOREIGN KEY (mensualite_id) REFERENCES annee_scolaire_mensualite (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_29299FD6FEAD13D1 ON paiement_niveau_etude_annee_scolaire (niveau_etude_id)');
        $this->addSql('CREATE INDEX IDX_29299FD69331C741 ON paiement_niveau_etude_annee_scolaire (annee_scolaire_id)');
        $this->addSql('CREATE INDEX IDX_29299FD6B5B467BF ON paiement_niveau_etude_annee_scolaire (mensualite_id)');
        $this->addSql('CREATE TABLE paiement_scolarite_eleves (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, eleves_id INTEGER DEFAULT NULL, scolarite_paiement_id INTEGER DEFAULT NULL, montant_paier VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , commentaire CLOB DEFAULT NULL, html_facture CLOB DEFAULT NULL, CONSTRAINT FK_B21D38DCC2140342 FOREIGN KEY (eleves_id) REFERENCES eleves (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B21D38DC36A90093 FOREIGN KEY (scolarite_paiement_id) REFERENCES paiement_niveau_etude_annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B21D38DCC2140342 ON paiement_scolarite_eleves (eleves_id)');
        $this->addSql('CREATE INDEX IDX_B21D38DC36A90093 ON paiement_scolarite_eleves (scolarite_paiement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE paiement_niveau_etude_annee_scolaire');
        $this->addSql('DROP TABLE paiement_scolarite_eleves');
    }
}
