CREATE TABLE IF NOT EXISTS `ceehabana_moodle_db`.`mdlbol_user_profile`(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `mdl_user_id` BIGINT NOT NULL,
    `campus` ENUM('ESCUELA','PRIMARIA','INSTITUTO') NOT NULL,
    `role` ENUM('Profesor','Supervisor EP','Supervisor ESO','Supervisor BACH','Manager', 'Admin') NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE = INNODB COMMENT = 'Tabla auxiliar para almacenar los usuarios internos de Boletines';

INSERT INTO `ceehabana_moodle_db`.`mdlbol_user_profile`(`mdl_user_id`, `campus`, `role`)
VALUES(2, 'ESCUELA', 'Admin');