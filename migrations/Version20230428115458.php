<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428115458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE domain_events (id BIGSERIAL NOT NULL, event_id UUID NOT NULL, aggregate_root_id UUID NOT NULL, version INT NOT NULL, payload TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX reconstitution ON domain_events (aggregate_root_id, version)');
        $this->addSql('COMMENT ON COLUMN domain_events.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN domain_events.aggregate_root_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE some_models (id INT NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE domain_events');
        $this->addSql('DROP TABLE some_models');
    }
}
