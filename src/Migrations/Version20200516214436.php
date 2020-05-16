<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200516214436 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY consulta_ibfk_2');
        $this->addSql('ALTER TABLE medico DROP FOREIGN KEY medico_ibfk_1');
        $this->addSql('ALTER TABLE medico DROP FOREIGN KEY medico_ibfk_3');
        $this->addSql('ALTER TABLE municipio DROP FOREIGN KEY municipio_ibfk_1');
        $this->addSql('ALTER TABLE paciente DROP FOREIGN KEY paciente_ibfk_2');
        $this->addSql('ALTER TABLE pago DROP FOREIGN KEY pago_ibfk_2');
        $this->addSql('ALTER TABLE receta DROP FOREIGN KEY receta_ibfk_1');
        $this->addSql('ALTER TABLE servicio_medico DROP FOREIGN KEY fk_servicio_medico_medico');
        $this->addSql('ALTER TABLE medico DROP FOREIGN KEY medico_ibfk_2');
        $this->addSql('ALTER TABLE paciente DROP FOREIGN KEY paciente_ibfk_1');
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY consulta_ibfk_1');
        $this->addSql('ALTER TABLE pago DROP FOREIGN KEY pago_ibfk_1');
        $this->addSql('ALTER TABLE receta DROP FOREIGN KEY receta_ibfk_2');
        $this->addSql('ALTER TABLE estado DROP FOREIGN KEY estado_ibfk_1');
        $this->addSql('ALTER TABLE medico DROP FOREIGN KEY medico_ibfk_4');
        $this->addSql('ALTER TABLE paciente DROP FOREIGN KEY paciente_ibfk_3');
        $this->addSql('ALTER TABLE servicio_medico DROP FOREIGN KEY fk_servicio_medico_servicio');
        $this->addSql('ALTER TABLE paciente DROP FOREIGN KEY paciente_ibfk_4');
        $this->addSql('ALTER TABLE medico DROP FOREIGN KEY medico_ibfk_5');
        $this->addSql('ALTER TABLE paciente DROP FOREIGN KEY paciente_ibfk_5');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE consulta');
        $this->addSql('DROP TABLE especialidad');
        $this->addSql('DROP TABLE estado');
        $this->addSql('DROP TABLE factura');
        $this->addSql('DROP TABLE medico');
        $this->addSql('DROP TABLE municipio');
        $this->addSql('DROP TABLE paciente');
        $this->addSql('DROP TABLE pago');
        $this->addSql('DROP TABLE pais');
        $this->addSql('DROP TABLE receta');
        $this->addSql('DROP TABLE servicio');
        $this->addSql('DROP TABLE servicio_medico');
        $this->addSql('DROP TABLE tipo_pago');
        $this->addSql('DROP TABLE usuario');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE consulta (id INT AUTO_INCREMENT NOT NULL, id_paciente INT DEFAULT NULL, id_especialidad INT DEFAULT NULL, sintomas TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, foto1 VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, foto2 VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, foto3 VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, estado TINYINT(1) DEFAULT NULL, servicio TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, respuesta TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, INDEX id_especialidad (id_especialidad), INDEX id_paciente (id_paciente), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE especialidad (id INT AUTO_INCREMENT NOT NULL, especialidad VARCHAR(120) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE estado (id INT AUTO_INCREMENT NOT NULL, id_pais INT DEFAULT NULL, INDEX id_pais (id_pais), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE factura (id INT AUTO_INCREMENT NOT NULL, detalles TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, monto NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE medico (id INT AUTO_INCREMENT NOT NULL, id_especialidad INT DEFAULT NULL, id_municipio INT DEFAULT NULL, id_estado INT DEFAULT NULL, id_pais INT DEFAULT NULL, id_usuario INT DEFAULT NULL, nombre VARCHAR(60) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, apellidos VARCHAR(60) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, cedula INT DEFAULT NULL, direccion TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, telefono INT DEFAULT NULL, INDEX id_especialidad (id_especialidad), INDEX id_estado (id_estado), INDEX id_municipio (id_municipio), INDEX id_pais (id_pais), INDEX id_usuario (id_usuario), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE municipio (id INT AUTO_INCREMENT NOT NULL, id_estado INT DEFAULT NULL, INDEX id_estado (id_estado), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE paciente (id INT AUTO_INCREMENT NOT NULL, id_municipio INT DEFAULT NULL, id_pais INT DEFAULT NULL, metodo_pago INT DEFAULT NULL, id_usuario INT DEFAULT NULL, nombre VARCHAR(60) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, apellidos VARCHAR(60) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, direccion TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, id_estado INT DEFAULT NULL, telefono INT DEFAULT NULL, alergias TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, enfermedades_cronicas TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, cirugias TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, covid19 TINYINT(1) DEFAULT NULL, INDEX id_municipio (id_municipio), INDEX id_pais (id_pais), INDEX id_usuario (id_usuario), INDEX metodo_pago (metodo_pago), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pago (id INT AUTO_INCREMENT NOT NULL, id_paciente INT DEFAULT NULL, id_factura INT DEFAULT NULL, INDEX id_factura (id_factura), INDEX id_paciente (id_paciente), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pais (id INT AUTO_INCREMENT NOT NULL, pais VARCHAR(120) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE receta (id INT AUTO_INCREMENT NOT NULL, id_medico INT DEFAULT NULL, id_paciente INT DEFAULT NULL, medicamento TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, INDEX id_medico (id_medico), INDEX id_paciente (id_paciente), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE servicio (id INT AUTO_INCREMENT NOT NULL, servicio VARCHAR(60) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, costo NUMERIC(8, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE servicio_medico (id_medico INT NOT NULL, id_servicio INT NOT NULL, INDEX fk_servicio_medico_medico (id_medico), INDEX fk_servicio_medico_servicio (id_servicio)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tipo_pago (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(60) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(40) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, password TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT consulta_ibfk_1 FOREIGN KEY (id_paciente) REFERENCES paciente (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT consulta_ibfk_2 FOREIGN KEY (id_especialidad) REFERENCES especialidad (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE estado ADD CONSTRAINT estado_ibfk_1 FOREIGN KEY (id_pais) REFERENCES pais (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE medico ADD CONSTRAINT medico_ibfk_1 FOREIGN KEY (id_especialidad) REFERENCES especialidad (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE medico ADD CONSTRAINT medico_ibfk_2 FOREIGN KEY (id_municipio) REFERENCES municipio (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE medico ADD CONSTRAINT medico_ibfk_3 FOREIGN KEY (id_estado) REFERENCES estado (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE medico ADD CONSTRAINT medico_ibfk_4 FOREIGN KEY (id_pais) REFERENCES pais (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE medico ADD CONSTRAINT medico_ibfk_5 FOREIGN KEY (id_usuario) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE municipio ADD CONSTRAINT municipio_ibfk_1 FOREIGN KEY (id_estado) REFERENCES estado (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE paciente ADD CONSTRAINT paciente_ibfk_1 FOREIGN KEY (id_municipio) REFERENCES municipio (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE paciente ADD CONSTRAINT paciente_ibfk_2 FOREIGN KEY (id_municipio) REFERENCES estado (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE paciente ADD CONSTRAINT paciente_ibfk_3 FOREIGN KEY (id_pais) REFERENCES pais (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE paciente ADD CONSTRAINT paciente_ibfk_4 FOREIGN KEY (metodo_pago) REFERENCES tipo_pago (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE paciente ADD CONSTRAINT paciente_ibfk_5 FOREIGN KEY (id_usuario) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE pago ADD CONSTRAINT pago_ibfk_1 FOREIGN KEY (id_paciente) REFERENCES paciente (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE pago ADD CONSTRAINT pago_ibfk_2 FOREIGN KEY (id_factura) REFERENCES factura (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE receta ADD CONSTRAINT receta_ibfk_1 FOREIGN KEY (id_medico) REFERENCES medico (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE receta ADD CONSTRAINT receta_ibfk_2 FOREIGN KEY (id_paciente) REFERENCES paciente (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE servicio_medico ADD CONSTRAINT fk_servicio_medico_medico FOREIGN KEY (id_medico) REFERENCES medico (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE servicio_medico ADD CONSTRAINT fk_servicio_medico_servicio FOREIGN KEY (id_servicio) REFERENCES servicio (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE user');
    }
}
