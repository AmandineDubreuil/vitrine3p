<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124142435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipes CHANGE fonction fonction VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE formations CHANGE referencesreglementaires referencesreglementaires VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formations CHANGE referencesreglementaires referencesreglementaires VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE equipes CHANGE fonction fonction VARCHAR(100) NOT NULL');
    }
}
