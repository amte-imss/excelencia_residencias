begin TRANSACTION;

alter table excelencia.ganador alter column nombre drop not null;
alter table excelencia.ganador alter column apellido_paterno drop not null;

insert into idiomas.traduccion values('col_ganador_matricula','lbl','ganador','{"es":"Matrícula","en":""}');
insert into idiomas.traduccion values('col_ganador_nombre','lbl','ganador','{"es":"Nombre","en":""}');
insert into idiomas.traduccion values('col_ganador_apellido_paterno','lbl','ganador','{"es":"Apellido paterno","en":""}');
insert into idiomas.traduccion values('col_ganador_apellido_materno','lbl','ganador','{"es":"Apellido materno","en":""}');
insert into idiomas.traduccion values('col_ganador_delegacion','lbl','ganador','{"es":"Delegación","en":""}');
insert into idiomas.traduccion values('col_ganador_correo','lbl','ganador','{"es":"Correo","en":""}');
insert into idiomas.traduccion values('col_ganador_fecha_registro','lbl','ganador','{"es":"Fecha de registro","en":""}');
insert into idiomas.traduccion values('col_ganador_pun_excelencia','lbl','ganador','{"es":"Puntaje excelencia docente","en":""}');
insert into idiomas.traduccion values('col_ganador_nivel','lbl','ganador','{"es":"Nivel","en":""}');
insert into idiomas.traduccion values('titulo_ganador','lbl','ganador','{"es":"Ganadores","en":""}');

commit;
