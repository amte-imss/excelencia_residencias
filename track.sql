CREATE TABLE excelencia.documento_curso (
	id_documento_curso serial,
	ruta varchar(255) NOT NULL,
	extension_archivo varchar(10) NOT NULL,
	fecha timestamp default current_timestamp,	
	id_tipo_documento int4 NOT NULL,
	CONSTRAINT id_documento_curso_pkey PRIMARY KEY (id_documento_curso),
	CONSTRAINT id_tipo_documento_curso_fkey FOREIGN KEY (id_tipo_documento) REFERENCES excelencia.tipo_documento(id_tipo_documento)
)
WITH (
	OIDS=FALSE
) ;

alter table excelencia.curso add column anios int2 null;
alter table excelencia.curso add column obtuvo_pnpc bool default false;
alter table excelencia.curso add column id_documento_curso int8 null;
alter table excelencia.curso add FOREIGN KEY (id_documento_curso) REFERENCES excelencia.documento_curso(id_documento_curso);


insert into excelencia.tipo_documento (id_tipo_documento, nombre, estado) values (9,'Constancia de curso','1');

/* Modificaciones para actualizar edicion de formulario */
insert into idiomas.traduccion (clave_traduccion, clave_tipo, clave_grupo, lang) values
('reg_btn_editar', 'lbl', 'registro_excelencia', '{"es":"Editar","en":"Edit"}'),
('reg_btn_cancel', 'lbl', 'registro_excelencia', '{"es":"Cancelar","en":"Cancel"}')
;