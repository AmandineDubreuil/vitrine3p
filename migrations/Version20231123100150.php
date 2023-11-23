<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231123100150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formations (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(100) NOT NULL, reference VARCHAR(50) NOT NULL, duree VARCHAR(50) NOT NULL, public VARCHAR(100) NOT NULL, prerequis VARCHAR(255) NOT NULL, tarif VARCHAR(100) NOT NULL, objectifs LONGTEXT NOT NULL, reussite VARCHAR(100) NOT NULL, satisfaction VARCHAR(100) NOT NULL, effectif VARCHAR(100) NOT NULL, cpf TINYINT(1) DEFAULT NULL, modalitepedago VARCHAR(255) NOT NULL, referentpedago VARCHAR(255) NOT NULL, validation VARCHAR(255) NOT NULL, acces VARCHAR(255) NOT NULL, moyenspedago VARCHAR(255) NOT NULL, documents VARCHAR(255) NOT NULL, referencesreglementaires VARCHAR(255) NOT NULL, programme LONGTEXT NOT NULL, photo VARCHAR(255) NOT NULL, modified_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE formations');
    }
}
