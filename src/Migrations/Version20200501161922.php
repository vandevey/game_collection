<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200501161922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_DAB6D856F675F31B');
        $this->addSql('DROP INDEX UNIQ_DAB6D856427EB8A5');
        $this->addSql('DROP INDEX UNIQ_DAB6D85653C674EE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item_ad AS SELECT id, offer_id, request_id, author_id, title, description, is_deleted, is_visible, created_at, updated_at FROM item_ad');
        $this->addSql('DROP TABLE item_ad');
        $this->addSql('CREATE TABLE item_ad (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, offer_id INTEGER DEFAULT NULL, request_id INTEGER DEFAULT NULL, author_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description VARCHAR(255) NOT NULL COLLATE BINARY, is_deleted BOOLEAN NOT NULL, is_visible BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_DAB6D85653C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_DAB6D856427EB8A5 FOREIGN KEY (request_id) REFERENCES request (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_DAB6D856F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO item_ad (id, offer_id, request_id, author_id, title, description, is_deleted, is_visible, created_at, updated_at) SELECT id, offer_id, request_id, author_id, title, description, is_deleted, is_visible, created_at, updated_at FROM __temp__item_ad');
        $this->addSql('DROP TABLE __temp__item_ad');
        $this->addSql('CREATE INDEX IDX_DAB6D856F675F31B ON item_ad (author_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DAB6D856427EB8A5 ON item_ad (request_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DAB6D85653C674EE ON item_ad (offer_id)');
        $this->addSql('DROP INDEX IDX_64C19C1727ACA70');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, parent_id, name, is_active, icon FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, is_active BOOLEAN NOT NULL, icon VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO category (id, parent_id, name, is_active, icon) SELECT id, parent_id, name, is_active, icon FROM __temp__category');
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
        $this->addSql('DROP INDEX IDX_C53D045F126F525E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, item_id, path FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_id INTEGER DEFAULT NULL, path VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_C53D045F126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO image (id, item_id, path) SELECT id, item_id, path FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE INDEX IDX_C53D045F126F525E ON image (item_id)');
        $this->addSql('DROP INDEX UNIQ_1F1B251E53C674EE');
        $this->addSql('DROP INDEX IDX_1F1B251EF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, author_id, offer_id, name, description, is_visible, created_at, updated_at FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, offer_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, is_visible BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_1F1B251EF675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1F1B251E53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO item (id, author_id, offer_id, name, description, is_visible, created_at, updated_at) SELECT id, author_id, offer_id, name, description, is_visible, created_at, updated_at FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F1B251E53C674EE ON item (offer_id)');
        $this->addSql('CREATE INDEX IDX_1F1B251EF675F31B ON item (author_id)');
        $this->addSql('DROP INDEX IDX_1FF134826593CE46');
        $this->addSql('DROP INDEX IDX_1FF13482F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item_ad_like AS SELECT id, author_id, item_ad_id, liked, created_at, updated_at FROM item_ad_like');
        $this->addSql('DROP TABLE item_ad_like');
        $this->addSql('CREATE TABLE item_ad_like (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, item_ad_id INTEGER DEFAULT NULL, liked BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_1FF13482F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1FF134826593CE46 FOREIGN KEY (item_ad_id) REFERENCES item_ad (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO item_ad_like (id, author_id, item_ad_id, liked, created_at, updated_at) SELECT id, author_id, item_ad_id, liked, created_at, updated_at FROM __temp__item_ad_like');
        $this->addSql('DROP TABLE __temp__item_ad_like');
        $this->addSql('CREATE INDEX IDX_1FF134826593CE46 ON item_ad_like (item_ad_id)');
        $this->addSql('CREATE INDEX IDX_1FF13482F675F31B ON item_ad_like (author_id)');
        $this->addSql('DROP INDEX IDX_B6BD307F8829462F');
        $this->addSql('DROP INDEX IDX_B6BD307FF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, author_id, message_thread_id, content, created_at FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, message_thread_id INTEGER DEFAULT NULL, content VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, CONSTRAINT FK_B6BD307FF675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6BD307F8829462F FOREIGN KEY (message_thread_id) REFERENCES message_thread (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO message (id, author_id, message_thread_id, content, created_at) SELECT id, author_id, message_thread_id, content, created_at FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307F8829462F ON message (message_thread_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FF675F31B ON message (author_id)');
        $this->addSql('DROP INDEX IDX_607D18C6593CE46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message_thread AS SELECT id, item_ad_id, created_at, updated_at FROM message_thread');
        $this->addSql('DROP TABLE message_thread');
        $this->addSql('CREATE TABLE message_thread (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_ad_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_607D18C6593CE46 FOREIGN KEY (item_ad_id) REFERENCES item_ad (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO message_thread (id, item_ad_id, created_at, updated_at) SELECT id, item_ad_id, created_at, updated_at FROM __temp__message_thread');
        $this->addSql('DROP TABLE __temp__message_thread');
        $this->addSql('CREATE INDEX IDX_607D18C6593CE46 ON message_thread (item_ad_id)');
        $this->addSql('DROP INDEX UNIQ_29D6873E6593CE46');
        $this->addSql('DROP INDEX UNIQ_29D6873E126F525E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__offer AS SELECT id, item_id, item_ad_id, price FROM offer');
        $this->addSql('DROP TABLE offer');
        $this->addSql('CREATE TABLE offer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_id INTEGER NOT NULL, item_ad_id INTEGER NOT NULL, price INTEGER NOT NULL, CONSTRAINT FK_29D6873E126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_29D6873E6593CE46 FOREIGN KEY (item_ad_id) REFERENCES item_ad (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO offer (id, item_id, item_ad_id, price) SELECT id, item_id, item_ad_id, price FROM __temp__offer');
        $this->addSql('DROP TABLE __temp__offer');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29D6873E6593CE46 ON offer (item_ad_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29D6873E126F525E ON offer (item_id)');
        $this->addSql('DROP INDEX UNIQ_3B978F9F6593CE46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__request AS SELECT id, item_ad_id, item_name, item_description, min_price, max_price FROM request');
        $this->addSql('DROP TABLE request');
        $this->addSql('CREATE TABLE request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_ad_id INTEGER NOT NULL, item_name VARCHAR(255) NOT NULL COLLATE BINARY, item_description VARCHAR(255) NOT NULL COLLATE BINARY, min_price INTEGER NOT NULL, max_price INTEGER DEFAULT NULL, CONSTRAINT FK_3B978F9F6593CE46 FOREIGN KEY (item_ad_id) REFERENCES item_ad (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO request (id, item_ad_id, item_name, item_description, min_price, max_price) SELECT id, item_ad_id, item_name, item_description, min_price, max_price FROM __temp__request');
        $this->addSql('DROP TABLE __temp__request');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B978F9F6593CE46 ON request (item_ad_id)');
        $this->addSql('DROP INDEX IDX_329937516593CE46');
        $this->addSql('DROP INDEX IDX_32993751F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__score AS SELECT id, author_id, item_ad_id, value, created_at, updated_at FROM score');
        $this->addSql('DROP TABLE score');
        $this->addSql('CREATE TABLE score (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, item_ad_id INTEGER DEFAULT NULL, value INTEGER NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_32993751F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_329937516593CE46 FOREIGN KEY (item_ad_id) REFERENCES item_ad (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO score (id, author_id, item_ad_id, value, created_at, updated_at) SELECT id, author_id, item_ad_id, value, created_at, updated_at FROM __temp__score');
        $this->addSql('DROP TABLE __temp__score');
        $this->addSql('CREATE INDEX IDX_329937516593CE46 ON score (item_ad_id)');
        $this->addSql('CREATE INDEX IDX_32993751F675F31B ON score (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_64C19C1727ACA70');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, parent_id, name, is_active, icon FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, icon VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO category (id, parent_id, name, is_active, icon) SELECT id, parent_id, name, is_active, icon FROM __temp__category');
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
        $this->addSql('DROP INDEX IDX_C53D045F126F525E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, item_id, path FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_id INTEGER DEFAULT NULL, path VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO image (id, item_id, path) SELECT id, item_id, path FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE INDEX IDX_C53D045F126F525E ON image (item_id)');
        $this->addSql('DROP INDEX IDX_1F1B251EF675F31B');
        $this->addSql('DROP INDEX UNIQ_1F1B251E53C674EE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, author_id, offer_id, name, description, is_visible, created_at, updated_at FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, offer_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, is_visible BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO item (id, author_id, offer_id, name, description, is_visible, created_at, updated_at) SELECT id, author_id, offer_id, name, description, is_visible, created_at, updated_at FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
        $this->addSql('CREATE INDEX IDX_1F1B251EF675F31B ON item (author_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F1B251E53C674EE ON item (offer_id)');
        $this->addSql('DROP INDEX UNIQ_DAB6D85653C674EE');
        $this->addSql('DROP INDEX UNIQ_DAB6D856427EB8A5');
        $this->addSql('DROP INDEX IDX_DAB6D856F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item_ad AS SELECT id, offer_id, request_id, author_id, title, description, is_deleted, is_visible, created_at, updated_at FROM item_ad');
        $this->addSql('DROP TABLE item_ad');
        $this->addSql('CREATE TABLE item_ad (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, offer_id INTEGER DEFAULT NULL, request_id INTEGER DEFAULT NULL, author_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, is_deleted BOOLEAN NOT NULL, is_visible BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO item_ad (id, offer_id, request_id, author_id, title, description, is_deleted, is_visible, created_at, updated_at) SELECT id, offer_id, request_id, author_id, title, description, is_deleted, is_visible, created_at, updated_at FROM __temp__item_ad');
        $this->addSql('DROP TABLE __temp__item_ad');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DAB6D85653C674EE ON item_ad (offer_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DAB6D856427EB8A5 ON item_ad (request_id)');
        $this->addSql('CREATE INDEX IDX_DAB6D856F675F31B ON item_ad (author_id)');
        $this->addSql('DROP INDEX IDX_1FF13482F675F31B');
        $this->addSql('DROP INDEX IDX_1FF134826593CE46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item_ad_like AS SELECT id, author_id, item_ad_id, liked, created_at, updated_at FROM item_ad_like');
        $this->addSql('DROP TABLE item_ad_like');
        $this->addSql('CREATE TABLE item_ad_like (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, item_ad_id INTEGER DEFAULT NULL, liked BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO item_ad_like (id, author_id, item_ad_id, liked, created_at, updated_at) SELECT id, author_id, item_ad_id, liked, created_at, updated_at FROM __temp__item_ad_like');
        $this->addSql('DROP TABLE __temp__item_ad_like');
        $this->addSql('CREATE INDEX IDX_1FF13482F675F31B ON item_ad_like (author_id)');
        $this->addSql('CREATE INDEX IDX_1FF134826593CE46 ON item_ad_like (item_ad_id)');
        $this->addSql('DROP INDEX IDX_B6BD307FF675F31B');
        $this->addSql('DROP INDEX IDX_B6BD307F8829462F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, author_id, message_thread_id, content, created_at FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, message_thread_id INTEGER DEFAULT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO message (id, author_id, message_thread_id, content, created_at) SELECT id, author_id, message_thread_id, content, created_at FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307FF675F31B ON message (author_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F8829462F ON message (message_thread_id)');
        $this->addSql('DROP INDEX IDX_607D18C6593CE46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message_thread AS SELECT id, item_ad_id, created_at, updated_at FROM message_thread');
        $this->addSql('DROP TABLE message_thread');
        $this->addSql('CREATE TABLE message_thread (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_ad_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO message_thread (id, item_ad_id, created_at, updated_at) SELECT id, item_ad_id, created_at, updated_at FROM __temp__message_thread');
        $this->addSql('DROP TABLE __temp__message_thread');
        $this->addSql('CREATE INDEX IDX_607D18C6593CE46 ON message_thread (item_ad_id)');
        $this->addSql('DROP INDEX UNIQ_29D6873E126F525E');
        $this->addSql('DROP INDEX UNIQ_29D6873E6593CE46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__offer AS SELECT id, item_id, item_ad_id, price FROM offer');
        $this->addSql('DROP TABLE offer');
        $this->addSql('CREATE TABLE offer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_id INTEGER NOT NULL, item_ad_id INTEGER NOT NULL, price INTEGER NOT NULL)');
        $this->addSql('INSERT INTO offer (id, item_id, item_ad_id, price) SELECT id, item_id, item_ad_id, price FROM __temp__offer');
        $this->addSql('DROP TABLE __temp__offer');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29D6873E126F525E ON offer (item_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29D6873E6593CE46 ON offer (item_ad_id)');
        $this->addSql('DROP INDEX UNIQ_3B978F9F6593CE46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__request AS SELECT id, item_ad_id, item_name, item_description, min_price, max_price FROM request');
        $this->addSql('DROP TABLE request');
        $this->addSql('CREATE TABLE request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_ad_id INTEGER NOT NULL, item_name VARCHAR(255) NOT NULL, item_description VARCHAR(255) NOT NULL, min_price INTEGER NOT NULL, max_price INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO request (id, item_ad_id, item_name, item_description, min_price, max_price) SELECT id, item_ad_id, item_name, item_description, min_price, max_price FROM __temp__request');
        $this->addSql('DROP TABLE __temp__request');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B978F9F6593CE46 ON request (item_ad_id)');
        $this->addSql('DROP INDEX IDX_32993751F675F31B');
        $this->addSql('DROP INDEX IDX_329937516593CE46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__score AS SELECT id, author_id, item_ad_id, value, created_at, updated_at FROM score');
        $this->addSql('DROP TABLE score');
        $this->addSql('CREATE TABLE score (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, item_ad_id INTEGER DEFAULT NULL, value INTEGER NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO score (id, author_id, item_ad_id, value, created_at, updated_at) SELECT id, author_id, item_ad_id, value, created_at, updated_at FROM __temp__score');
        $this->addSql('DROP TABLE __temp__score');
        $this->addSql('CREATE INDEX IDX_32993751F675F31B ON score (author_id)');
        $this->addSql('CREATE INDEX IDX_329937516593CE46 ON score (item_ad_id)');
    }
}
