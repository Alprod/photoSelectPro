<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231119024257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE binomial_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE binomial (id INT NOT NULL, first_user_id INT DEFAULT NULL, second_user_id INT DEFAULT NULL, group_user_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_76F657CBB4E2BF69 ON binomial (first_user_id)');
        $this->addSql('CREATE INDEX IDX_76F657CBB02C53F8 ON binomial (second_user_id)');
        $this->addSql('CREATE INDEX IDX_76F657CB216E8799 ON binomial (group_user_id)');
        $this->addSql('ALTER TABLE binomial ADD CONSTRAINT FK_76F657CBB4E2BF69 FOREIGN KEY (first_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binomial ADD CONSTRAINT FK_76F657CBB02C53F8 FOREIGN KEY (second_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binomial ADD CONSTRAINT FK_76F657CB216E8799 FOREIGN KEY (group_user_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE binomial_id_seq CASCADE');
        $this->addSql('ALTER TABLE binomial DROP CONSTRAINT FK_76F657CBB4E2BF69');
        $this->addSql('ALTER TABLE binomial DROP CONSTRAINT FK_76F657CBB02C53F8');
        $this->addSql('ALTER TABLE binomial DROP CONSTRAINT FK_76F657CB216E8799');
        $this->addSql('DROP TABLE binomial');
    }
}
