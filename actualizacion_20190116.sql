BEGIN TRANSACTION;


CREATE TABLE "excelencia"."estado_solicitud" (
"cve_estado_solicitud" varchar(15) NOT NULL,
"nombre_estado" varchar(100) NOT NULL,
"descripcion" text,
"activo" bool NOT NULL,
PRIMARY KEY ("cve_estado_solicitud") 
);



CREATE TABLE "excelencia"."opcion" (
"id_opcion" serial,
"opcion" text NOT NULL,
"tipo" text,
"activo" bool NOT NULL,
PRIMARY KEY ("id_opcion") 
);



CREATE TABLE "excelencia"."historico_solicitud" (
"id_historico_solicitud" serial,
"id_solicitud" int4 NOT NULL,
"cve_estado_solicitud" varchar(15) NOT NULL,
"fecha" timestamp NOT NULL,
"actual" bool NOT NULL,
PRIMARY KEY ("id_historico_solicitud") 
);



CREATE TABLE "excelencia"."revision" (
"id_revision" serial,
"id_solicitud" int4 NOT NULL,
"id_usuario_revision" int4 NOT NULL,
"observaciones" text,
"estatus" bool NOT NULL DEFAULT true,
"fecha_revision" timestamp NULL,
"fecha_asignacion" timestamp NOT NULL DEFAULT now(),
PRIMARY KEY ("id_revision") 
);



CREATE TABLE "excelencia"."detalle_revision_documento" (
"id_detalle_revision_documento" serial,
"id_revision" int4 NOT NULL,
"id_documento" int4 NOT NULL,
"id_opcion" int4 NOT NULL,
"fecha" timestamp NOT NULL DEFAULT now(),
PRIMARY KEY ("id_detalle_revision_documento") 
);



CREATE TABLE "excelencia"."detalle_revision_curso" (
"id_detalle_revision_curso" serial,
"id_revision" int4 NOT NULL,
"id_documento_curso" int4 NOT NULL,
"id_opcion" int4 NOT NULL,
"fecha" timestamp NOT NULL DEFAULT now(),
PRIMARY KEY ("id_detalle_revision_curso") 
);



ALTER TABLE "excelencia"."historico_solicitud" ADD CONSTRAINT "fk_historico_solicitud" FOREIGN KEY ("id_solicitud") REFERENCES "excelencia"."solicitud" ("id_solicitud");

ALTER TABLE "excelencia"."historico_solicitud" ADD CONSTRAINT "fk_estado_solicitud" FOREIGN KEY ("cve_estado_solicitud") REFERENCES "excelencia"."estado_solicitud" ("cve_estado_solicitud");

ALTER TABLE "excelencia"."revision" ADD CONSTRAINT "fk_revision_solicitud" FOREIGN KEY ("id_solicitud") REFERENCES "excelencia"."solicitud" ("id_solicitud");

ALTER TABLE "excelencia"."revision" ADD CONSTRAINT "fk_usuario_revision_solicitud" FOREIGN KEY ("id_usuario_revision") REFERENCES "sistema"."usuarios" ("id_usuario");

ALTER TABLE "excelencia"."detalle_revision_documento" ADD CONSTRAINT "fk_detalle_revision_documento" FOREIGN KEY ("id_revision") REFERENCES "excelencia"."revision" ("id_revision");

ALTER TABLE "excelencia"."detalle_revision_documento" ADD CONSTRAINT "fk_dr_documento" FOREIGN KEY ("id_documento") REFERENCES "excelencia"."documento" ("id_documento");

ALTER TABLE "excelencia"."detalle_revision_documento" ADD CONSTRAINT "fk_dr_opcion" FOREIGN KEY ("id_opcion") REFERENCES "excelencia"."opcion" ("id_opcion");

ALTER TABLE "excelencia"."detalle_revision_curso" ADD CONSTRAINT "fk_detalle_revision_curso" FOREIGN KEY ("id_revision") REFERENCES "excelencia"."revision" ("id_revision");

ALTER TABLE "excelencia"."detalle_revision_curso" ADD CONSTRAINT "fk_dr_documento_curso" FOREIGN KEY ("id_documento_curso") REFERENCES "excelencia"."documento_curso" ("id_documento_curso");

ALTER TABLE "excelencia"."detalle_revision_curso" ADD CONSTRAINT "fk_dr_curso_opcion" FOREIGN KEY ("id_opcion") REFERENCES "excelencia"."opcion" ("id_opcion");




insert into excelencia.estado_solicitud (cve_estado_solicitud, nombre_estado, activo) VALUES('REGISTRO','Registro',true);
insert into excelencia.estado_solicitud (cve_estado_solicitud, nombre_estado, activo) VALUES('SIN_COMITE','Sin comite',true);


insert into excelencia.historico_solicitud(id_solicitud, cve_estado_solicitud, fecha, actual) select id_solicitud, 'REGISTRO', fecha, true from excelencia.solicitud where estado::integer=1;
insert into excelencia.historico_solicitud(id_solicitud, cve_estado_solicitud, fecha, actual) select id_solicitud, 'SIN_COMITE', fecha, true from excelencia.solicitud where estado::integer=2;



ALTER TABLE excelencia.solicitud drop column estado;


commit;