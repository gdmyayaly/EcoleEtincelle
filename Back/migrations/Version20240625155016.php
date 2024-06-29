<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240625155016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE criteres_evaluations (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, family_group_id INTEGER DEFAULT NULL, question CLOB NOT NULL, fait_seul CLOB NOT NULL, ne_fait_pas CLOB NOT NULL, fait_avec_de_laide CLOB NOT NULL, non_evaluer CLOB DEFAULT NULL, CONSTRAINT FK_77EE6FB23CEE3234 FOREIGN KEY (family_group_id) REFERENCES critere_evaluation_group (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_77EE6FB23CEE3234 ON criteres_evaluations (family_group_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE criteres_evaluations');
    }
}
