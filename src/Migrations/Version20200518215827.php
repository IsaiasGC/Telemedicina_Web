<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200518215827 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE medico (id INT AUTO_INCREMENT NOT NULL, id_municipio_id INT NOT NULL, id_estado_id INT NOT NULL, id_pais_id INT NOT NULL, id_user_id INT NOT NULL, nombre VARCHAR(100) NOT NULL, apellido VARCHAR(100) NOT NULL, cedula VARCHAR(15) NOT NULL, direccion VARCHAR(180) NOT NULL, telefono VARCHAR(15) NOT NULL, INDEX IDX_34E5914C7B7D6E92 (id_municipio_id), INDEX IDX_34E5914C1F6FF82C (id_estado_id), INDEX IDX_34E5914C18997CB6 (id_pais_id), UNIQUE INDEX UNIQ_34E5914C79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE municipio (id INT AUTO_INCREMENT NOT NULL, id_estado_id INT NOT NULL, municipio VARCHAR(150) NOT NULL, INDEX IDX_FE98F5E01F6FF82C (id_estado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pais (id INT AUTO_INCREMENT NOT NULL, pais VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paciente (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_municipio_id INT NOT NULL, id_estado_id INT NOT NULL, id_pais_id INT NOT NULL, nombre VARCHAR(100) NOT NULL, apellido VARCHAR(100) NOT NULL, direccion VARCHAR(150) NOT NULL, telefono VARCHAR(15) DEFAULT NULL, alergias LONGTEXT NOT NULL, enfermedades_cronicas LONGTEXT NOT NULL, cirugias LONGTEXT NOT NULL, covid19 TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_C6CBA95E79F37AE5 (id_user_id), INDEX IDX_C6CBA95E7B7D6E92 (id_municipio_id), INDEX IDX_C6CBA95E1F6FF82C (id_estado_id), INDEX IDX_C6CBA95E18997CB6 (id_pais_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE especialidad (id INT AUTO_INCREMENT NOT NULL, especialidad VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estado (id INT AUTO_INCREMENT NOT NULL, id_pais_id INT NOT NULL, estado VARCHAR(120) NOT NULL, INDEX IDX_265DE1E318997CB6 (id_pais_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medico ADD CONSTRAINT FK_34E5914C7B7D6E92 FOREIGN KEY (id_municipio_id) REFERENCES municipio (id)');
        $this->addSql('ALTER TABLE medico ADD CONSTRAINT FK_34E5914C1F6FF82C FOREIGN KEY (id_estado_id) REFERENCES estado (id)');
        $this->addSql('ALTER TABLE medico ADD CONSTRAINT FK_34E5914C18997CB6 FOREIGN KEY (id_pais_id) REFERENCES pais (id)');
        $this->addSql('ALTER TABLE medico ADD CONSTRAINT FK_34E5914C79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE municipio ADD CONSTRAINT FK_FE98F5E01F6FF82C FOREIGN KEY (id_estado_id) REFERENCES estado (id)');
        $this->addSql('ALTER TABLE paciente ADD CONSTRAINT FK_C6CBA95E79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE paciente ADD CONSTRAINT FK_C6CBA95E7B7D6E92 FOREIGN KEY (id_municipio_id) REFERENCES municipio (id)');
        $this->addSql('ALTER TABLE paciente ADD CONSTRAINT FK_C6CBA95E1F6FF82C FOREIGN KEY (id_estado_id) REFERENCES estado (id)');
        $this->addSql('ALTER TABLE paciente ADD CONSTRAINT FK_C6CBA95E18997CB6 FOREIGN KEY (id_pais_id) REFERENCES pais (id)');
        $this->addSql('ALTER TABLE estado ADD CONSTRAINT FK_265DE1E318997CB6 FOREIGN KEY (id_pais_id) REFERENCES pais (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE medico DROP FOREIGN KEY FK_34E5914C7B7D6E92');
        $this->addSql('ALTER TABLE paciente DROP FOREIGN KEY FK_C6CBA95E7B7D6E92');
        $this->addSql('ALTER TABLE medico DROP FOREIGN KEY FK_34E5914C18997CB6');
        $this->addSql('ALTER TABLE paciente DROP FOREIGN KEY FK_C6CBA95E18997CB6');
        $this->addSql('ALTER TABLE estado DROP FOREIGN KEY FK_265DE1E318997CB6');
        $this->addSql('ALTER TABLE medico DROP FOREIGN KEY FK_34E5914C1F6FF82C');
        $this->addSql('ALTER TABLE municipio DROP FOREIGN KEY FK_FE98F5E01F6FF82C');
        $this->addSql('ALTER TABLE paciente DROP FOREIGN KEY FK_C6CBA95E1F6FF82C');
        $this->addSql('DROP TABLE medico');
        $this->addSql('DROP TABLE municipio');
        $this->addSql('DROP TABLE pais');
        $this->addSql('DROP TABLE paciente');
        $this->addSql('DROP TABLE especialidad');
        $this->addSql('DROP TABLE estado');
    }
}
