begin TRANSACTION;

alter table excelencia.evaluacion add column observacion text;

insert into idiomas.traduccion values('btn_observacion','lbl','candidatos','{"es":"Observaciones","en":"Observaciones"}');

--Actualiza puntajes de la revision de documentos de cursos
update excelencia.revision u set total_anios_curso = total_anios_cursos_validos, total_puntos_anios_cursos = total_puntos_exp_curso
from 
(SELECT r.id_revision, case when count(dc.id_documento_curso) = count(drc.id_documento_curso)  then true else false end validacion_completa, 
count(dc.id_documento_curso) total_cursos, 
count(drc.id_documento_curso) total_cursos_validados, 
sum(case when drc.id_opcion = 1 then c.anios else 0 end) total_anios_cursos_validos, 
sum(case when drc.id_opcion = 1 then 1 else 0 end) total_validos, 
sum(case when drc.id_opcion = 2 then 1 else 0 end) total_correccion, 
sum(case when drc.id_opcion = 3 then 1 else 0 end) total_no_validos,
(select t.puntaje from excelencia.tabulador t where t.tipo_tabulador='PERMANENCIA_DOCENTE' and (sum(case when drc.id_opcion = 1 then c.anios else 0 end) between rango_inicial and rango_final or (sum(case when drc.id_opcion = 1 then c.anios else 0 end) >= rango_inicial and rango_final is null))) total_puntos_exp_curso
FROM excelencia.solicitud s
INNER JOIN excelencia.curso c ON c.id_solicitud = s.id_solicitud
INNER JOIN excelencia.documento_curso dc ON dc.id_documento_curso = c.id_documento_curso
LEFT JOIN excelencia.revision r ON r.id_solicitud = s.id_solicitud
LEFT JOIN excelencia.detalle_revision_curso drc ON r.id_revision = drc.id_revision and drc.id_documento_curso = dc.id_documento_curso
WHERE r.id_revision is not null
--c.id_solicitud = '127'
--AND r.estatus = true
group by r.id_revision 
) as rc 
where rc.id_revision = u.id_revision;

--Actualiza tabla de evaluacion los "puntaje_anios_docente "
update excelencia.evaluacion eva set puntaje_anios_docente = total_puntos_anios_cursos 
from 
(select s.matricula, r.total_puntos_anios_cursos 
from excelencia.revision r
join excelencia.solicitud s on s.id_solicitud = r.id_solicitud
join excelencia.evaluacion e on e.matricula = s.matricula
where r.estatus ) as pun
where pun.matricula = eva.matricula
;

commit;