begin TRANSACTION;
update excelencia.estado_solicitud set 
config='{"btn_agregar_curso":"true","btn_editar_curso":"true","btn_elimina_curso":"true","btn_envio_doctos":"true","btn_envio":"true","modificar_archivos":"true","modificar_datos_generales":"true"}'
where cve_estado_solicitud = 'REGISTRO';


insert into sistema.modulos (clave_modulo, nombre,url, activo, modulo_padre_clave, orden, clave_configurador_modulo) values 
('UPD_DATOS_GEN_SOL',	'{"es":"Actualiza datos generales de solicitud","en":""}',	'/registro/actualiza_datos_generales',true,'M2nxOiMxoD',1,'ACCION')
;
insert into sistema.roles_modulos (clave_modulo, clave_rol, activo) values
('UPD_DATOS_GEN_SOL','INV',true)
;

insert into idiomas.traduccion values('nota_revision_registro','nota','registro_excelencia','{"es":"Nota: Recuerde que es importante tomar en cuenta las observaciones realizadas por el Comité evaluador ya que de ello depende su correcta participación para el Premio a la Excelencia Docente.","en":""}');
insert into idiomas.traduccion values('lbl_obseraciones_revisor_solicitud','lbl','registro_excelencia','{"es":"Observaciones por parte del revisor","en":""}');

insert into idiomas.traduccion values('danger_actualizacion_gen','insert_update','registro_excelencia','{"es":"No fue posible actualizar la información. Por favor intentelo nuevamente","en":""}');
insert into idiomas.traduccion values('success_actualizacion_gen','insert_update','registro_excelencia','{"es":"La información se actualizo correctamente","en":""}');
insert into idiomas.traduccion values('danger_guardar_gen','insert_update','registro_excelencia','{"es":"No fue posible guardar la información. Por favor intentelo nuevamente","en":""}');
insert into idiomas.traduccion values('success_guardar_gen','insert_update','registro_excelencia','{"es":"La información se guardo correctamente","en":""}');


insert into idiomas.traduccion values('danger_elimina_gen','insert_update','registro_excelencia','{"es":"Ocurrió un error durante la eliminación.","en":""}');
insert into idiomas.traduccion values('success_eliminar_gen','lbl','registro_excelencia','{"es":"Eliminación realizada correctamente.","en":""}');

insert into idiomas.traduccion values('succes_actualizar_archivo','insert_update','registro_excelencia','{"es":"El archivo se actualizo correctamente","en":""}');
insert into idiomas.traduccion values('danger_guardar_archivo','insert_update','registro_excelencia','{"es":"No fue posible guardar el archivo. Por favor intentelo nuevamente","en":""}');
update idiomas.traduccion  set lang = '{"es":"Candidatos","en":"Candidatos"}' where clave_traduccion = 'tab_ca' and clave_grupo='tabs_gestor' ;

update excelencia.estado_solicitud set 
config='{"btn_agregar_curso":"false","btn_editar_curso":"true","btn_envio_datos":"false","btn_envio":"false","btn_elimina_curso":"false","modificar_archivos":"true","modificar_datos_generales":"true" }'
where cve_estado_solicitud = 'SIN_COMITE';

CREATE TABLE excelencia.nivel (
	id_nivel bpchar not null,
	descripcion json null,
	activo bool default true,
	PRIMARY KEY (id_nivel)
)
WITH (
	OIDS=FALSE
) ;


CREATE TABLE excelencia.dictamen (
	id_dictamen serial,
	folio_dictamen varchar(50) NULL,
	id_solicitud int NOT NULL,
	fecha timestamp default current_timestamp,
	id_usuario int4 NULL,
	id_nivel bpchar NULL,
	aceptado bool NULL,
	premio_anterior bool NULL,
	sugerencia bpchar NULL,
	orden int4 NULL,
	promedio float8 NULL,
	PRIMARY KEY (id_dictamen),
	CONSTRAINT folio_dictamen_unico UNIQUE (folio_dictamen),
	CONSTRAINT dictamen_id_usuario_fkey FOREIGN KEY (id_usuario) REFERENCES sistema.usuarios(id_usuario) ON DELETE SET NULL ON UPDATE CASCADE,
	CONSTRAINT solicitud_dictamen_fk FOREIGN KEY (id_solicitud) REFERENCES excelencia.solicitud(id_solicitud) ON DELETE CASCADE ON UPDATE CASCADE
)
WITH (
	OIDS=FALSE
) ;

insert into excelencia.nivel(id_nivel, descripcion)  values
('n1','{"es":"Nivel 1","en":""}'),
('n2','{"es":"Nivel 2","en":""}'),
('n3','{"es":"Nivel 3","en":""}')
;

insert into sistema.modulos (clave_modulo, nombre,url, activo, modulo_padre_clave, orden, clave_configurador_modulo) values 
('SAVE_GUARDAR_DICT',	'{"es":"Guardar dictamen","en":""}',	'/gestion_revision/guarda_informacion_dictamen',true,'M2nxOiMxoD',1,'ACCION');
insert into sistema.roles_modulos (clave_modulo, clave_rol, activo) values
('SAVE_GUARDAR_DICT','ADMIN',true);

insert into excelencia.estado_solicitud values('ACEPTADOS','Aceptado',null, true,null,null);
insert into excelencia.estado_solicitud values('RECHAZADOS','Rechazado',null, true,null,null);

CREATE TABLE excelencia.envio_correos_pendientes (
	id_correo_pendiente serial,
	id_convocatoria int NULL,
	tipo_correo varchar(30) null,
	profesor varchar(256),
	matricula varchar(25),
	correo_electronico varchar(100),
	config text null,
    fue_enviado boolean default false,
	fecha timestamp default current_timestamp,
	fecha_envio timestamp null,
	PRIMARY KEY (id_correo_pendiente)
)
WITH (
	OIDS=FALSE
);



commit;