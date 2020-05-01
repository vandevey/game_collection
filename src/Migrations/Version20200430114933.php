<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200430114933 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, icon VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_64C19C1727ACA70 ON category (parent_id)');
        $this->addSql('CREATE TABLE category_item (category_id INTEGER NOT NULL, item_id INTEGER NOT NULL, PRIMARY KEY(category_id, item_id))');
        $this->addSql('CREATE INDEX IDX_94805F5912469DE2 ON category_item (category_id)');
        $this->addSql('CREATE INDEX IDX_94805F59126F525E ON category_item (item_id)');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_id INTEGER DEFAULT NULL, "key" VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_C53D045F126F525E ON image (item_id)');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, offer_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, is_visible BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_1F1B251EF675F31B ON item (author_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F1B251E53C674EE ON item (offer_id)');
        $this->addSql('CREATE TABLE item_ad (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, offer_id INTEGER DEFAULT NULL, request_id INTEGER DEFAULT NULL, author_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, is_deleted BOOLEAN NOT NULL, is_visible BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DAB6D85653C674EE ON item_ad (offer_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DAB6D856427EB8A5 ON item_ad (request_id)');
        $this->addSql('CREATE INDEX IDX_DAB6D856F675F31B ON item_ad (author_id)');
        $this->addSql('CREATE TABLE item_ad_like (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, item_ad_id INTEGER DEFAULT NULL, liked BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_1FF13482F675F31B ON item_ad_like (author_id)');
        $this->addSql('CREATE INDEX IDX_1FF134826593CE46 ON item_ad_like (item_ad_id)');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, message_thread_id INTEGER DEFAULT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_B6BD307FF675F31B ON message (author_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F8829462F ON message (message_thread_id)');
        $this->addSql('CREATE TABLE message_thread (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_ad_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_607D18C6593CE46 ON message_thread (item_ad_id)');
        $this->addSql('CREATE TABLE offer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_id INTEGER NOT NULL, item_ad_id INTEGER NOT NULL, price INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29D6873E126F525E ON offer (item_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29D6873E6593CE46 ON offer (item_ad_id)');
        $this->addSql('CREATE TABLE request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_ad_id INTEGER NOT NULL, item_name VARCHAR(255) NOT NULL, item_description VARCHAR(255) NOT NULL, min_price INTEGER NOT NULL, max_price INTEGER DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B978F9F6593CE46 ON request (item_ad_id)');
        $this->addSql('CREATE TABLE score (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, item_ad_id INTEGER DEFAULT NULL, value INTEGER NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_32993751F675F31B ON score (author_id)');
        $this->addSql('CREATE INDEX IDX_329937516593CE46 ON score (item_ad_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, is_deleted BOOLEAN NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_item');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_ad');
        $this->addSql('DROP TABLE item_ad_like');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_thread');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE request');
        $this->addSql('DROP TABLE score');
        $this->addSql('DROP TABLE user');
    }
}
