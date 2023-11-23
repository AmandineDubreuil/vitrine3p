<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231123140417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formations ADD referentpedagogique_id INT DEFAULT NULL, DROP referentpedago');
        $this->addSql('ALTER TABLE formations ADD CONSTRAINT FK_40902137F088096A FOREIGN KEY (referentpedagogique_id) REFERENCES equipes (id)');
        $this->addSql('CREATE INDEX IDX_40902137F088096A ON formations (referentpedagogique_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formations DROP FOREIGN KEY FK_40902137F088096A');
        $this->addSql('DROP INDEX IDX_40902137F088096A ON formations');
        $this->addSql('ALTER TABLE formations ADD referentpedago VARCHAR(255) NOT NULL, DROP referentpedagogique_id');
    }
}
