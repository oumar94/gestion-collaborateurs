<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200131164513 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE collaborator_client (collaborator_id INT NOT NULL, client_id INT NOT NULL, INDEX IDX_AC30957730098C8C (collaborator_id), INDEX IDX_AC30957719EB6921 (client_id), PRIMARY KEY(collaborator_id, client_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE collaborator_client ADD CONSTRAINT FK_AC30957730098C8C FOREIGN KEY (collaborator_id) REFERENCES collaborator (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE collaborator_client ADD CONSTRAINT FK_AC30957719EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE collaborator CHANGE filename filename VARCHAR(255) NOT NULL');

        
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE collaborator_client DROP FOREIGN KEY FK_AC30957719EB6921');
        $this->addSql('DROP TABLE collaborator_client');
        $this->addSql('DROP TABLE client');

        $this->addSql('ALTER TABLE collaborator CHANGE filename filename VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
