<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190627162020 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bank_accounts (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE buyers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, nip VARCHAR(16) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX name_idx (name), INDEX nip_idx (nip), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoices (id INT AUTO_INCREMENT NOT NULL, buyer_id INT NOT NULL, number VARCHAR(64) NOT NULL, issue_date DATETIME NOT NULL, sale_date DATETIME NOT NULL, payment_date DATETIME NOT NULL, payment_method VARCHAR(16) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_6A2F2F956C755722 (buyer_id), UNIQUE INDEX number_idx (number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE items (id INT AUTO_INCREMENT NOT NULL, invoice_id INT NOT NULL, name VARCHAR(255) NOT NULL, amount INT NOT NULL, unit VARCHAR(255) NOT NULL, net_price NUMERIC(10, 2) NOT NULL, vat INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_E11EE94D2989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoices ADD CONSTRAINT FK_6A2F2F956C755722 FOREIGN KEY (buyer_id) REFERENCES buyers (id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D2989F1FD FOREIGN KEY (invoice_id) REFERENCES invoices (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE invoices DROP FOREIGN KEY FK_6A2F2F956C755722');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D2989F1FD');
        $this->addSql('DROP TABLE bank_accounts');
        $this->addSql('DROP TABLE buyers');
        $this->addSql('DROP TABLE invoices');
        $this->addSql('DROP TABLE items');
    }
}
