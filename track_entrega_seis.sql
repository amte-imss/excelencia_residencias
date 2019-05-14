begin TRANSACTION;

CREATE TABLE excelencia.ganador (
	id_ganador serial NOT NULL,
	matricula varchar(15) NOT NULL,
	nombre varchar(100) NOT NULL,
	apellido_paterno varchar(100) NOT NULL,
	apellido_materno varchar(100) NULL,
	delegacion varchar(100) NULL,
	puntaje_excelencia_docente numeric(5,2) NULL,
	nivel varchar(5) NOT NULL,
	estatus_documentacion varchar(400) NULL,
	CONSTRAINT ganador_pkey PRIMARY KEY (id_ganador)
);


INSERT INTO excelencia.ganador VALUES(22,'99014650','JUAN MANUEL','MARQUEZ','ROMERO','AGUASCALIENTES',12.5,'III','Documento valido, Documento por corregir, Documento no valido');
INSERT INTO excelencia.ganador VALUES(31,'7683022','MADTIE','DE LEON','ALDABA','BAJA CALIFORNIA',12.5,'III','Constancia valida');
INSERT INTO excelencia.ganador VALUES(32,'98020718','VANESSA ISELA','BERMUDEZ','VILLALPANDO','BAJA CALIFORNIA',12.5,'III','Constancia valida');
INSERT INTO excelencia.ganador VALUES(33,'98020769','SALVADOR','VELAZCO','ARAIZA','BAJA CALIFORNIA',10,'III','Constancia por corregir');
INSERT INTO excelencia.ganador VALUES(41,'99028049','RAQUEL','SOLIS','SANCHEZ','BAJA CALIFORNIA',12.5,'III','puede concursar');
INSERT INTO excelencia.ganador VALUES(40,'99332495','LUIS ERNESTO','BALCAZAR','RINCON','CHIAPAS',12.5,'III','PUEDE CONCURSAR, CUENTA UNICAMENTE CON UNA CONSTANCIA INSTITUCIONAL');
INSERT INTO excelencia.ganador VALUES(24,'99086305','GREGORIO','PE&A','RODRIGUEZ','CHIHUAHUA',10,'III','Documento valido, Documento no valido');
INSERT INTO excelencia.ganador VALUES(13,'98051314','IVAN ALBERTO','MIJARES','MIJARES','COAHUILA',10,'III','Documento valido');
INSERT INTO excelencia.ganador VALUES(35,'99051641','KARLA DEYANIRA','AYALA','TORRES','COAHUILA',12.5,'III','Constancia valida');
INSERT INTO excelencia.ganador VALUES(43,'11660511','SANTA','VEGA','MENDOZA','D F 1 NORTE',20,'I','Pertemece a PNPC,  15 puntos, Satisfaccion 5 puntos  Total 20 puntos No subio constancias. Califica nivel I ');
INSERT INTO excelencia.ganador VALUES(3,'99362280','ESTHER','AZCARATE','GARCIA','D F 2 NORTE',30,'I','Documento valido, Documento por corregir');
INSERT INTO excelencia.ganador VALUES(4,'99366361','RODRIGO','VILLASE&OR','HIDALGO','D F 2 NORTE',30,'I','Documento valido, Documento no valido');
INSERT INTO excelencia.ganador VALUES(5,'99363367','EUGENIA DOLORES','RUIZ','CRUZ','D F 2 NORTE',30,'I','Documento valido, Documento no valido');
INSERT INTO excelencia.ganador VALUES(39,'98360777','JAZMIN','MELGOZA','ARCOS','D F 2 NORTE',10,'III','Constancia valida');
INSERT INTO excelencia.ganador VALUES(2,'99377278','EDUARDO','VILCHIS','CHAPARRO','D F 3 SUR',35,'I','Documento valido, Documento por corregir, Documento no valido');
INSERT INTO excelencia.ganador VALUES(29,'99386421','RICARDO','FLORES','GALICIA','D F 3 SUR',10,'III','Constancia valida');
INSERT INTO excelencia.ganador VALUES(36,'99375202','NAYELI XOCHIQUETZAL','ORTIZ','OLVERA','D F 3 SUR',12.5,'III','Constancia por corregir');
INSERT INTO excelencia.ganador VALUES(16,'99102110','ALINA','RODARTE','REVELES','DURANGO',15,'II','Documento valido');
INSERT INTO excelencia.ganador VALUES(23,'99103579','JORGE EDUARDO','RODRIGUEZ','RENTERIA','DURANGO',15,'III','Documento valido, Documento no valido');
INSERT INTO excelencia.ganador VALUES(28,'99169207','FERNANDO','REYES','PEREZ','EDO MEX PTE',10,'III','Documento valido, Documento por corregir, Documento no valido');
INSERT INTO excelencia.ganador VALUES(1,'8343454','ELISEO','LUIS','LOPEZ','GUANAJUATO',30,'I','Documento valido');
INSERT INTO excelencia.ganador VALUES(17,'99231560','HECTOR MANUEL','GOMEZ','ZAPATA','GUANAJUATO',15,'II','Documento valido');
INSERT INTO excelencia.ganador VALUES(25,'99126151','ARIOTH','URE&A','MARTINEZ','GUERRERO',12.5,'III','Documento valido, Documento no valido');
INSERT INTO excelencia.ganador VALUES(21,'9730435','ROSA ELVIA','GUERRERO','HERNANDEZ','HIDALGO',10,'III','Documento valido');
INSERT INTO excelencia.ganador VALUES(8,'991429735','ADRIANA','ALVARADO','ZERME&O','JALISCO',22.5,'I','Documento valido, Documento no valido');
INSERT INTO excelencia.ganador VALUES(26,'991411794','EVA MARIA','ALBA','GARCIA','JALISCO',12.5,'III','Documento valido, Documento no valido');
INSERT INTO excelencia.ganador VALUES(37,'11406674','LUZ REBECA','RODRIGUEZ','RIVERA','JALISCO',25,'I','Constancia por corregir');
INSERT INTO excelencia.ganador VALUES(9,'99170199','LUCILA','AYALA','BARRIGA','MICHOACAN',22.5,'I','Documento valido, Documento por corregir, Documento no valido');
INSERT INTO excelencia.ganador VALUES(10,'98373272','JATZIRI GABRIELA','SILVA','CONTRERAS','MICHOACAN',22.5,'I','Documento valido, Documento no valido');
INSERT INTO excelencia.ganador VALUES(11,'99175406','PAULA','CHACON','VALLADARES','MICHOACAN',22.5,'I','Documento valido, Documento no valido');
INSERT INTO excelencia.ganador VALUES(12,'99172144','VENICE','CHAVEZ','VALENCIA','MICHOACAN',22.5,'I','Documento valido, Documento no valido');
INSERT INTO excelencia.ganador VALUES(6,'99253706','CARLOS ALBERTO','MORENO','TREVI&O','NUEVO LEON',20,'I','Documento valido');
INSERT INTO excelencia.ganador VALUES(19,'98208676','MARIA NORA','VITTI','SANCHEZ','NUEVO LEON',12.5,'III','Documento valido, Documento por corregir, Documento no valido');
INSERT INTO excelencia.ganador VALUES(30,'98204601','LORENA GUADALUPE','VILLANUEVA','SOSA','NUEVO LEON',12.5,'III','Constancia valida');
INSERT INTO excelencia.ganador VALUES(42,'99231570','ROXANA GISELA','CERVANTES','BECERRA','QUERETARO',10,'III','5 años demuestra, 5 puntos de la sede. Califica como ganadora. No dio "clic" pero si cumple criterios  10 puntos nivel III');
INSERT INTO excelencia.ganador VALUES(14,'99370523','ALBERTO','RUIZ','MONDRAGON','SAN LUIS POTOSI',22.5,'I','Documento valido, Documento por corregir, Documento no valido');
INSERT INTO excelencia.ganador VALUES(15,'99250766','MARIA DEL PILAR','ARREDONDO','CUELLAR','SAN LUIS POTOSI',17.5,'II','Documento valido, Documento no valido');
INSERT INTO excelencia.ganador VALUES(18,'99252002','DORA MARIA','BECERRA','LOPEZ','SAN LUIS POTOSI',20,'I','Documento valido, Documento por corregir, Documento no valido');
INSERT INTO excelencia.ganador VALUES(7,'99322596','ABIGAIL','CONTRERAS','GOMEZ','VERACRUZ SUR',17.5,'II','Documento valido');
INSERT INTO excelencia.ganador VALUES(20,'99329249','ANDRES CALEB','PLIEGO','DIAZ MIRON','VERACRUZ SUR',12.5,'III','Documento valido, Documento no valido');
INSERT INTO excelencia.ganador VALUES(27,'98350545','JUAN RAMON','GARCIA','DIAZ','VERACRUZ SUR',10,'III','Documento valido, Documento no valido');
INSERT INTO excelencia.ganador VALUES(38,'99367326','JOSE IVAN','SORIA','BERNAL','VERACRUZ SUR',10,'III','Constancia no valida');
INSERT INTO excelencia.ganador VALUES(34,'7214014','MANUEL JESUS','ESCAMILLA','SOSA','YUCATAN',15,'II','Constancia valida, Constancia no valida');


insert into idiomas.traduccion values('lbl_ganador','lbl','ganador','{"es":"Felicidades $$nombre$$ $$apellido_paterno$$ $$apellido_materno$$ ($$matricula$$). Texto de ganador. $$nivel$$","en":"Felicidades $$nombre$$ $$apellido_paterno$$ $$apellido_materno$$ ($$matricula$$). Texto de ganador. $$nivel$$"}');
insert into idiomas.traduccion values('lbl_no_ganador','lbl','ganador','{"es":"Felicidades $$nombre$$ $$apellido_paterno$$ $$apellido_materno$$ ($$matricula$$). Texto de NO ganador. $$nivel$$","en":"Felicidades $$nombre$$ $$apellido_paterno$$ $$apellido_materno$$ ($$matricula$$). Texto de NO ganador. $$nivel$$"}');

commit;