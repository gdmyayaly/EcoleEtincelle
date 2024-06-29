<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627100436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eleves (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, age VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, date_de_naissance VARCHAR(255) NOT NULL, is_deleted BOOLEAN NOT NULL, image VARCHAR(255) NOT NULL, commentaire VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE eleves_anne_scolaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, eleves_id INTEGER DEFAULT NULL, niveau_etude_id INTEGER DEFAULT NULL, annee_scolaire_id INTEGER DEFAULT NULL, CONSTRAINT FK_362437F5C2140342 FOREIGN KEY (eleves_id) REFERENCES eleves (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_362437F5FEAD13D1 FOREIGN KEY (niveau_etude_id) REFERENCES niveau_etude (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_362437F59331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_362437F5C2140342 ON eleves_anne_scolaire (eleves_id)');
        $this->addSql('CREATE INDEX IDX_362437F5FEAD13D1 ON eleves_anne_scolaire (niveau_etude_id)');
        $this->addSql('CREATE INDEX IDX_362437F59331C741 ON eleves_anne_scolaire (annee_scolaire_id)');
        $this->addSql('CREATE TABLE parents_eleves_link (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, eleves_id INTEGER DEFAULT NULL, parents_id INTEGER DEFAULT NULL, CONSTRAINT FK_23902C90C2140342 FOREIGN KEY (eleves_id) REFERENCES eleves (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_23902C90B706B6D3 FOREIGN KEY (parents_id) REFERENCES parent_eleves (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_23902C90C2140342 ON parents_eleves_link (eleves_id)');
        $this->addSql('CREATE INDEX IDX_23902C90B706B6D3 ON parents_eleves_link (parents_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE eleves');
        $this->addSql('DROP TABLE eleves_anne_scolaire');
        $this->addSql('DROP TABLE parents_eleves_link');
    }
}
