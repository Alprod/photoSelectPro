<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229124331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE binomial_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE binomial_final_selection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE binomial_pre_selection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "group_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE group_final_selection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE identity_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE photo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reset_password_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE selection_process_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE thematic_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE binomial (id INT NOT NULL, first_user_id INT DEFAULT NULL, second_user_id INT DEFAULT NULL, group_user_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_76F657CBB4E2BF69 ON binomial (first_user_id)');
        $this->addSql('CREATE INDEX IDX_76F657CBB02C53F8 ON binomial (second_user_id)');
        $this->addSql('CREATE INDEX IDX_76F657CB216E8799 ON binomial (group_user_id)');
        $this->addSql('CREATE TABLE binomial_final_selection (id INT NOT NULL, binomial_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7BD75D6A5A9F205D ON binomial_final_selection (binomial_id)');
        $this->addSql('CREATE TABLE binomial_final_selection_binomial_pre_selection (binomial_final_selection_id INT NOT NULL, binomial_pre_selection_id INT NOT NULL, PRIMARY KEY(binomial_final_selection_id, binomial_pre_selection_id))');
        $this->addSql('CREATE INDEX IDX_451E33C134A3EFD3 ON binomial_final_selection_binomial_pre_selection (binomial_final_selection_id)');
        $this->addSql('CREATE INDEX IDX_451E33C1927551D3 ON binomial_final_selection_binomial_pre_selection (binomial_pre_selection_id)');
        $this->addSql('CREATE TABLE binomial_pre_selection (id INT NOT NULL, binomial_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8FBD5B165A9F205D ON binomial_pre_selection (binomial_id)');
        $this->addSql('CREATE TABLE binomial_pre_selection_photo (binomial_pre_selection_id INT NOT NULL, photo_id INT NOT NULL, PRIMARY KEY(binomial_pre_selection_id, photo_id))');
        $this->addSql('CREATE INDEX IDX_1B2BD22927551D3 ON binomial_pre_selection_photo (binomial_pre_selection_id)');
        $this->addSql('CREATE INDEX IDX_1B2BD227E9E4C8C ON binomial_pre_selection_photo (photo_id)');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, contact_name VARCHAR(255) DEFAULT NULL, contact_email VARCHAR(255) DEFAULT NULL, ref_number VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN client.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "group" (id INT NOT NULL, thematic_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, max_person_by_group INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6DC044C52395FCED ON "group" (thematic_id)');
        $this->addSql('CREATE TABLE group_final_selection (id INT NOT NULL, group_final_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E90488C1AE45752 ON group_final_selection (group_final_id)');
        $this->addSql('CREATE TABLE group_final_selection_binomial_final_selection (group_final_selection_id INT NOT NULL, binomial_final_selection_id INT NOT NULL, PRIMARY KEY(group_final_selection_id, binomial_final_selection_id))');
        $this->addSql('CREATE INDEX IDX_7FA1AC1546C17193 ON group_final_selection_binomial_final_selection (group_final_selection_id)');
        $this->addSql('CREATE INDEX IDX_7FA1AC1534A3EFD3 ON group_final_selection_binomial_final_selection (binomial_final_selection_id)');
        $this->addSql('CREATE TABLE identity (id INT NOT NULL, user_identity_id INT DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, gender VARCHAR(20) DEFAULT NULL, service VARCHAR(255) DEFAULT NULL, job VARCHAR(255) DEFAULT NULL, avatar_filename VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6A95E9C456251D3D ON identity (user_identity_id)');
        $this->addSql('CREATE TABLE photo (id INT NOT NULL, client_id INT DEFAULT NULL, selection_process_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, filename VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_14B7841819EB6921 ON photo (client_id)');
        $this->addSql('CREATE INDEX IDX_14B78418660D626F ON photo (selection_process_id)');
        $this->addSql('CREATE TABLE reset_password_request (id INT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('COMMENT ON COLUMN reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE selection_process (id INT NOT NULL, client_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2EBABE7719EB6921 ON selection_process (client_id)');
        $this->addSql('COMMENT ON COLUMN selection_process.start_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN selection_process.end_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE thematic (id INT NOT NULL, selection_process_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7C1CDF72660D626F ON thematic (selection_process_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, client_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE INDEX IDX_8D93D64919EB6921 ON "user" (client_id)');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE binomial ADD CONSTRAINT FK_76F657CBB4E2BF69 FOREIGN KEY (first_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binomial ADD CONSTRAINT FK_76F657CBB02C53F8 FOREIGN KEY (second_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binomial ADD CONSTRAINT FK_76F657CB216E8799 FOREIGN KEY (group_user_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binomial_final_selection ADD CONSTRAINT FK_7BD75D6A5A9F205D FOREIGN KEY (binomial_id) REFERENCES binomial (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binomial_final_selection_binomial_pre_selection ADD CONSTRAINT FK_451E33C134A3EFD3 FOREIGN KEY (binomial_final_selection_id) REFERENCES binomial_final_selection (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binomial_final_selection_binomial_pre_selection ADD CONSTRAINT FK_451E33C1927551D3 FOREIGN KEY (binomial_pre_selection_id) REFERENCES binomial_pre_selection (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binomial_pre_selection ADD CONSTRAINT FK_8FBD5B165A9F205D FOREIGN KEY (binomial_id) REFERENCES binomial (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binomial_pre_selection_photo ADD CONSTRAINT FK_1B2BD22927551D3 FOREIGN KEY (binomial_pre_selection_id) REFERENCES binomial_pre_selection (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binomial_pre_selection_photo ADD CONSTRAINT FK_1B2BD227E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "group" ADD CONSTRAINT FK_6DC044C52395FCED FOREIGN KEY (thematic_id) REFERENCES thematic (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_final_selection ADD CONSTRAINT FK_E90488C1AE45752 FOREIGN KEY (group_final_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_final_selection_binomial_final_selection ADD CONSTRAINT FK_7FA1AC1546C17193 FOREIGN KEY (group_final_selection_id) REFERENCES group_final_selection (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_final_selection_binomial_final_selection ADD CONSTRAINT FK_7FA1AC1534A3EFD3 FOREIGN KEY (binomial_final_selection_id) REFERENCES binomial_final_selection (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE identity ADD CONSTRAINT FK_6A95E9C456251D3D FOREIGN KEY (user_identity_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B7841819EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418660D626F FOREIGN KEY (selection_process_id) REFERENCES selection_process (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE selection_process ADD CONSTRAINT FK_2EBABE7719EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE thematic ADD CONSTRAINT FK_7C1CDF72660D626F FOREIGN KEY (selection_process_id) REFERENCES selection_process (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D64919EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE binomial_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE binomial_final_selection_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE binomial_pre_selection_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "group_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE group_final_selection_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE identity_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE photo_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reset_password_request_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE selection_process_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE thematic_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE binomial DROP CONSTRAINT FK_76F657CBB4E2BF69');
        $this->addSql('ALTER TABLE binomial DROP CONSTRAINT FK_76F657CBB02C53F8');
        $this->addSql('ALTER TABLE binomial DROP CONSTRAINT FK_76F657CB216E8799');
        $this->addSql('ALTER TABLE binomial_final_selection DROP CONSTRAINT FK_7BD75D6A5A9F205D');
        $this->addSql('ALTER TABLE binomial_final_selection_binomial_pre_selection DROP CONSTRAINT FK_451E33C134A3EFD3');
        $this->addSql('ALTER TABLE binomial_final_selection_binomial_pre_selection DROP CONSTRAINT FK_451E33C1927551D3');
        $this->addSql('ALTER TABLE binomial_pre_selection DROP CONSTRAINT FK_8FBD5B165A9F205D');
        $this->addSql('ALTER TABLE binomial_pre_selection_photo DROP CONSTRAINT FK_1B2BD22927551D3');
        $this->addSql('ALTER TABLE binomial_pre_selection_photo DROP CONSTRAINT FK_1B2BD227E9E4C8C');
        $this->addSql('ALTER TABLE "group" DROP CONSTRAINT FK_6DC044C52395FCED');
        $this->addSql('ALTER TABLE group_final_selection DROP CONSTRAINT FK_E90488C1AE45752');
        $this->addSql('ALTER TABLE group_final_selection_binomial_final_selection DROP CONSTRAINT FK_7FA1AC1546C17193');
        $this->addSql('ALTER TABLE group_final_selection_binomial_final_selection DROP CONSTRAINT FK_7FA1AC1534A3EFD3');
        $this->addSql('ALTER TABLE identity DROP CONSTRAINT FK_6A95E9C456251D3D');
        $this->addSql('ALTER TABLE photo DROP CONSTRAINT FK_14B7841819EB6921');
        $this->addSql('ALTER TABLE photo DROP CONSTRAINT FK_14B78418660D626F');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE selection_process DROP CONSTRAINT FK_2EBABE7719EB6921');
        $this->addSql('ALTER TABLE thematic DROP CONSTRAINT FK_7C1CDF72660D626F');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64919EB6921');
        $this->addSql('DROP TABLE binomial');
        $this->addSql('DROP TABLE binomial_final_selection');
        $this->addSql('DROP TABLE binomial_final_selection_binomial_pre_selection');
        $this->addSql('DROP TABLE binomial_pre_selection');
        $this->addSql('DROP TABLE binomial_pre_selection_photo');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('DROP TABLE group_final_selection');
        $this->addSql('DROP TABLE group_final_selection_binomial_final_selection');
        $this->addSql('DROP TABLE identity');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE selection_process');
        $this->addSql('DROP TABLE thematic');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
