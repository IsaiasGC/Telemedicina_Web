<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200528050716 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE consulta ADD id_especialidad_id INT NOT NULL, DROP especialidad');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDEFFFA5364 FOREIGN KEY (id_especialidad_id) REFERENCES especialidad (id)');
        $this->addSql('CREATE INDEX IDX_A6FE3FDEFFFA5364 ON consulta (id_especialidad_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDEFFFA5364');
        $this->addSql('DROP INDEX IDX_A6FE3FDEFFFA5364 ON consulta');
        $this->addSql('ALTER TABLE consulta ADD especialidad VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP id_especialidad_id');
    }
}
