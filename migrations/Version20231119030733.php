<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231119030733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE binomial_pre_selection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE binomial_pre_selection (id INT NOT NULL, binomial_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8FBD5B165A9F205D ON binomial_pre_selection (binomial_id)');
        $this->addSql('CREATE TABLE binomial_pre_selection_photo (binomial_pre_selection_id INT NOT NULL, photo_id INT NOT NULL, PRIMARY KEY(binomial_pre_selection_id, photo_id))');
        $this->addSql('CREATE INDEX IDX_1B2BD22927551D3 ON binomial_pre_selection_photo (binomial_pre_selection_id)');
        $this->addSql('CREATE INDEX IDX_1B2BD227E9E4C8C ON binomial_pre_selection_photo (photo_id)');
        $this->addSql('ALTER TABLE binomial_pre_selection ADD CONSTRAINT FK_8FBD5B165A9F205D FOREIGN KEY (binomial_id) REFERENCES binomial (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binomial_pre_selection_photo ADD CONSTRAINT FK_1B2BD22927551D3 FOREIGN KEY (binomial_pre_selection_id) REFERENCES binomial_pre_selection (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binomial_pre_selection_photo ADD CONSTRAINT FK_1B2BD227E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE binomial_pre_selection_id_seq CASCADE');
        $this->addSql('ALTER TABLE binomial_pre_selection DROP CONSTRAINT FK_8FBD5B165A9F205D');
        $this->addSql('ALTER TABLE binomial_pre_selection_photo DROP CONSTRAINT FK_1B2BD22927551D3');
        $this->addSql('ALTER TABLE binomial_pre_selection_photo DROP CONSTRAINT FK_1B2BD227E9E4C8C');
        $this->addSql('DROP TABLE binomial_pre_selection');
        $this->addSql('DROP TABLE binomial_pre_selection_photo');
    }
}
