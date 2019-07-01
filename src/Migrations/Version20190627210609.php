<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190627210609 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE invoices ADD bank_account_id INT DEFAULT NULL, CHANGE payment_date payment_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE invoices ADD CONSTRAINT FK_6A2F2F9512CB990C FOREIGN KEY (bank_account_id) REFERENCES bank_accounts (id)');
        $this->addSql('CREATE INDEX IDX_6A2F2F9512CB990C ON invoices (bank_account_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE invoices DROP FOREIGN KEY FK_6A2F2F9512CB990C');
        $this->addSql('DROP INDEX IDX_6A2F2F9512CB990C ON invoices');
        $this->addSql('ALTER TABLE invoices DROP bank_account_id, CHANGE payment_date payment_date DATE NOT NULL');
    }
}
