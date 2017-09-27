SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `WebDiP2016x043` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `WebDiP2016x043` ;

-- -----------------------------------------------------
-- Table `WebDiP2016x043`.`uloga`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `WebDiP2016x043`.`uloga` (
  `id_uloga` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`id_uloga`) ,
  UNIQUE INDEX `naziv_UNIQUE` (`naziv` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x043`.`korisnik`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `WebDiP2016x043`.`korisnik` (
  `id_korisnik` INT NOT NULL AUTO_INCREMENT ,
  `ime` VARCHAR(50) NOT NULL ,
  `prezime` VARCHAR(50) NOT NULL ,
  `korime` VARCHAR(25) NOT NULL ,
  `email` VARCHAR(50) NOT NULL ,
  `spol` CHAR(1) NOT NULL ,
  `mobitel` VARCHAR(20) NOT NULL ,
  `datrod` DATE NOT NULL ,
  `lozinka` VARCHAR(50) NOT NULL ,
  `encrypted` VARCHAR(100) NOT NULL ,
  `dual_login` CHAR(2) NOT NULL ,
  `aktivacijski_kod` VARCHAR(100) NOT NULL ,
  `vrijeme` DATETIME NOT NULL ,
  `krivi_login` TINYINT NOT NULL ,
  `aktivan` CHAR(2) NOT NULL ,
  `zabranjen` CHAR(2) NOT NULL ,
  `broj_bodova` INT NOT NULL ,
  `id_uloga` INT NOT NULL ,
  PRIMARY KEY (`id_korisnik`) ,
  INDEX `fk_korisnik_uloga1_idx` (`id_uloga` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  UNIQUE INDEX `korime_UNIQUE` (`korime` ASC) ,
  UNIQUE INDEX `aktivacijski_kod_UNIQUE` (`aktivacijski_kod` ASC) ,
  CONSTRAINT `fk_korisnik_uloga1`
    FOREIGN KEY (`id_uloga` )
    REFERENCES `WebDiP2016x043`.`uloga` (`id_uloga` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x043`.`dnevnik`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `WebDiP2016x043`.`dnevnik` (
  `id_dnevnik` INT NOT NULL AUTO_INCREMENT ,
  `upit` TEXT NULL ,
  `radnja` VARCHAR(50) NULL ,
  `vrijeme` DATETIME NOT NULL ,
  `tip_radnje` VARCHAR(25) NOT NULL ,
  `id_korisnik` INT NOT NULL ,
  PRIMARY KEY (`id_dnevnik`) ,
  INDEX `fk_dnevnik_korisnik_idx` (`id_korisnik` ASC) ,
  CONSTRAINT `fk_dnevnik_korisnik`
    FOREIGN KEY (`id_korisnik` )
    REFERENCES `WebDiP2016x043`.`korisnik` (`id_korisnik` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x043`.`radnja`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `WebDiP2016x043`.`radnja` (
  `id_radnja` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(50) NOT NULL ,
  `broj_bodova` INT NOT NULL ,
  `opis` TEXT NULL ,
  PRIMARY KEY (`id_radnja`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x043`.`kljuc`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `WebDiP2016x043`.`kljuc` (
  `id_kljuc` INT NOT NULL AUTO_INCREMENT ,
  `kod` CHAR(5) NOT NULL ,
  `vrijeme` DATETIME NOT NULL ,
  `aktivan` CHAR(2) NOT NULL ,
  `id_korisnik` INT NOT NULL ,
  PRIMARY KEY (`id_kljuc`) ,
  INDEX `fk_kljuc_korisnik1_idx` (`id_korisnik` ASC) ,
  UNIQUE INDEX `kod_UNIQUE` (`kod` ASC) ,
  CONSTRAINT `fk_kljuc_korisnik1`
    FOREIGN KEY (`id_korisnik` )
    REFERENCES `WebDiP2016x043`.`korisnik` (`id_korisnik` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x043`.`vrsta`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `WebDiP2016x043`.`vrsta` (
  `id_vrsta` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`id_vrsta`) ,
  UNIQUE INDEX `naziv_UNIQUE` (`naziv` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x043`.`trener`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `WebDiP2016x043`.`trener` (
  `id_trener` INT NOT NULL AUTO_INCREMENT ,
  `id_korisnik` INT NOT NULL ,
  `id_vrsta` INT NOT NULL ,
  PRIMARY KEY (`id_trener`) ,
  INDEX `fk_trener_korisnik1_idx` (`id_korisnik` ASC) ,
  INDEX `fk_trener_vrsta1_idx` (`id_vrsta` ASC) ,
  CONSTRAINT `fk_trener_korisnik1`
    FOREIGN KEY (`id_korisnik` )
    REFERENCES `WebDiP2016x043`.`korisnik` (`id_korisnik` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_trener_vrsta1`
    FOREIGN KEY (`id_vrsta` )
    REFERENCES `WebDiP2016x043`.`vrsta` (`id_vrsta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x043`.`program`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `WebDiP2016x043`.`program` (
  `id_program` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(100) NOT NULL ,
  `opis` TEXT NOT NULL ,
  `mjesec` TINYINT NOT NULL ,
  `broj_polaznika` INT NOT NULL ,
  `broj_mjesta` INT NOT NULL ,
  `aktivan` CHAR(2) NOT NULL ,
  `id_vrsta` INT NOT NULL ,
  `id_trener` INT NOT NULL ,
  PRIMARY KEY (`id_program`) ,
  INDEX `fk_program_vrsta1_idx` (`id_vrsta` ASC) ,
  INDEX `fk_program_trener1_idx` (`id_trener` ASC) ,
  CONSTRAINT `fk_program_vrsta1`
    FOREIGN KEY (`id_vrsta` )
    REFERENCES `WebDiP2016x043`.`vrsta` (`id_vrsta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_program_trener1`
    FOREIGN KEY (`id_trener` )
    REFERENCES `WebDiP2016x043`.`trener` (`id_trener` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x043`.`polaznik`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `WebDiP2016x043`.`polaznik` (
  `id_polaznik` INT NOT NULL AUTO_INCREMENT ,
  `aktivan` CHAR(2) NOT NULL ,
  `zabranjen` CHAR(2) NOT NULL ,
  `id_program` INT NOT NULL ,
  `id_korisnik` INT NOT NULL ,
  PRIMARY KEY (`id_polaznik`) ,
  INDEX `fk_polaznik_program1_idx` (`id_program` ASC) ,
  INDEX `fk_polaznik_korisnik1_idx` (`id_korisnik` ASC) ,
  CONSTRAINT `fk_polaznik_program1`
    FOREIGN KEY (`id_program` )
    REFERENCES `WebDiP2016x043`.`program` (`id_program` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_polaznik_korisnik1`
    FOREIGN KEY (`id_korisnik` )
    REFERENCES `WebDiP2016x043`.`korisnik` (`id_korisnik` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x043`.`termin`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `WebDiP2016x043`.`termin` (
  `id_termin` INT NOT NULL AUTO_INCREMENT ,
  `dan` VARCHAR(20) NOT NULL ,
  `od` TIME NOT NULL ,
  `do` TIME NOT NULL ,
  `aktivan` CHAR(2) NOT NULL ,
  `id_program` INT NOT NULL ,
  PRIMARY KEY (`id_termin`) ,
  INDEX `fk_termin_program1_idx` (`id_program` ASC) ,
  CONSTRAINT `fk_termin_program1`
    FOREIGN KEY (`id_program` )
    REFERENCES `WebDiP2016x043`.`program` (`id_program` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x043`.`kupon`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `WebDiP2016x043`.`kupon` (
  `id_kupon` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(100) NOT NULL ,
  `pdf_putanja` TEXT NOT NULL ,
  `slika_putanja` TEXT NOT NULL ,
  `video_putanja` TEXT NULL ,
  PRIMARY KEY (`id_kupon`) ,
  UNIQUE INDEX `naziv_UNIQUE` (`naziv` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x043`.`popust`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `WebDiP2016x043`.`popust` (
  `id_popust` INT NOT NULL AUTO_INCREMENT ,
  `potrebno` INT NOT NULL ,
  `od` DATE NOT NULL ,
  `do` DATE NOT NULL ,
  `id_kupon` INT NOT NULL ,
  `id_program` INT NOT NULL ,
  PRIMARY KEY (`id_popust`) ,
  INDEX `fk_popust_kupon1_idx` (`id_kupon` ASC) ,
  INDEX `fk_popust_program1_idx` (`id_program` ASC) ,
  CONSTRAINT `fk_popust_kupon1`
    FOREIGN KEY (`id_kupon` )
    REFERENCES `WebDiP2016x043`.`kupon` (`id_kupon` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_popust_program1`
    FOREIGN KEY (`id_program` )
    REFERENCES `WebDiP2016x043`.`program` (`id_program` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x043`.`kosarica`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `WebDiP2016x043`.`kosarica` (
  `id_korisnik` INT NOT NULL ,
  `id_popust` INT NOT NULL ,
  `kod` CHAR(10) NOT NULL ,
  PRIMARY KEY (`id_korisnik`, `id_popust`) ,
  INDEX `fk_korisnik_has_popust_popust1_idx` (`id_popust` ASC) ,
  INDEX `fk_korisnik_has_popust_korisnik1_idx` (`id_korisnik` ASC) ,
  UNIQUE INDEX `kod_UNIQUE` (`kod` ASC) ,
  CONSTRAINT `fk_korisnik_has_popust_korisnik1`
    FOREIGN KEY (`id_korisnik` )
    REFERENCES `WebDiP2016x043`.`korisnik` (`id_korisnik` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_korisnik_has_popust_popust1`
    FOREIGN KEY (`id_popust` )
    REFERENCES `WebDiP2016x043`.`popust` (`id_popust` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x043`.`evidencija`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `WebDiP2016x043`.`evidencija` (
  `id_termin` INT NOT NULL ,
  `id_polaznik` INT NOT NULL ,
  `prisutan` CHAR(2) NOT NULL ,
  `datum` DATE NOT NULL ,
  `opis` TEXT NULL ,
  INDEX `fk_termin_has_polaznik_polaznik1_idx` (`id_polaznik` ASC) ,
  INDEX `fk_termin_has_polaznik_termin1_idx` (`id_termin` ASC) ,
  CONSTRAINT `fk_termin_has_polaznik_termin1`
    FOREIGN KEY (`id_termin` )
    REFERENCES `WebDiP2016x043`.`termin` (`id_termin` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_termin_has_polaznik_polaznik1`
    FOREIGN KEY (`id_polaznik` )
    REFERENCES `WebDiP2016x043`.`polaznik` (`id_polaznik` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x043`.`statistika`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `WebDiP2016x043`.`statistika` (
  `id_radnja` INT NOT NULL ,
  `id_korisnik` INT NOT NULL ,
  `vrijeme` DATETIME NOT NULL ,
  INDEX `fk_radnja_has_korisnik_korisnik1_idx` (`id_korisnik` ASC) ,
  INDEX `fk_radnja_has_korisnik_radnja1_idx` (`id_radnja` ASC) ,
  CONSTRAINT `fk_radnja_has_korisnik_radnja1`
    FOREIGN KEY (`id_radnja` )
    REFERENCES `WebDiP2016x043`.`radnja` (`id_radnja` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_radnja_has_korisnik_korisnik1`
    FOREIGN KEY (`id_korisnik` )
    REFERENCES `WebDiP2016x043`.`korisnik` (`id_korisnik` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `WebDiP2016x043` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
