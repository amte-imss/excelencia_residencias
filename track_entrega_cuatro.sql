begin TRANSACTION;

insert into sistema.modulos (clave_modulo, nombre,url, activo, modulo_padre_clave, orden, clave_configurador_modulo) values 
('CAT_EST_SOL',	'{"es":"Estados de solicitud","en":""}',	'/catalogo/gestion_estado_solicitud',true,'ADMIN_CAT_FORO',1,'MENU')
;
--ADMIN_CAT_FORO, #menuADMIN_CAT_FORO
insert into sistema.roles_modulos (clave_modulo, clave_rol, activo) values
('CAT_EST_SOL','SUPERADMIN',true)
;

alter table excelencia.solicitud add column tipo_contratacion int4 null; 

insert into idiomas.traduccion values('col_tipo_contratacion','lbl','candidatos','{"es":"Tipo de contratación","en":"Tipo de contratación"}');
insert into idiomas.traduccion values('lbl_es_base','lbl','candidatos','{"es":"Base","en":"Base"}');
insert into idiomas.traduccion values('btn_guardar_seleccion','lbl','candidatos','{"es":"Guardar selección","en":"Guardar selección"}');
insert into idiomas.traduccion values('btn_cerrar_proceso','lbl','candidatos','{"es":"Cerrar proceso","en":"Cerrar proceso"}');

insert into idiomas.traduccion values('texto_confirmacion_guardado','lbl','candidatos','{"es":"Está seguro de querer guardar los cambios?","en":"Está seguro de querer guardar los cambios?"}');
insert into idiomas.traduccion values('texto_confirmacion_cierre','lbl','candidatos','{"es":"Está seguro de querer cerrar el proceso?","en":"Está seguro de querer cerrar el proceso?"}');
insert into idiomas.traduccion values('lbl_notas','lbl','candidatos','{"es":"Notas","en":"Notas"}');
insert into idiomas.traduccion values('lbl_notas_aceptados','lbl','candidatos','{"es":"Notas","en":"Notas"}');


commit;