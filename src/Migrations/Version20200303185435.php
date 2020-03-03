<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200303185435 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE ad (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, is_on_sale BOOLEAN NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_77E0ED58F675F31B ON ad (author_id)');
        $this->addSql('CREATE TABLE ad_item (ad_id INTEGER NOT NULL, item_id INTEGER NOT NULL, PRIMARY KEY(ad_id, item_id))');
        $this->addSql('CREATE INDEX IDX_A7D4777B4F34D596 ON ad_item (ad_id)');
        $this->addSql('CREATE INDEX IDX_A7D4777B126F525E ON ad_item (item_id)');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_64C19C1727ACA70 ON category (parent_id)');
        $this->addSql('CREATE TABLE category_item (category_id INTEGER NOT NULL, item_id INTEGER NOT NULL, PRIMARY KEY(category_id, item_id))');
        $this->addSql('CREATE INDEX IDX_94805F5912469DE2 ON category_item (category_id)');
        $this->addSql('CREATE INDEX IDX_94805F59126F525E ON category_item (item_id)');
        $this->addSql('CREATE TABLE grade (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ad_id INTEGER NOT NULL, author_id INTEGER NOT NULL, value DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_595AAE344F34D596 ON grade (ad_id)');
        $this->addSql('CREATE INDEX IDX_595AAE34F675F31B ON grade (author_id)');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_id INTEGER DEFAULT NULL, url VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_C53D045F126F525E ON image (item_id)');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, is_visible BOOLEAN NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_1F1B251EF675F31B ON item (author_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE ad');
        $this->addSql('DROP TABLE ad_item');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_item');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE user');
    }
}
