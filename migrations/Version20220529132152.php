<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220529132152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE business_contacts (id INT AUTO_INCREMENT NOT NULL, company_name VARCHAR(100) DEFAULT NULL, log VARCHAR(22) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, mobile_number VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, industry VARCHAR(255) DEFAULT NULL, address1 VARCHAR(255) DEFAULT NULL, address2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, province VARCHAR(100) DEFAULT NULL, country VARCHAR(100) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_us (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) DEFAULT NULL, last_name VARCHAR(100) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, subject VARCHAR(255) DEFAULT NULL, body LONGTEXT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, business_name VARCHAR(100) NOT NULL, contact_person VARCHAR(100) NOT NULL, mobile_number INT NOT NULL, email VARCHAR(150) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(100) NOT NULL, country VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense (id INT AUTO_INCREMENT NOT NULL, supplier VARCHAR(100) NOT NULL, date DATETIME NOT NULL, description VARCHAR(255) NOT NULL, quantity VARCHAR(100) NOT NULL, price INT NOT NULL, amount INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq (id INT AUTO_INCREMENT NOT NULL, question LONGTEXT DEFAULT NULL, answer LONGTEXT DEFAULT NULL, status VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, image_path VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, excerpt VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, string VARCHAR(20) DEFAULT NULL, status VARCHAR(255) NOT NULL, published_at DATETIME NOT NULL, view_count INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', price INT NOT NULL, vat INT NOT NULL, price_with_vat INT NOT NULL, product_image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, avatar VARCHAR(255) DEFAULT NULL, about LONGTEXT DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, linkedin VARCHAR(255) DEFAULT NULL, intagram VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, id_number INT DEFAULT NULL, gender VARCHAR(10) DEFAULT NULL, first_name VARCHAR(100) DEFAULT NULL, last_name VARCHAR(100) DEFAULT NULL, country VARCHAR(100) DEFAULT NULL, province VARCHAR(100) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, nrc_front VARCHAR(255) DEFAULT NULL, nrc_back VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, assignee VARCHAR(100) DEFAULT NULL, status VARCHAR(100) DEFAULT NULL, category VARCHAR(100) DEFAULT NULL, technologies VARCHAR(255) DEFAULT NULL, client VARCHAR(100) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, image_path VARCHAR(255) DEFAULT NULL, slide1 VARCHAR(255) DEFAULT NULL, slide2 VARCHAR(255) DEFAULT NULL, slide3 VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale (id INT AUTO_INCREMENT NOT NULL, customer_name VARCHAR(100) NOT NULL, date DATETIME NOT NULL, product VARCHAR(100) NOT NULL, quantity INT NOT NULL, price INT NOT NULL, amount_with_vat INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, icon VARCHAR(100) DEFAULT NULL, title VARCHAR(100) DEFAULT NULL, excerpt VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, status VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site_settings (id INT AUTO_INCREMENT NOT NULL, site_title VARCHAR(100) DEFAULT NULL, site_name VARCHAR(50) DEFAULT NULL, company_name VARCHAR(100) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, contact_number VARCHAR(100) DEFAULT NULL, contact_email VARCHAR(100) DEFAULT NULL, address1 VARCHAR(100) DEFAULT NULL, address2 VARCHAR(100) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, country VARCHAR(100) DEFAULT NULL, business_hours VARCHAR(50) DEFAULT NULL, facebook VARCHAR(100) DEFAULT NULL, twitter VARCHAR(100) DEFAULT NULL, linkedin VARCHAR(100) NOT NULL, instagram VARCHAR(100) DEFAULT NULL, whatsapp VARCHAR(100) DEFAULT NULL, skype VARCHAR(100) DEFAULT NULL, github VARCHAR(100) DEFAULT NULL, youtube VARCHAR(100) DEFAULT NULL, about LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id INT AUTO_INCREMENT NOT NULL, business_name VARCHAR(150) NOT NULL, contact_person VARCHAR(150) NOT NULL, mobile_number INT NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(100) NOT NULL, country VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, image_path VARCHAR(255) DEFAULT NULL, first_name VARCHAR(100) DEFAULT NULL, last_name VARCHAR(100) DEFAULT NULL, job_title VARCHAR(100) DEFAULT NULL, about LONGTEXT DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, linkedin VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE testimonial (id INT AUTO_INCREMENT NOT NULL, avatar VARCHAR(255) DEFAULT NULL, name VARCHAR(100) DEFAULT NULL, occupation VARCHAR(100) DEFAULT NULL, about LONGTEXT DEFAULT NULL, status VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, txn_date DATETIME NOT NULL, customer_name VARCHAR(100) NOT NULL, txn_type VARCHAR(100) NOT NULL, txn_id INT NOT NULL, amount INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(180) NOT NULL, last_name VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, mobile_number INT NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649A9D1C132 (first_name), UNIQUE INDEX UNIQ_8D93D649C808BA5A (last_name), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE business_contacts');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE contact_us');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE expense');
        $this->addSql('DROP TABLE faq');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE sale');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE site_settings');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE testimonial');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE user');
    }
}
