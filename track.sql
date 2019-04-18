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


/* Modificaciones para actualizar 20190417 */
insert into idiomas.traduccion (clave_traduccion, clave_tipo, clave_grupo, lang) values
('reg_btn_actualizar', 'lbl', 'registro_excelencia', '{"es":"Actualizar","en":"Update"}'),
('reg_exc_acciones', 'lbl', 'registro_excelencia', '{"es":"Acciones","en":"Actions"}')
;

ALTER TABLE excelencia.historico_solicitud ALTER COLUMN fecha SET DEFAULT now();

alter table excelencia.estado_solicitud add column config json null;
alter table excelencia.estado_solicitud add column transicion json null;

/*Actualiacion, se agrego eliminar curso*/
update excelencia.estado_solicitud set 
config='{"btn_agregar_curso":"true","btn_editar_curso":"true","btn_envio_datos":"true","btn_envio":"true","btn_elimina_curso":"true"}', transicion='{"SIN_COMITE":""}' 
where cve_estado_solicitud in('REGISTRO');


/*Agrear modulos */
--get_detalle_curso



