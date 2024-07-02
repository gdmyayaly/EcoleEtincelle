<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240629132436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evaluation_annuel_eleves (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, eleve_id INTEGER DEFAULT NULL, annee_scolaire_id INTEGER DEFAULT NULL, html_report CLOB DEFAULT NULL, CONSTRAINT FK_5578A2CBA6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleves (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5578A2CB9331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5578A2CBA6CC7B2 ON evaluation_annuel_eleves (eleve_id)');
        $this->addSql('CREATE INDEX IDX_5578A2CB9331C741 ON evaluation_annuel_eleves (annee_scolaire_id)');
        $this->addSql('CREATE TABLE notes_evaluation_annuel_eleves (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, evaluation_annuel_eleves_id INTEGER DEFAULT NULL, question CLOB NOT NULL, tag_reponse VARCHAR(255) NOT NULL, reponse CLOB NOT NULL, CONSTRAINT FK_7DF9CC439549BA1 FOREIGN KEY (evaluation_annuel_eleves_id) REFERENCES evaluation_annuel_eleves (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_7DF9CC439549BA1 ON notes_evaluation_annuel_eleves (evaluation_annuel_eleves_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE evaluation_annuel_eleves');
        $this->addSql('DROP TABLE notes_evaluation_annuel_eleves');
    }
}
