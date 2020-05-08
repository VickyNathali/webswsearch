/*
SQLyog Ultimate v9.02 
MySQL - 5.5.5-10.1.40-MariaDB : Database - dbswsearch
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbswsearch` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `dbswsearch`;

/*Table structure for table `administrador` */

DROP TABLE IF EXISTS `administrador`;

CREATE TABLE `administrador` (
  `CEDULA_USU` varchar(11) NOT NULL,
  `CARGO_ADM` varchar(100) NOT NULL,
  `TITULO_ADM` varchar(300) NOT NULL,
  `ESTADO_ADM` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CEDULA_USU`),
  UNIQUE KEY `ADMINISTRADOR_PK` (`CEDULA_USU`),
  CONSTRAINT `FK_ADMINIST_PERSONA_A_USUARIO` FOREIGN KEY (`CEDULA_USU`) REFERENCES `usuario` (`CEDULA_USU`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `administrador` */

insert  into `administrador`(`CEDULA_USU`,`CARGO_ADM`,`TITULO_ADM`,`ESTADO_ADM`) values ('1756455885','Técnico docente','Ingeniero en Software','Administrador'),('2200504260','Director','Máster','Administrador'),('2300658374','Director','Master en Computación',NULL);

/*Table structure for table `asignatura` */

DROP TABLE IF EXISTS `asignatura`;

CREATE TABLE `asignatura` (
  `CODIGO_ASIG` varchar(9) NOT NULL,
  `NOMBRE_ASIG` varchar(100) NOT NULL,
  `SILABO_ASIG` mediumtext CHARACTER SET latin1 COLLATE latin1_bin,
  PRIMARY KEY (`CODIGO_ASIG`),
  UNIQUE KEY `ASIGNATURA_PK` (`CODIGO_ASIG`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `asignatura` */

insert  into `asignatura`(`CODIGO_ASIG`,`NOMBRE_ASIG`,`SILABO_ASIG`) values ('IS1414P','COMPUTACION WEB','0185-programacion-orientada-a-objetos.pdf'),('ISF111','PRIMERA PRUEBA','LOES_2018-1.pdf'),('SOFI110','FISICA I','silabo_fisica.pdf'),('SOFI114','FUNDAMENTOS DE PROGRAMACIÓN ',NULL),('SOFI510','LENGUAJE ORAL, ESCRITO Y DIGITAL','COLEGIOS2019.pdf'),('SOFT787','TICS',NULL);

/*Table structure for table `aula_laboratorio` */

DROP TABLE IF EXISTS `aula_laboratorio`;

CREATE TABLE `aula_laboratorio` (
  `ID_AUL` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `NOMBRE_AUL` varchar(100) NOT NULL,
  `LATITUD_AUL` decimal(10,0) NOT NULL,
  `LONGITUD_AUL` decimal(10,0) NOT NULL,
  `ALTURA_AUL` decimal(10,0) NOT NULL,
  `FOTO_AUL` mediumtext CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `OBSERVACIONES_AUL` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`ID_AUL`),
  UNIQUE KEY `AULA_LABORATORIO_PK` (`ID_AUL`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `aula_laboratorio` */

insert  into `aula_laboratorio`(`ID_AUL`,`NOMBRE_AUL`,`LATITUD_AUL`,`LONGITUD_AUL`,`ALTURA_AUL`,`FOTO_AUL`,`OBSERVACIONES_AUL`) values (1,'Laboratorio de Desarrollo','2345','34563','35736','habitacion-nino-fondo-interior-dormitorio-nino-nino_33099-172.jpg','Se encuentra en el segundo piso de la abejita (parte izquierda del edificio)'),(2,'EIS102','938255','824752','894725','descarga.jpg','Primer piso de la abejita'),(3,'EIS 105','8749573','385745','738572','WIN_20190611_14_28_23_Pro.jpg','');

/*Table structure for table `carrera` */

DROP TABLE IF EXISTS `carrera`;

CREATE TABLE `carrera` (
  `ID_CAR` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `NOMBRE_CAR` varchar(150) NOT NULL,
  `DIRECTOR_CAR` varchar(100) NOT NULL,
  `DURACION_CAR` int(20) NOT NULL,
  `TITULO_OBT_CAR` varchar(120) NOT NULL,
  PRIMARY KEY (`ID_CAR`),
  UNIQUE KEY `CARRERA_PK` (`ID_CAR`),
  KEY `FK_USUARIO_PERTENE_CARRERA` (`NOMBRE_CAR`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `carrera` */

insert  into `carrera`(`ID_CAR`,`NOMBRE_CAR`,`DIRECTOR_CAR`,`DURACION_CAR`,`TITULO_OBT_CAR`) values (1,'Sistemas Informáticos','Patricio',9,'Ingeniero/a en Sistemas Informáticos'),(2,'Software','Patricio Moreno',5,'Ingeniero en Software'),(3,'Computación','Nicol Lapenti',5,'Licenciado en Computación');

/*Table structure for table `carrera_semestre` */

DROP TABLE IF EXISTS `carrera_semestre`;

CREATE TABLE `carrera_semestre` (
  `ID_SEM` int(11) unsigned NOT NULL,
  `ID_CAR` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID_SEM`,`ID_CAR`),
  UNIQUE KEY `CARRERA_SEMESTRE_PK` (`ID_SEM`,`ID_CAR`),
  KEY `CARRERA_SEMESTRE2_FK` (`ID_CAR`),
  KEY `CARRERA_SEMESTRE_FK` (`ID_SEM`),
  CONSTRAINT `FK_CARRERA__CARRERA_S_SEMESTRE` FOREIGN KEY (`ID_CAR`) REFERENCES `carrera` (`ID_CAR`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_CARRER_CARRERA_S_SEMESTRE` FOREIGN KEY (`ID_SEM`) REFERENCES `semestre` (`ID_SEM`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `carrera_semestre` */

insert  into `carrera_semestre`(`ID_SEM`,`ID_CAR`) values (1,1),(1,2),(1,3),(2,1),(2,2),(2,3),(3,1),(3,2),(3,3),(4,1),(4,2),(4,3),(5,1),(5,2),(5,3),(6,1),(6,3),(7,1),(7,3),(8,1),(8,3),(9,1),(9,3),(10,1),(10,3);

/*Table structure for table `dia` */

DROP TABLE IF EXISTS `dia`;

CREATE TABLE `dia` (
  `ID_DIA` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `DESCRIPCION_DIA` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_DIA`),
  UNIQUE KEY `DIA_PK` (`ID_DIA`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `dia` */

insert  into `dia`(`ID_DIA`,`DESCRIPCION_DIA`) values (1,'Lunes'),(2,'Martes'),(3,'Miercoles'),(4,'Jueves'),(5,'Viernes');

/*Table structure for table `docente` */

DROP TABLE IF EXISTS `docente`;

CREATE TABLE `docente` (
  `CEDULA_DOC` varchar(11) NOT NULL,
  `NOMBRES_DOC` varchar(50) NOT NULL,
  `APELLIDOS_DOC` varchar(50) NOT NULL,
  `TITULO_DOC` varchar(200) DEFAULT NULL,
  `CELULAR_DOC` varchar(10) DEFAULT NULL,
  `FOTO_DOC` mediumtext CHARACTER SET latin1 COLLATE latin1_bin,
  PRIMARY KEY (`CEDULA_DOC`),
  UNIQUE KEY `DOCENTE_PK` (`CEDULA_DOC`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `docente` */

insert  into `docente`(`CEDULA_DOC`,`NOMBRES_DOC`,`APELLIDOS_DOC`,`TITULO_DOC`,`CELULAR_DOC`,`FOTO_DOC`) values ('0602927421','Vicky Nathali','Arrobo Rivera','Ingeniera en Sistema','09599478','2014-01-12 23.22.32.jpg'),('0607835241','Veronica Alexia','Bosquez Farinango','Master en Computación','0959960362',NULL),('0608736421','Liliana Lorena','López Aguirre','Master en TICS','0976436281',NULL),('1789563748','Yadira Estefania','Ruiz','Ingeniera Industrial','',NULL),('2200504268','Jenny Magaly','Rivera Sarango','Master en Base de Datos','0959940392','IMG-20151116-WA0001.jpg');

/*Table structure for table `estudiante` */

DROP TABLE IF EXISTS `estudiante`;

CREATE TABLE `estudiante` (
  `CEDULA_USU` varchar(11) NOT NULL,
  `SEMESTRE_EST` varchar(50) NOT NULL,
  `PARALELO_EST` varchar(5) NOT NULL,
  PRIMARY KEY (`CEDULA_USU`),
  UNIQUE KEY `ESTUDIANTE_PK` (`CEDULA_USU`),
  CONSTRAINT `FK_ESTUDIAN_PERSONA_E_USUARIO` FOREIGN KEY (`CEDULA_USU`) REFERENCES `usuario` (`CEDULA_USU`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `estudiante` */

/*Table structure for table `hora` */

DROP TABLE IF EXISTS `hora`;

CREATE TABLE `hora` (
  `ID_HORA` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `INICIO_HORA` time NOT NULL,
  `FIN_HORA` time NOT NULL,
  PRIMARY KEY (`ID_HORA`),
  UNIQUE KEY `HORA_PK` (`ID_HORA`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `hora` */

insert  into `hora`(`ID_HORA`,`INICIO_HORA`,`FIN_HORA`) values (1,'07:00:00','09:00:00'),(2,'09:00:00','11:00:00'),(3,'11:00:00','13:00:00'),(4,'13:00:00','15:00:00'),(5,'15:00:00','17:00:00'),(6,'17:00:00','19:00:00');

/*Table structure for table `horario` */

DROP TABLE IF EXISTS `horario`;

CREATE TABLE `horario` (
  `ID_AUL` int(11) unsigned NOT NULL,
  `ID_DIA` int(11) unsigned NOT NULL,
  `ID_HORA` int(11) unsigned NOT NULL,
  `ID_SEM` int(11) unsigned NOT NULL,
  `ID_PER` int(11) unsigned NOT NULL,
  `CEDULA_DOC` varchar(11) NOT NULL,
  `CODIGO_ASIG` varchar(9) NOT NULL,
  `PARALELO_PLA` varchar(5) NOT NULL,
  `OBSERVACIONES_HOR` varchar(300) DEFAULT NULL,
  `ID_CAR` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID_AUL`,`ID_DIA`,`ID_HORA`,`ID_SEM`,`ID_PER`,`CEDULA_DOC`,`CODIGO_ASIG`,`PARALELO_PLA`,`ID_CAR`),
  KEY `ID_CAR` (`ID_CAR`),
  KEY `ID_DIA` (`ID_DIA`) USING BTREE,
  KEY `ID_HORA` (`ID_HORA`) USING BTREE,
  KEY `PARALELO_PLA` (`PARALELO_PLA`) USING BTREE,
  KEY `ID_AULA` (`ID_AUL`) USING BTREE,
  KEY `ID_SEMESTRE` (`ID_SEM`) USING BTREE,
  KEY `CEDULA_DOCENTE` (`CEDULA_DOC`) USING BTREE,
  KEY `ID_PERIODO` (`ID_PER`) USING BTREE,
  KEY `CODIGO_ASIGNATURA` (`CODIGO_ASIG`) USING BTREE,
  CONSTRAINT `FK_HORARIO_HORARIO1_PLAN_CAR` FOREIGN KEY (`ID_CAR`) REFERENCES `planificacion` (`ID_CAR`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_HORARIO_HORARIO2_DIA` FOREIGN KEY (`ID_DIA`) REFERENCES `dia` (`ID_DIA`) ON UPDATE CASCADE,
  CONSTRAINT `FK_HORARIO_HORARIO3_HORA` FOREIGN KEY (`ID_HORA`) REFERENCES `hora` (`ID_HORA`) ON UPDATE CASCADE,
  CONSTRAINT `FK_HORARIO_HORARIO4_PLAN_SEM` FOREIGN KEY (`ID_SEM`) REFERENCES `planificacion` (`ID_SEM`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_HORARIO_HORARIO5_PLAN_PER` FOREIGN KEY (`ID_PER`) REFERENCES `planificacion` (`ID_PER`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_HORARIO_HORARIO6_PLAN_DOC` FOREIGN KEY (`CEDULA_DOC`) REFERENCES `planificacion` (`CEDULA_DOC`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_HORARIO_HORARIO7_PLAN_ASIG` FOREIGN KEY (`CODIGO_ASIG`) REFERENCES `planificacion` (`CODIGO_ASIG`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_HORARIO_HORARIO8_PLAN_PAR` FOREIGN KEY (`PARALELO_PLA`) REFERENCES `planificacion` (`PARALELO_PLA`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_HORARIO_HORARIO_AULA_LAB` FOREIGN KEY (`ID_AUL`) REFERENCES `aula_laboratorio` (`ID_AUL`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `horario` */

insert  into `horario`(`ID_AUL`,`ID_DIA`,`ID_HORA`,`ID_SEM`,`ID_PER`,`CEDULA_DOC`,`CODIGO_ASIG`,`PARALELO_PLA`,`OBSERVACIONES_HOR`,`ID_CAR`) values (1,2,2,6,1,'2200504268','SOFT787','0','',1),(1,2,3,6,1,'2200504268','SOFT787','0','',1),(1,3,3,1,1,'2200504268','IS1414P','0','',2),(1,3,5,1,1,'0608736421','SOFI114','0','prueba 1 con modal',2),(1,4,2,1,1,'2200504268','IS1414P','0','',2),(1,5,1,6,1,'2200504268','SOFT787','0','',1),(1,5,4,1,1,'0608736421','SOFI114','0','',2),(1,5,4,6,1,'2200504268','SOFT787','0','',1),(2,1,1,1,1,'0608736421','SOFI114','0','',2),(2,2,1,1,1,'2200504268','IS1414P','0','',2),(2,5,1,1,1,'0608736421','SOFI114','0','',2);

/*Table structure for table `periodo_academico` */

DROP TABLE IF EXISTS `periodo_academico`;

CREATE TABLE `periodo_academico` (
  `ID_PER` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `INICIO_PER` varchar(70) NOT NULL,
  `FIN_PER` varchar(70) NOT NULL,
  `OBSERVACIONES_PER` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`ID_PER`),
  UNIQUE KEY `PERIODO_ACADEMICO_PK` (`ID_PER`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `periodo_academico` */

insert  into `periodo_academico`(`ID_PER`,`INICIO_PER`,`FIN_PER`,`OBSERVACIONES_PER`) values (1,'2019-03-01','2019-07-17','primer periodo'),(2,'2019-11-09','2020-02-27','segundo periodo'),(3,'2018-02-02','2018-07-06','');

/*Table structure for table `planificacion` */

DROP TABLE IF EXISTS `planificacion`;

CREATE TABLE `planificacion` (
  `ID_CAR` int(11) unsigned NOT NULL,
  `ID_SEM` int(11) unsigned NOT NULL,
  `CEDULA_DOC` varchar(11) NOT NULL,
  `CODIGO_ASIG` varchar(9) NOT NULL,
  `ID_PER` int(22) unsigned NOT NULL,
  `PARALELO_PLA` varchar(5) NOT NULL,
  `PDF_PLA` mediumtext,
  `OBSERVACIONES_PLA` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`ID_CAR`,`ID_SEM`,`CEDULA_DOC`,`CODIGO_ASIG`,`ID_PER`,`PARALELO_PLA`),
  KEY `ID_SEMESTRE` (`ID_SEM`) USING BTREE,
  KEY `ID_CARRERA` (`ID_CAR`) USING BTREE,
  KEY `CEDULA_DOCENTE` (`CEDULA_DOC`) USING BTREE,
  KEY `CODIGO_ASIGNATURA` (`CODIGO_ASIG`) USING BTREE,
  KEY `ID_PERIODO` (`ID_PER`) USING BTREE,
  KEY `PARALELO_PLA` (`PARALELO_PLA`),
  CONSTRAINT `FK_PLANIFIC_PLANIFICA_ASIGNATU` FOREIGN KEY (`CODIGO_ASIG`) REFERENCES `asignatura` (`CODIGO_ASIG`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_PLANIFIC_PLANIFICA_CARRERA` FOREIGN KEY (`ID_CAR`) REFERENCES `carrera_semestre` (`ID_CAR`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_PLANIFIC_PLANIFICA_DOCENTE` FOREIGN KEY (`CEDULA_DOC`) REFERENCES `docente` (`CEDULA_DOC`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_PLANIFIC_PLANIFICA_PERIODO` FOREIGN KEY (`ID_PER`) REFERENCES `periodo_academico` (`ID_PER`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_PLANIFIC_PLANIFICA_SEMESTRE` FOREIGN KEY (`ID_SEM`) REFERENCES `carrera_semestre` (`ID_SEM`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `planificacion` */

insert  into `planificacion`(`ID_CAR`,`ID_SEM`,`CEDULA_DOC`,`CODIGO_ASIG`,`ID_PER`,`PARALELO_PLA`,`PDF_PLA`,`OBSERVACIONES_PLA`) values (1,6,'2200504268','SOFT787',2,'0',NULL,''),(2,1,'0608736421','SOFI114',2,'0',NULL,''),(2,1,'2200504268','IS1414P',2,'0',NULL,''),(2,4,'0607835241','SOFI510',1,'2','OAS_oasis.docx',''),(2,5,'0607835241','SOFI114',2,'1',NULL,'');

/*Table structure for table `planificacion2` */

DROP TABLE IF EXISTS `planificacion2`;

CREATE TABLE `planificacion2` (
  `ID_SEM` int(11) unsigned NOT NULL,
  `CEDULA_DOC` varchar(11) NOT NULL,
  `CODIGO_ASIG` varchar(9) NOT NULL,
  `ID_PER` int(11) unsigned NOT NULL,
  `PARALELO_PLA` varchar(5) NOT NULL,
  `PDF_PLA` mediumtext,
  `OBSERVACIONES_PLA` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`ID_SEM`,`CEDULA_DOC`,`CODIGO_ASIG`,`ID_PER`,`PARALELO_PLA`),
  KEY `FK_PLANIFIC_PLANIFICA_ASIGNATU` (`CODIGO_ASIG`),
  KEY `FK_PLANIFIC_PLANIFICA_DOCENTE` (`CEDULA_DOC`),
  KEY `FK_PLANIFIC_PLANIFICA_PERIODO` (`ID_PER`),
  KEY `PARALELO_PLA` (`PARALELO_PLA`),
  KEY `FK_PLANIFIC_PLANIFICA_SEM_CAR` (`ID_SEM`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `planificacion2` */

insert  into `planificacion2`(`ID_SEM`,`CEDULA_DOC`,`CODIGO_ASIG`,`ID_PER`,`PARALELO_PLA`,`PDF_PLA`,`OBSERVACIONES_PLA`) values (1,'0602927421','SOFI114',2,'0',NULL,''),(1,'0607835241','SOFT787',1,'0',NULL,''),(1,'0608736421','IS1414P',1,'A',NULL,'ninguno'),(6,'2200504268','SOFI114',1,'1',NULL,''),(7,'0607835241','SOFI110',1,'0',NULL,''),(8,'0607835241','SOFI510',1,'3','COLEGIOS2019.pdf',''),(9,'0602927421','SOFI114',1,'2',NULL,''),(10,'0607835241','SOFI114',1,'3',NULL,'');

/*Table structure for table `semestre` */

DROP TABLE IF EXISTS `semestre`;

CREATE TABLE `semestre` (
  `ID_SEM` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `DESCRIPCION_SEM` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_SEM`),
  UNIQUE KEY `SEMESTRE_PK` (`ID_SEM`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `semestre` */

insert  into `semestre`(`ID_SEM`,`DESCRIPCION_SEM`) values (1,'Primero'),(2,'Segundo'),(3,'Tercero'),(4,'Cuarto'),(5,'Quinto'),(6,'Sexto'),(7,'Septimo'),(8,'Octavo'),(9,'Noveno'),(10,'Décimo');

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `CEDULA_USU` varchar(11) NOT NULL,
  `ID_CAR` int(11) unsigned NOT NULL,
  `CODIGO_ROL` int(11) DEFAULT NULL,
  `NOMBRES_USU` varchar(70) NOT NULL,
  `APELLIDOS_USU` varchar(70) NOT NULL,
  `USUARIO_USU` varchar(30) NOT NULL,
  `CONTRASENA_USU` varchar(200) NOT NULL,
  `FOTO_USU` mediumtext CHARACTER SET latin1 COLLATE latin1_bin,
  PRIMARY KEY (`CEDULA_USU`),
  UNIQUE KEY `USUARIO_PK` (`CEDULA_USU`),
  KEY `USUARIO_CARRERA_FK` (`ID_CAR`),
  KEY `USUARIO_ROL_FK` (`CODIGO_ROL`),
  CONSTRAINT `FK_USUARIO_USUARIO_C_CARRERA` FOREIGN KEY (`ID_CAR`) REFERENCES `carrera` (`ID_CAR`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `usuario` */

insert  into `usuario`(`CEDULA_USU`,`ID_CAR`,`CODIGO_ROL`,`NOMBRES_USU`,`APELLIDOS_USU`,`USUARIO_USU`,`CONTRASENA_USU`,`FOTO_USU`) values ('1756455885',2,NULL,'Miguel Antonio','Guerra Bolaños','Migue','827ccb0eea8a706c4c34a16891f84e7b','WIN_20190611_14_27_51_Pro.jpg'),('2200504260',1,1,'Vicky Nathali','Arrobo Rivera','Vicky','827ccb0eea8a706c4c34a16891f84e7b',NULL),('2300658374',3,NULL,'Francisca Janneth ','Rivera Sarango','Francisca','827ccb0eea8a706c4c34a16891f84e7b',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
