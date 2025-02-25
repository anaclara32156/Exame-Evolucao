-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema exameevolucao
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema exameevolucao
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `exameevolucao` DEFAULT CHARACTER SET utf8mb4 ;
USE `exameevolucao` ;

-- -----------------------------------------------------
-- Table `exameevolucao`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `exameevolucao`.`usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `cpf` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 26
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `exameevolucao`.`cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `exameevolucao`.`cliente` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `cpf` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `dataNascimento` DATE NOT NULL,
  `sexo` VARCHAR(20) NOT NULL,
  `tel` VARCHAR(20) NOT NULL,
  `idUsuario` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `FK_Usuario_Paciente` (`idUsuario` ASC),
  CONSTRAINT `FK_Usuario_Paciente`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `exameevolucao`.`usuario` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 59
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `exameevolucao`.`marcador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `exameevolucao`.`marcador` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nomeMarcador` VARCHAR(255) NOT NULL,
  `grupo` VARCHAR(255) NOT NULL,
  `idUsuario` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `FK_Usuario_Marcador` (`idUsuario` ASC),
  CONSTRAINT `FK_Usuario_Marcador`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `exameevolucao`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 167
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `exameevolucao`.`resultadoexame`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `exameevolucao`.`resultadoexame` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `marcador` VARCHAR(255) NOT NULL,
  `grupo` VARCHAR(255) NOT NULL,
  `dataColeta` DATE NOT NULL,
  `resultado` DECIMAL(10,2) NOT NULL,
  `idCliente` INT(11) NOT NULL,
  `idMarcador` INT(11) NOT NULL,
  `medida` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `FK_Paciente_Exame` (`idCliente` ASC),
  INDEX `FK_DadosExame_Exame` (`idMarcador` ASC),
  CONSTRAINT `FK_DadosExame_Exame`
    FOREIGN KEY (`idMarcador`)
    REFERENCES `exameevolucao`.`marcador` (`id`),
  CONSTRAINT `FK_Paciente_Exame`
    FOREIGN KEY (`idCliente`)
    REFERENCES `exameevolucao`.`cliente` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 170
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `exameevolucao`.`tipodevalor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `exameevolucao`.`tipodevalor` (
  `idTipoDeValor` INT(11) NOT NULL AUTO_INCREMENT,
  `nomeTipoDeValor` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idTipoDe Valor`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `exameevolucao`.`valor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `exameevolucao`.`valor` (
  `idValor` INT(11) NOT NULL AUTO_INCREMENT,
  `idMarcador` INT(11) NOT NULL,
  `eMaximo` VARCHAR(10) NOT NULL,
  `proprioValor` VARCHAR(45) NULL DEFAULT NULL,
  `idadeInferior` VARCHAR(45) NULL DEFAULT NULL,
  `idadeSuperior` VARCHAR(45) NULL DEFAULT NULL,
  `sexoBiologico` VARCHAR(45) NULL DEFAULT NULL,
  `unidadeDeMedida` VARCHAR(45) NULL DEFAULT NULL,
  `idTipoDeValor` INT(11) NOT NULL,
  PRIMARY KEY (`idValor`),
  INDEX `fk_valor_marcador1_idx` (`idMarcador` ASC),
  INDEX `fk_valor_tipodevalor1_idx` (`idTipoDeValor` ASC),
  CONSTRAINT `fk_valor_marcador1`
    FOREIGN KEY (`idMarcador`)
    REFERENCES `exameevolucao`.`marcador` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_valor_tipodevalor1`
    FOREIGN KEY (`idTipoDeValor`)
    REFERENCES `exameevolucao`.`tipodevalor` (`idTipoDe Valor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 123
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO exameevolucao.usuario (id, nome, cpf, email, senha) VALUES
(1, 'Admin', '111.111.111.11', 'admin@gmail.com', 'admin');

INSERT INTO exameevolucao.marcador (id, nomeMarcador, grupo) VALUES
(1, 'Eritrócitos', 'Leucograma'),
(2, 'Hemoglobina', 'Leucograma'),
(3, 'Hematócrito', 'Leucograma'),
(4, 'VCM', 'Leucograma'),
(5, 'HCM', 'Leucograma'),
(6, 'CHCM', 'Leucograma'),
(7, 'RDW', 'Leucograma'),
(8, 'VSG', 'Leucograma'),
(9, 'Saturação Transferrina', 'Leucograma'),
(10, 'Transferrina Livre', 'Leucograma'),
(11, 'Ferritina', 'Leucograma'),
(12, 'TIBC', 'Leucograma'),
(13, 'B12', 'Leucograma'),
(14, 'Ácido Fólico', 'Leucograma'),
(15, 'Holotranscobalamina', 'Leucograma'),
(16, 'Hemocisteína', 'Leucograma'),
(17, 'Leucócitos', 'Leucograma'),
(18, 'Neutrófilos', 'Leucograma'),
(19, 'Linfócitos', 'Leucograma'),
(20, 'Monócitos', 'Leucograma'),
(21, 'Eosinófilos', 'Leucograma'),
(22, 'Basófilos', 'Leucograma'),
(23, 'Plaquetas', 'Leucograma'),
(24, 'Glicose Jejum', 'Perfil Metabólico'),
(25, 'HbA1C', 'Perfil Metabólico'),
(26, 'Insulina', 'Perfil Metabólico'),
(27, 'Pró-Insulina', 'Perfil Metabólico'),
(28, 'HOMA-IR', 'Perfil Metabólico'),
(29, 'TGT Glicose 1h após 75g', 'Perfil Metabólico'),
(30, 'TGT Glicose 2h após 75g', 'Perfil Metabólico'),
(31, 'TGT Insulina 1h após 75g', 'Perfil Metabólico'),
(32, 'TGT Insulina 2h após 75g', 'Perfil Metabólico'),
(33, 'CT', 'Perfil Metabólico'),
(34, 'HDL', 'Perfil Metabólico'),
(35, 'LDL', 'Perfil Metabólico'),
(36, 'Rel TG/HDL', 'Perfil Metabólico'),
(37, 'Triglicéridos', 'Perfil Metabólico'),
(38, 'ApoA 1', 'Perfil Metabólico'),
(39, 'ApoB', 'Perfil Metabólico'),
(40, 'Fribrinogênio', 'Perfil Metabólico'),
(41, 'Lp(a)', 'Perfil Metabólico'),
(42, 'Lp-PLA2', 'Perfil Metabólico'),
(43, 'LDL oxidado', 'Perfil Metabólico'),
(44, 'Adiponectina', 'Perfil Metabólico');

INSERT INTO valores (idValor, idMarcador, idTipoDeValor, eMaximo, proprioValor, idadeInferior, idadeSuperior, sexoBiologico, unidadeDeMedida) VALUES
(1, 1, 1, 'Nao', 4.5, 0, 1200, 'M', 'x106/mm³'),
(2, 1, 1, 'Sim', 6, 0, 1200, 'M', 'x106/mm³'),
(3, 2, 1, 'Nao', 13, 0, 1200, 'M', 'g/dL'),
(4, 2, 1, 'Sim', 17, 0, 1200, 'M', 'g/dL'),
(5, 3, 1, 'Nao', 39, 0, 1200, 'M', '%'),
(6, 3, 1, 'Sim', 52, 0, 1200, 'M', '%'),
(7, 4, 1, 'Nao', 80, 0, 1200, 'U', 'fl'),
(8, 4, 1, 'Sim', 98, 0, 1200, 'U', 'fl'),
(9, 5, 1, 'Nao', 26, 0, 1200, 'U', 'oc/célula'),
(10, 5, 1, 'Sim', 34, 0, 1200, 'U', 'oc/célula'),
(11, 6, 1, 'Nao', 31, 0, 1200, 'U', 'a/dL'),
(12, 6, 1, 'Sim', 36, 0, 1200, 'U', 'a/dL'),
(13, 7, 1, 'Nao', 11.5, 0, 1200, 'U', '%'),
(14, 7, 1, 'Sim', 14.5, 0, 1200, 'U', '%'),
(15, 8, 1, 'Sim', 15, 0, 1200, 'U', 'mm'),
(16, 9, 1, 'Nao', 20, 0, 1200, 'U', '%'),
(17, 9, 1, 'Sim', 50, 0, 1200, 'U', '%'),
(18, 10, 1, 'Nao', 212, 0, 1200, 'U', 'mg/dL'),
(19, 10, 1, 'Sim', 360, 0, 1200, 'U', 'mg/dL'),
(20, 11, 1, 'Nao', 30, 0, 1200, 'M', 'mcg/L'),
(21, 11, 1, 'Sim', 300, 0, 1200, 'M', 'mcg/L'),
(22, 12, 1, 'Nao', 240, 0, 1200, 'U', 'mcg/dL'),
(23, 12, 1, 'Sim', 450, 0, 1200, 'U', 'mcg/dL'),
(24, 13, 1, 'Nao', 300, 0, 1200, 'U', 'na/L'),
(25, 13, 1, 'Sim', 900, 0, 1200, 'U', 'na/L'),
(26, 14, 1, 'Nao', 3.9, 0, 1200, 'U', 'ng/ml'),
(28, 15, 1, 'Nao', 50, 0, 1200, 'U', 'prnol/L'),
(29, 16, 1, 'Nao', 3, 0, 1200, 'U', 'rncrnol/L'),
(30, 16, 1, 'Sim', 14, 0, 1200, 'U', 'rncrnol/L'),
(31, 17, 1, 'Nao', 3500, 0, 1200, 'U', '/mm³'),
(32, 17, 1, 'Sim', 10500, 0, 1200, 'U', '/mm³'),
(33, 18, 1, 'Nao', 1700, 0, 1200, 'U', '/mm'),
(34, 18, 1, 'Sim', 7000, 0, 1200, 'U', '/mm'),
(35, 19, 1, 'Nao', 900, 0, 1200, 'U', '/mm³'),
(36, 19, 1, 'Sim', 2900, 0, 1200, 'U', '/mm³'),
(37, 20, 1, 'Nao', 100, 0, 1200, 'U', 'mm³'),
(38, 20, 1, 'Sim', 1000, 0, 1200, 'U', 'mm³'),
(39, 21, 1, 'Nao', 50, 0, 1200, 'U', 'mm³'),
(40, 21, 1, 'Sim', 599, 0, 1200, 'U', 'mm³'),
(41, 22, 1, 'Nao', 25, 0, 1200, 'U', 'mm³'),
(42, 22, 1, 'Sim', 80, 0, 1200, 'U', 'mm³'),
(43, 23, 1, 'Nao', 150000, 0, 1200, 'U', '/mm³'),
(44, 23, 1, 'Sim', 450000, 0, 1200, 'U', '/mm³'),
(45, 24, 1, 'Nao', 70, 0, 1200, 'U', 'mg/dL'),
(46, 24, 1, 'Sim', 110, 0, 1200, 'U', 'mg/dL'),
(47, 25, 1, 'Nao', 4.7, 0, 1200, 'U', '%'),
(48, 25, 1, 'Sim', 8.5, 0, 1200, 'U', '%'),
(49, 26, 1, 'Nao', 5, 0, 1200, 'U', 'mcUI/mL'),
(50, 26, 1, 'Sim', 25, 0, 1200, 'U', 'mcUI/mL'),
(51, 28, 1, 'Sim', 2.15, 0, 1200, 'U', 'InsXGlu/405'),
(52, 29, 1, 'Nao', 120, 0, 1200, 'U', 'mg/dL'),
(53, 29, 1, 'Sim', 180, 0, 1200, 'U', 'mg/dL'),
(54, 30, 1, 'Nao', 85, 0, 1200, 'U', 'mg/dL'),
(55, 30, 1, 'Sim', 140, 0, 1200, 'U', 'mg/dL'),
(56, 31, 1, 'Nao', 29, 0, 1200, 'U', 'mcUI/mL'),
(57, 31, 1, 'Sim', 88, 0, 1200, 'U', 'mcUI/mL'),
(58, 32, 1, 'Nao', 22, 0, 1200, 'U', 'mcUI/mL'),
(59, 32, 1, 'Sim', 79, 0, 1200, 'U', 'mcUI/mL'),
(60, 33, 1, 'Sim', 200, 0, 1200, 'U', 'ma/dL'),
(61, 34, 1, 'Nao', 45, 0, 1200, 'M', 'mg/dL'),
(62, 35, 1, 'Sim', 130, 0, 1200, 'U', 'mg/dL'),
(63, 39, 1, 'Sim', 250, 0, 1200, 'U', 'mg/dL'),
(64, 40, 1, 'Nao', 88, 0, 1200, 'M', 'mg/dL'),
(65, 40, 1, 'Sim', 180, 0, 1200, 'M', 'mg/dL'),
(66, 41, 1, 'Nao', 55, 0, 1200, 'M', 'mg/dL'),
(67, 41, 1, 'Sim', 151, 0, 1200, 'M', 'mg/dL'),
(68, 42, 1, 'Nao', 150, 0, 1200, 'U', 'mg/dL'),
(69, 42, 1, 'Sim', 350, 0, 1200, 'U', 'mg/dL'),
(70, 43, 1, 'Sim', 30, 0, 1200, 'U', 'mg/dL'),
(71, 44, 1, 'Nao', 120, 0, 1200, 'U', 'ng/mL'),
(72, 44, 1, 'Sim', 342, 0, 1200, 'U', 'ng/mL'),
(73, 46, 1, 'Nao', 1.5, 0, 1200, 'U', 'mcg/mL'),
(74, 46, 1, 'Sim', 25, 0, 1200, 'U', 'mcg/mL'),
(75, 3, 1, 'Nao', 36, 0, 1200, 'F', '%'),
(76, 3, 1, 'Sim', 47, 0, 1200, 'F', '%'),
(77, 2, 1, 'Nao', 12, 0, 1200, 'F', 'g/dL'),
(78, 2, 1, 'Sim', 15.5, 0, 1200, 'F', 'g/dL'),
(79, 11, 1, 'Nao', 30, 0, 1200, 'F', 'mcg/L'),
(80, 11, 1, 'Sim', 200, 0, 1200, 'F', 'mcg/L'),
(81, 34, 1, 'Nao', 40, 0, 1200, 'F', 'mg/dL'),
(82, 38, 1, 'Nao', 98, 0, 1200, 'F', 'mg/dL'),
(83, 38, 1, 'Sim', 210, 0, 1200, 'F', 'mg/dL'),
(84, 39, 1, 'Nao', 44, 0, 1200, 'F', 'mg/dL'),
(85, 39, 1, 'Sim', 148, 0, 1200, 'F', 'mg/dL');

