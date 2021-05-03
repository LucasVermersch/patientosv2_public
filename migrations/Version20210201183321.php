<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210201183321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient ADD password VARCHAR(255) NOT NULL, ADD roles JSON DEFAULT NULL, ADD is_verified TINYINT(1) NOT NULL, ADD photo_url VARCHAR(255) DEFAULT NULL, CHANGE age age INT DEFAULT NULL, CHANGE sexe sexe TINYINT(1) DEFAULT NULL, CHANGE adresse adresse LONGTEXT DEFAULT NULL, CHANGE ville ville VARCHAR(255) DEFAULT NULL, CHANGE code_postal code_postal INT DEFAULT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE telephone telephone INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EBE7927C74 ON patient (email)');
        $this->addSql('ALTER TABLE utilisateur ADD photo_url VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1ADAD7EBE7927C74 ON patient');
        $this->addSql('ALTER TABLE patient DROP password, DROP roles, DROP is_verified, DROP photo_url, CHANGE age age INT NOT NULL, CHANGE sexe sexe TINYINT(1) NOT NULL, CHANGE adresse adresse LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ville ville VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE code_postal code_postal INT NOT NULL, CHANGE email email LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP photo_url');
    }
}
