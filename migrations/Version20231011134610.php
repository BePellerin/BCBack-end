<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231011134610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE air_drop CHANGE name name VARCHAR(50) NOT NULL, CHANGE description description VARCHAR(750) NOT NULL');
        $this->addSql('ALTER TABLE collecs CHANGE title title VARCHAR(50) NOT NULL, CHANGE description description VARCHAR(750) NOT NULL');
        $this->addSql('ALTER TABLE nft CHANGE title title VARCHAR(50) NOT NULL, CHANGE description description VARCHAR(750) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE air_drop CHANGE name name VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE nft CHANGE title title VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(300) DEFAULT NULL');
        $this->addSql('ALTER TABLE collecs CHANGE title title VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(500) NOT NULL');
    }
}
