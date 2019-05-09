begin TRANSACTION;

alter table excelencia.evaluacion add column observacion text;

insert into idiomas.traduccion values('btn_observacion','lbl','candidatos','{"es":"Observaciones","en":"Observaciones"}');

commit;