<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231119033653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE group_final_selection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE group_final_selection (id INT NOT NULL, group_final_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E90488C1AE45752 ON group_final_selection (group_final_id)');
        $this->addSql('CREATE TABLE group_final_selection_binomial_final_selection (group_final_selection_id INT NOT NULL, binomial_final_selection_id INT NOT NULL, PRIMARY KEY(group_final_selection_id, binomial_final_selection_id))');
        $this->addSql('CREATE INDEX IDX_7FA1AC1546C17193 ON group_final_selection_binomial_final_selection (group_final_selection_id)');
        $this->addSql('CREATE INDEX IDX_7FA1AC1534A3EFD3 ON group_final_selection_binomial_final_selection (binomial_final_selection_id)');
        $this->addSql('ALTER TABLE group_final_selection ADD CONSTRAINT FK_E90488C1AE45752 FOREIGN KEY (group_final_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_final_selection_binomial_final_selection ADD CONSTRAINT FK_7FA1AC1546C17193 FOREIGN KEY (group_final_selection_id) REFERENCES group_final_selection (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_final_selection_binomial_final_selection ADD CONSTRAINT FK_7FA1AC1534A3EFD3 FOREIGN KEY (binomial_final_selection_id) REFERENCES binomial_final_selection (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE group_final_selection_id_seq CASCADE');
        $this->addSql('ALTER TABLE group_final_selection DROP CONSTRAINT FK_E90488C1AE45752');
        $this->addSql('ALTER TABLE group_final_selection_binomial_final_selection DROP CONSTRAINT FK_7FA1AC1546C17193');
        $this->addSql('ALTER TABLE group_final_selection_binomial_final_selection DROP CONSTRAINT FK_7FA1AC1534A3EFD3');
        $this->addSql('DROP TABLE group_final_selection');
        $this->addSql('DROP TABLE group_final_selection_binomial_final_selection');
    }
}
