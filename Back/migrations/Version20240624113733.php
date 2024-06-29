<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624113733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annee_scolaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, mois_start VARCHAR(255) NOT NULL, mois_end VARCHAR(255) NOT NULL, annee_start INTEGER NOT NULL, annee_end INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE annee_scolaire_mensualite (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, annee_scolaire_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_699EAA6F9331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_699EAA6F9331C741 ON annee_scolaire_mensualite (annee_scolaire_id)');
        $this->addSql('CREATE TABLE critere_evaluation_family (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, commentaire VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE niveau_etude (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, commentaire VARCHAR(255) DEFAULT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE annee_scolaire');
        $this->addSql('DROP TABLE annee_scolaire_mensualite');
        $this->addSql('DROP TABLE critere_evaluation_family');
        $this->addSql('DROP TABLE niveau_etude');
    }
}
