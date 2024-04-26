<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240426125542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initialize main tables.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE brand_models (id UUID NOT NULL, brand_id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_675E4C0744F5D008 ON brand_models (brand_id)');
        $this->addSql('COMMENT ON COLUMN brand_models.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN brand_models.brand_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE brands (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN brands.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE cities (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN cities.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE deal_features (id UUID NOT NULL, deal_id UUID NOT NULL, feature_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5C47CD89F60E2305 ON deal_features (deal_id)');
        $this->addSql('CREATE INDEX IDX_5C47CD8960E4B879 ON deal_features (feature_id)');
        $this->addSql('COMMENT ON COLUMN deal_features.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN deal_features.deal_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN deal_features.feature_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE deals (id UUID NOT NULL, city_id UUID NOT NULL, brand_id UUID NOT NULL, model_id UUID NOT NULL, owner_id UUID NOT NULL, title VARCHAR(255) NOT NULL, price INT NOT NULL, year INT NOT NULL, fuel_type VARCHAR(255) NOT NULL, transmission_type VARCHAR(255) NOT NULL, wheel_type VARCHAR(255) NOT NULL, condition_type VARCHAR(255) NOT NULL, coupe_type VARCHAR(255) NOT NULL, mileage INT NOT NULL, horse_power INT NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EF39849B8BAC62AF ON deals (city_id)');
        $this->addSql('CREATE INDEX IDX_EF39849B44F5D008 ON deals (brand_id)');
        $this->addSql('CREATE INDEX IDX_EF39849B7975B7E7 ON deals (model_id)');
        $this->addSql('CREATE INDEX IDX_EF39849B7E3C61F9 ON deals (owner_id)');
        $this->addSql('COMMENT ON COLUMN deals.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN deals.city_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN deals.brand_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN deals.model_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN deals.owner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE favourite_deals (id UUID NOT NULL, deal_id UUID NOT NULL, owner_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4E4C05EEF60E2305 ON favourite_deals (deal_id)');
        $this->addSql('CREATE INDEX IDX_4E4C05EE7E3C61F9 ON favourite_deals (owner_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E4C05EEF60E23057E3C61F9 ON favourite_deals (deal_id, owner_id)');
        $this->addSql('COMMENT ON COLUMN favourite_deals.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN favourite_deals.deal_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN favourite_deals.owner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE features (id UUID NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(30) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN features.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE users (id UUID NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, phone_number VARCHAR(12) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('COMMENT ON COLUMN users.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE brand_models ADD CONSTRAINT FK_675E4C0744F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deal_features ADD CONSTRAINT FK_5C47CD89F60E2305 FOREIGN KEY (deal_id) REFERENCES deals (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deal_features ADD CONSTRAINT FK_5C47CD8960E4B879 FOREIGN KEY (feature_id) REFERENCES features (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deals ADD CONSTRAINT FK_EF39849B8BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deals ADD CONSTRAINT FK_EF39849B44F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deals ADD CONSTRAINT FK_EF39849B7975B7E7 FOREIGN KEY (model_id) REFERENCES brand_models (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deals ADD CONSTRAINT FK_EF39849B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favourite_deals ADD CONSTRAINT FK_4E4C05EEF60E2305 FOREIGN KEY (deal_id) REFERENCES deals (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favourite_deals ADD CONSTRAINT FK_4E4C05EE7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE brand_models DROP CONSTRAINT FK_675E4C0744F5D008');
        $this->addSql('ALTER TABLE deal_features DROP CONSTRAINT FK_5C47CD89F60E2305');
        $this->addSql('ALTER TABLE deal_features DROP CONSTRAINT FK_5C47CD8960E4B879');
        $this->addSql('ALTER TABLE deals DROP CONSTRAINT FK_EF39849B8BAC62AF');
        $this->addSql('ALTER TABLE deals DROP CONSTRAINT FK_EF39849B44F5D008');
        $this->addSql('ALTER TABLE deals DROP CONSTRAINT FK_EF39849B7975B7E7');
        $this->addSql('ALTER TABLE deals DROP CONSTRAINT FK_EF39849B7E3C61F9');
        $this->addSql('ALTER TABLE favourite_deals DROP CONSTRAINT FK_4E4C05EEF60E2305');
        $this->addSql('ALTER TABLE favourite_deals DROP CONSTRAINT FK_4E4C05EE7E3C61F9');
        $this->addSql('DROP TABLE brand_models');
        $this->addSql('DROP TABLE brands');
        $this->addSql('DROP TABLE cities');
        $this->addSql('DROP TABLE deal_features');
        $this->addSql('DROP TABLE deals');
        $this->addSql('DROP TABLE favourite_deals');
        $this->addSql('DROP TABLE features');
        $this->addSql('DROP TABLE users');
    }
}
