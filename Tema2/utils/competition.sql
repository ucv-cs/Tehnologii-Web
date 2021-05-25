-- MySQL Script generated by MySQL Workbench
-- Sat May 22 11:34:31 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema competition
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `competition` ;

-- -----------------------------------------------------
-- Schema competition
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `competition` DEFAULT CHARACTER SET utf8 COLLATE utf8_romanian_ci ;
USE `competition` ;

-- -----------------------------------------------------
-- Table `competition`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `competition`.`users` ;

CREATE TABLE IF NOT EXISTS `competition`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `user_first_name` VARCHAR(45) NOT NULL,
  `user_family_name` VARCHAR(45) NOT NULL,
  `user_email` VARCHAR(45) NOT NULL,
  `user_password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `competition`.`news`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `competition`.`news` ;

CREATE TABLE IF NOT EXISTS `competition`.`news` (
  `news_id` INT NOT NULL AUTO_INCREMENT,
  `news_content` TEXT NOT NULL,
  `news_date` DATETIME NOT NULL DEFAULT NOW(),
  `user_id` INT NOT NULL,
  PRIMARY KEY (`news_id`),
  INDEX `user_news_idx` (`user_id` ASC),
  UNIQUE INDEX `news_id_UNIQUE` (`news_id` ASC),
  CONSTRAINT `user_news`
    FOREIGN KEY (`user_id`)
    REFERENCES `competition`.`users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `competition`.`participants`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `competition`.`participants` ;

CREATE TABLE IF NOT EXISTS `competition`.`participants` (
  `participant_id` INT NOT NULL AUTO_INCREMENT,
  `participant_first_name` VARCHAR(45) NOT NULL,
  `participant_family_name` VARCHAR(45) NOT NULL,
  `participant_email` VARCHAR(45) NOT NULL,
  `participant_score_1` FLOAT NULL,
  `participant_score_2` FLOAT NULL,
  `participant_score_3` FLOAT NULL,
  PRIMARY KEY (`participant_id`),
  UNIQUE INDEX `utilizator_email_UNIQUE` (`participant_email` ASC),
  UNIQUE INDEX `participant_id_UNIQUE` (`participant_id` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `competition`.`users`
-- -----------------------------------------------------
START TRANSACTION;
USE `competition`;
INSERT INTO `competition`.`users` (`user_id`, `user_first_name`, `user_family_name`, `user_email`, `user_password`) VALUES (1, 'Alin', 'Clincea', 'alin.clincea@gmail.com', '96958675fcf1cec2754c74249428ac1247cf6e95');
INSERT INTO `competition`.`users` (`user_id`, `user_first_name`, `user_family_name`, `user_email`, `user_password`) VALUES (2, 'George', 'Ionescu', 'gionescu@ymail.com', '1761ad6d1393e4831c2ab9206a313f69b7797303');

COMMIT;


-- -----------------------------------------------------
-- Data for table `competition`.`news`
-- -----------------------------------------------------
START TRANSACTION;
USE `competition`;
INSERT INTO `competition`.`news` (`news_id`, `news_content`, `news_date`, `user_id`) VALUES (1, 'A început înscrierea pentru concursul Craiova-21.', '2021-05-20 14:04:13', 1);
INSERT INTO `competition`.`news` (`news_id`, `news_content`, `news_date`, `user_id`) VALUES (2, '5 participanți la concursul Craiova-21 au trimis deja soluțiile.', '2021-05-22 10:14:22', 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `competition`.`participants`
-- -----------------------------------------------------
START TRANSACTION;
USE `competition`;
INSERT INTO `competition`.`participants` (`participant_id`, `participant_first_name`, `participant_family_name`, `participant_email`, `participant_score_1`, `participant_score_2`, `participant_score_3`) VALUES (1, 'Cristina', 'Florea', 'cristina.florea@yahoo.com', 8.5, 9.80, NULL);
INSERT INTO `competition`.`participants` (`participant_id`, `participant_first_name`, `participant_family_name`, `participant_email`, `participant_score_1`, `participant_score_2`, `participant_score_3`) VALUES (2, 'Radu', 'Georgescu', 'rgeo@ymail.com', NULL, 5, NULL);
INSERT INTO `competition`.`participants` (`participant_id`, `participant_first_name`, `participant_family_name`, `participant_email`, `participant_score_1`, `participant_score_2`, `participant_score_3`) VALUES (3, 'Ana', 'Dulgheru', 'adu@remote.com', NULL, NULL, 7.66);

COMMIT;

