<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240902120931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD borrower_id INT DEFAULT NULL, ADD borrowed_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33111CE312B FOREIGN KEY (borrower_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A33111CE312B ON book (borrower_id)');
        $this->addSql('ALTER TABLE reservation ADD expiration_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD is_active TINYINT(1) NOT NULL, CHANGE user_id user_id INT NOT NULL, CHANGE book_id book_id INT NOT NULL, CHANGE reservation_date reservation_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP expiration_date, DROP is_active, CHANGE user_id user_id INT DEFAULT NULL, CHANGE book_id book_id INT DEFAULT NULL, CHANGE reservation_date reservation_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33111CE312B');
        $this->addSql('DROP INDEX IDX_CBE5A33111CE312B ON book');
        $this->addSql('ALTER TABLE book DROP borrower_id, DROP borrowed_at');
    }
}
