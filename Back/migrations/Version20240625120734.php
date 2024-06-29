<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240625120734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE critere_evaluation_group (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, family_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_DD4C393FC35E566A FOREIGN KEY (family_id) REFERENCES critere_evaluation_family (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_DD4C393FC35E566A ON critere_evaluation_group (family_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE critere_evaluation_group');
    }
}
