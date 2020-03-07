<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200307091954 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE ad_item');
        $this->addSql('DROP INDEX IDX_77E0ED58F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ad AS SELECT id, author_id, title, description, price, is_on_sale, created_at, update_at FROM ad');
        $this->addSql('DROP TABLE ad');
        $this->addSql('CREATE TABLE ad (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, item_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description VARCHAR(255) NOT NULL COLLATE BINARY, price DOUBLE PRECISION DEFAULT NULL, is_on_sale BOOLEAN NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, CONSTRAINT FK_77E0ED58126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_77E0ED58F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO ad (id, author_id, title, description, price, is_on_sale, created_at, update_at) SELECT id, author_id, title, description, price, is_on_sale, created_at, update_at FROM __temp__ad');
        $this->addSql('DROP TABLE __temp__ad');
        $this->addSql('CREATE INDEX IDX_77E0ED58F675F31B ON ad (author_id)');
        $this->addSql('CREATE INDEX IDX_77E0ED58126F525E ON ad (item_id)');
        $this->addSql('DROP INDEX IDX_64C19C1727ACA70');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, parent_id, name, is_active FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, is_active BOOLEAN NOT NULL, CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO category (id, parent_id, name, is_active) SELECT id, parent_id, name, is_active FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('CREATE INDEX IDX_64C19C1727ACA70 ON category (parent_id)');
        $this->addSql('DROP INDEX IDX_94805F59126F525E');
        $this->addSql('DROP INDEX IDX_94805F5912469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_item AS SELECT category_id, item_id FROM category_item');
        $this->addSql('DROP TABLE category_item');
        $this->addSql('CREATE TABLE category_item (category_id INTEGER NOT NULL, item_id INTEGER NOT NULL, PRIMARY KEY(category_id, item_id), CONSTRAINT FK_94805F5912469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_94805F59126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO category_item (category_id, item_id) SELECT category_id, item_id FROM __temp__category_item');
        $this->addSql('DROP TABLE __temp__category_item');
        $this->addSql('CREATE INDEX IDX_94805F59126F525E ON category_item (item_id)');
        $this->addSql('CREATE INDEX IDX_94805F5912469DE2 ON category_item (category_id)');
        $this->addSql('DROP INDEX IDX_595AAE34F675F31B');
        $this->addSql('DROP INDEX IDX_595AAE344F34D596');
        $this->addSql('CREATE TEMPORARY TABLE __temp__grade AS SELECT id, ad_id, author_id, value, created_at, updated_at FROM grade');
        $this->addSql('DROP TABLE grade');
        $this->addSql('CREATE TABLE grade (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ad_id INTEGER NOT NULL, author_id INTEGER NOT NULL, value DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_595AAE344F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_595AAE34F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO grade (id, ad_id, author_id, value, created_at, updated_at) SELECT id, ad_id, author_id, value, created_at, updated_at FROM __temp__grade');
        $this->addSql('DROP TABLE __temp__grade');
        $this->addSql('CREATE INDEX IDX_595AAE34F675F31B ON grade (author_id)');
        $this->addSql('CREATE INDEX IDX_595AAE344F34D596 ON grade (ad_id)');
        $this->addSql('DROP INDEX IDX_C53D045F126F525E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, item_id, url FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_id INTEGER DEFAULT NULL, url VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_C53D045F126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO image (id, item_id, url) SELECT id, item_id, url FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE INDEX IDX_C53D045F126F525E ON image (item_id)');
        $this->addSql('DROP INDEX IDX_1F1B251EF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, author_id, name, description, is_visible, created_at, update_at FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, is_visible BOOLEAN NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, CONSTRAINT FK_1F1B251EF675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO item (id, author_id, name, description, is_visible, created_at, update_at) SELECT id, author_id, name, description, is_visible, created_at, update_at FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
        $this->addSql('CREATE INDEX IDX_1F1B251EF675F31B ON item (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE ad_item (ad_id INTEGER NOT NULL, item_id INTEGER NOT NULL, PRIMARY KEY(ad_id, item_id))');
        $this->addSql('CREATE INDEX IDX_A7D4777B126F525E ON ad_item (item_id)');
        $this->addSql('CREATE INDEX IDX_A7D4777B4F34D596 ON ad_item (ad_id)');
        $this->addSql('DROP INDEX IDX_77E0ED58126F525E');
        $this->addSql('DROP INDEX IDX_77E0ED58F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ad AS SELECT id, author_id, title, description, price, is_on_sale, created_at, update_at FROM ad');
        $this->addSql('DROP TABLE ad');
        $this->addSql('CREATE TABLE ad (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, is_on_sale BOOLEAN NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO ad (id, author_id, title, description, price, is_on_sale, created_at, update_at) SELECT id, author_id, title, description, price, is_on_sale, created_at, update_at FROM __temp__ad');
        $this->addSql('DROP TABLE __temp__ad');
        $this->addSql('CREATE INDEX IDX_77E0ED58F675F31B ON ad (author_id)');
        $this->addSql('DROP INDEX IDX_64C19C1727ACA70');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, parent_id, name, is_active FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO category (id, parent_id, name, is_active) SELECT id, parent_id, name, is_active FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('CREATE INDEX IDX_64C19C1727ACA70 ON category (parent_id)');
        $this->addSql('DROP INDEX IDX_94805F5912469DE2');
        $this->addSql('DROP INDEX IDX_94805F59126F525E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_item AS SELECT category_id, item_id FROM category_item');
        $this->addSql('DROP TABLE category_item');
        $this->addSql('CREATE TABLE category_item (category_id INTEGER NOT NULL, item_id INTEGER NOT NULL, PRIMARY KEY(category_id, item_id))');
        $this->addSql('INSERT INTO category_item (category_id, item_id) SELECT category_id, item_id FROM __temp__category_item');
        $this->addSql('DROP TABLE __temp__category_item');
        $this->addSql('CREATE INDEX IDX_94805F5912469DE2 ON category_item (category_id)');
        $this->addSql('CREATE INDEX IDX_94805F59126F525E ON category_item (item_id)');
        $this->addSql('DROP INDEX IDX_595AAE344F34D596');
        $this->addSql('DROP INDEX IDX_595AAE34F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__grade AS SELECT id, ad_id, author_id, value, created_at, updated_at FROM grade');
        $this->addSql('DROP TABLE grade');
        $this->addSql('CREATE TABLE grade (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ad_id INTEGER NOT NULL, author_id INTEGER NOT NULL, value DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO grade (id, ad_id, author_id, value, created_at, updated_at) SELECT id, ad_id, author_id, value, created_at, updated_at FROM __temp__grade');
        $this->addSql('DROP TABLE __temp__grade');
        $this->addSql('CREATE INDEX IDX_595AAE344F34D596 ON grade (ad_id)');
        $this->addSql('CREATE INDEX IDX_595AAE34F675F31B ON grade (author_id)');
        $this->addSql('DROP INDEX IDX_C53D045F126F525E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, item_id, url FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_id INTEGER DEFAULT NULL, url VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO image (id, item_id, url) SELECT id, item_id, url FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE INDEX IDX_C53D045F126F525E ON image (item_id)');
        $this->addSql('DROP INDEX IDX_1F1B251EF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, author_id, name, description, is_visible, created_at, update_at FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, is_visible BOOLEAN NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO item (id, author_id, name, description, is_visible, created_at, update_at) SELECT id, author_id, name, description, is_visible, created_at, update_at FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
        $this->addSql('CREATE INDEX IDX_1F1B251EF675F31B ON item (author_id)');
    }
}
