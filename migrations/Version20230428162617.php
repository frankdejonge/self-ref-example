<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428162617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE person_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE person (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN person.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE person_person (person_source UUID NOT NULL, person_target UUID NOT NULL, PRIMARY KEY(person_source, person_target))');
        $this->addSql('CREATE INDEX IDX_A879E1C0C32F4FC5 ON person_person (person_source)');
        $this->addSql('CREATE INDEX IDX_A879E1C0DACA1F4A ON person_person (person_target)');
        $this->addSql('COMMENT ON COLUMN person_person.person_source IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN person_person.person_target IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE person_person ADD CONSTRAINT FK_A879E1C0C32F4FC5 FOREIGN KEY (person_source) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_person ADD CONSTRAINT FK_A879E1C0DACA1F4A FOREIGN KEY (person_target) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE person_id_seq CASCADE');
        $this->addSql('ALTER TABLE person_person DROP CONSTRAINT FK_A879E1C0C32F4FC5');
        $this->addSql('ALTER TABLE person_person DROP CONSTRAINT FK_A879E1C0DACA1F4A');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE person_person');
        $this->addSql('ALTER TABLE domain_events ALTER id DROP DEFAULT');
    }
}
