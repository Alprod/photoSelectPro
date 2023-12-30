<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231227131349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE identity ADD user_identity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE identity ADD CONSTRAINT FK_6A95E9C456251D3D FOREIGN KEY (user_identity_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6A95E9C456251D3D ON identity (user_identity_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE identity DROP CONSTRAINT FK_6A95E9C456251D3D');
        $this->addSql('DROP INDEX UNIQ_6A95E9C456251D3D');
        $this->addSql('ALTER TABLE identity DROP user_identity_id');
    }
}
