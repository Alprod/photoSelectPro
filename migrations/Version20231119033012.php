<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231119033012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE binomial_final_selection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE binomial_final_selection (id INT NOT NULL, binomial_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7BD75D6A5A9F205D ON binomial_final_selection (binomial_id)');
        $this->addSql('CREATE TABLE binomial_final_selection_binomial_pre_selection (binomial_final_selection_id INT NOT NULL, binomial_pre_selection_id INT NOT NULL, PRIMARY KEY(binomial_final_selection_id, binomial_pre_selection_id))');
        $this->addSql('CREATE INDEX IDX_451E33C134A3EFD3 ON binomial_final_selection_binomial_pre_selection (binomial_final_selection_id)');
        $this->addSql('CREATE INDEX IDX_451E33C1927551D3 ON binomial_final_selection_binomial_pre_selection (binomial_pre_selection_id)');
        $this->addSql('ALTER TABLE binomial_final_selection ADD CONSTRAINT FK_7BD75D6A5A9F205D FOREIGN KEY (binomial_id) REFERENCES binomial (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binomial_final_selection_binomial_pre_selection ADD CONSTRAINT FK_451E33C134A3EFD3 FOREIGN KEY (binomial_final_selection_id) REFERENCES binomial_final_selection (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binomial_final_selection_binomial_pre_selection ADD CONSTRAINT FK_451E33C1927551D3 FOREIGN KEY (binomial_pre_selection_id) REFERENCES binomial_pre_selection (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE binomial_final_selection_id_seq CASCADE');
        $this->addSql('ALTER TABLE binomial_final_selection DROP CONSTRAINT FK_7BD75D6A5A9F205D');
        $this->addSql('ALTER TABLE binomial_final_selection_binomial_pre_selection DROP CONSTRAINT FK_451E33C134A3EFD3');
        $this->addSql('ALTER TABLE binomial_final_selection_binomial_pre_selection DROP CONSTRAINT FK_451E33C1927551D3');
        $this->addSql('DROP TABLE binomial_final_selection');
        $this->addSql('DROP TABLE binomial_final_selection_binomial_pre_selection');
    }
}
