<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240623230148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__parent_eleves AS SELECT id, prenom, nom, telephone, email, adresse, profession, image, type, commentaire, is_deleted FROM parent_eleves');
        $this->addSql('DROP TABLE parent_eleves');
        $this->addSql('CREATE TABLE parent_eleves (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) NOT NULL, profession VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, sex VARCHAR(255) NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, is_deleted BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO parent_eleves (id, prenom, nom, telephone, email, adresse, profession, image, sex, commentaire, is_deleted) SELECT id, prenom, nom, telephone, email, adresse, profession, image, type, commentaire, is_deleted FROM __temp__parent_eleves');
        $this->addSql('DROP TABLE __temp__parent_eleves');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__parent_eleves AS SELECT id, prenom, nom, telephone, email, adresse, profession, image, sex, commentaire, is_deleted FROM parent_eleves');
        $this->addSql('DROP TABLE parent_eleves');
        $this->addSql('CREATE TABLE parent_eleves (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) NOT NULL, profession VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, is_deleted BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO parent_eleves (id, prenom, nom, telephone, email, adresse, profession, image, type, commentaire, is_deleted) SELECT id, prenom, nom, telephone, email, adresse, profession, image, sex, commentaire, is_deleted FROM __temp__parent_eleves');
        $this->addSql('DROP TABLE __temp__parent_eleves');
    }
}
