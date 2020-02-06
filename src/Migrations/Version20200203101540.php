<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200203101540 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE operating_mode (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE collaborator ADD operating_mode_id INT DEFAULT NULL, CHANGE filename filename VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE collaborator ADD CONSTRAINT FK_606D487C5011665E FOREIGN KEY (actual_status_id) REFERENCES actual_status (id)');
        $this->addSql('ALTER TABLE collaborator ADD CONSTRAINT FK_606D487C9745D8E2 FOREIGN KEY (operating_mode_id) REFERENCES operating_mode (id)');
        $this->addSql('CREATE INDEX IDX_606D487C5011665E ON collaborator (actual_status_id)');
        $this->addSql('CREATE INDEX IDX_606D487C9745D8E2 ON collaborator (operating_mode_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE collaborator DROP FOREIGN KEY FK_606D487C9745D8E2');
        $this->addSql('DROP TABLE operating_mode');
        $this->addSql('ALTER TABLE collaborator DROP FOREIGN KEY FK_606D487C5011665E');
        $this->addSql('DROP INDEX IDX_606D487C5011665E ON collaborator');
        $this->addSql('DROP INDEX IDX_606D487C9745D8E2 ON collaborator');
        $this->addSql('ALTER TABLE collaborator DROP operating_mode_id, CHANGE filename filename VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
