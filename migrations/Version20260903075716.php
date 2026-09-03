<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260903075716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, proof_path VARCHAR(255) DEFAULT NULL, intern_id INT NOT NULL, reason_id INT NOT NULL, INDEX IDX_765AE0C9525DD4B4 (intern_id), INDEX IDX_765AE0C959BB1592 (reason_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intern (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, phone VARCHAR(20) DEFAULT NULL, photo_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reason (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_3BB8880CEA750E8 (label), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9525DD4B4 FOREIGN KEY (intern_id) REFERENCES intern (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C959BB1592 FOREIGN KEY (reason_id) REFERENCES reason (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9525DD4B4');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C959BB1592');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE intern');
        $this->addSql('DROP TABLE reason');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
