<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231007092235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE air_drop DROP pict');
        $this->addSql('ALTER TABLE collecs DROP cover_pict, DROP avatar_pict');
        $this->addSql('ALTER TABLE nft DROP pict');
        $this->addSql('ALTER TABLE user DROP avatar');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE air_drop ADD pict VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD avatar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE collecs ADD cover_pict VARCHAR(255) DEFAULT NULL, ADD avatar_pict VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE nft ADD pict VARCHAR(255) NOT NULL');
    }
}
