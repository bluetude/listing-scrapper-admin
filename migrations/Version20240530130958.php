<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530130958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE listing_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE money_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE store_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE listing (id INT NOT NULL, product_id INT NOT NULL, money_id INT NOT NULL, link VARCHAR(255) NOT NULL, image_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CB0048D44584665A ON listing (product_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CB0048D4BF29332C ON listing (money_id)');
        $this->addSql('CREATE TABLE money (id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, currency VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, name VARCHAR(255) NOT NULL, search_term VARCHAR(255) DEFAULT NULL, max_price DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE store (id INT NOT NULL, name VARCHAR(255) NOT NULL, key VARCHAR(255) NOT NULL, base_url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE listing ADD CONSTRAINT FK_CB0048D44584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE listing ADD CONSTRAINT FK_CB0048D4BF29332C FOREIGN KEY (money_id) REFERENCES money (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE listing_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE money_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE store_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE listing DROP CONSTRAINT FK_CB0048D44584665A');
        $this->addSql('ALTER TABLE listing DROP CONSTRAINT FK_CB0048D4BF29332C');
        $this->addSql('DROP TABLE listing');
        $this->addSql('DROP TABLE money');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE store');
        $this->addSql('DROP TABLE "user"');
    }
}
