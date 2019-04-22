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
config='{"btn_agregar_curso":"true","btn_editar_curso":"true","btn_envio_datos":"true","btn_envio":"true","btn_elimina_curso":"true","modificar_archivos":"true" }', 
transicion='{"SIN_COMITE":""}' 
where cve_estado_solicitud in('REGISTRO');


/*Agrear modulos */
--get_detalle_curso
/* Modificaciones para actualizar 20190418 */
CREATE TABLE excelencia.convocatoria (
	id_convocatoria serial,
	nombre varchar(100) NULL,
	anio int4 NOT NULL,
	activo bool NULL DEFAULT true,
	registro bool NULL DEFAULT true,
	revision bool NULL DEFAULT false,
	CONSTRAINT convocatoria_pkey PRIMARY KEY (id_convocatoria)
);

insert into excelencia.convocatoria values(1, 'Excelencia 2019', 2019, true, true, true);

insert into idiomas.traduccion values('msg_convocatoria_deshabilitada', 'lbl', 'mensajes', '{"es":"El acceso no esta disponible","en":"El acceso no esta disponible."}');

/*Carga opciones*/	
insert into  excelencia.opcion (opcion,tipo,activo) values 
('Constancia valida','VALIDA_CURSO',true),
('Constancia por corregir','VALIDA_CURSO',true),
('Constancia no valida','VALIDA_CURSO',true),
('Documento valido','VALIDA_DOCUMENTOS',true),
('Documento por corregir','VALIDA_DOCUMENTOS',true),
('Documento no valido','VALIDA_DOCUMENTOS',true)
;

/* Modificaciones para actualizar los estados de la solicitud */
update excelencia.estado_solicitud set transicion='{"EN_REVISION":""}' WHERE cve_estado_solicitud='SIN_COMITE';

insert into excelencia.estado_solicitud values('EN_REVISION','En revision',null,true,'{"btn_asignar_revisor":"true"}','{"REVISADO":"","CORRECCION":""}');
insert into excelencia.estado_solicitud values('REVISADO','Revisado',null, true,null,null);
insert into excelencia.estado_solicitud values('CORRECCION','En correcci�n',null, true,null,'{"SIN_COMITE":""}');


/* Modificaciones para actualizar la tabla convocatoria 20190420 */
alter table excelencia.convocatoria add column acceso boolean not null default true;
alter table excelencia.solicitud add column id_convocatoria integer;

update excelencia.solicitud set id_convocatoria=1;



/* Modificaciones para actualizar listados 20190422 */
insert into idiomas.traduccion values('col_matricula','lbl','sin_comite','{"es":"Matrícula","en":"Matrícula"}');
insert into idiomas.traduccion values('col_nombre','lbl','sin_comite','{"es":"Nombre","en":"Nombre"}');
insert into idiomas.traduccion values('col_apellido_paterno','lbl','sin_comite','{"es":"Apellido paterno","en":"Apellido paterno"}');
insert into idiomas.traduccion values('col_apellido_materno','lbl','sin_comite','{"es":"Apellido materno","en":"Apellido materno"}');
insert into idiomas.traduccion values('col_delegacion','lbl','sin_comite','{"es":"Delegación","en":"Delegación"}');
insert into idiomas.traduccion values('col_fecha_registro','lbl','sin_comite','{"es":"Fecha de registro","en":"Fecha de registro"}');

insert into idiomas.traduccion values('tab_ca','tab','tabs_gestor','{"es":"Candidatos","en":"Candidatos"}');
