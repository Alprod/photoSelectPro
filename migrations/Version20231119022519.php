<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231119022519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE thematic_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE thematic (id INT NOT NULL, selection_process_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7C1CDF72660D626F ON thematic (selection_process_id)');
        $this->addSql('ALTER TABLE thematic ADD CONSTRAINT FK_7C1CDF72660D626F FOREIGN KEY (selection_process_id) REFERENCES selection_process (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE thematic_id_seq CASCADE');
        $this->addSql('ALTER TABLE thematic DROP CONSTRAINT FK_7C1CDF72660D626F');
        $this->addSql('DROP TABLE thematic');
    }
}
