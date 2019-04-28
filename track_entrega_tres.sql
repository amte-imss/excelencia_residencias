update excelencia.estado_solicitud set 
config='{"btn_agregar_curso":"true","btn_editar_curso":"true","btn_elimina_curso":"true","btn_envio_doctos":"true","btn_envio":"true","modificar_archivos":"true","modificar_datos_generales":"true"}'
where cve_estado_solicitud = 'EN_REVISION';

update excelencia.estado_solicitud set 
config='{"btn_agregar_curso":"false","btn_editar_curso":"true","btn_envio_datos":"true","btn_envio":"true","btn_elimina_curso":"false","modificar_archivos":"true","modificar_datos_generales":"true"}'
where cve_estado_solicitud = 'EN_REVISION';

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

/*
insert into idiomas.traduccion values('','insert_update','registro_excelencia','{"es":"","en":""}');
insert into idiomas.traduccion values('','insert_update','registro_excelencia','{"es":"","en":""}');

insert into idiomas.traduccion values('','lbl','registro_excelencia','{"es":"","en":""}');
insert into idiomas.traduccion values('','lbl','registro_excelencia','{"es":"","en":""}');
*/