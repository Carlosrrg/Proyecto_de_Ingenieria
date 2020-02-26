--Insertar Lugares--
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (1,'Francisco Morazán');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (2,'Atlántida');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (3,'Choluteca');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (4,'Colón');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (5,'Comayagua');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (6,'Copán');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (7,'Cortes');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (8,'El Paraíso');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (9,'Gracias a Dios');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (10,'Intibucá');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (11,'Islas de la Bahía');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (12,'La Paz');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (13,'Lempira');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (14,'Ocotepeque');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (15,'Olancho');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (16,'Santa Bárbara');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (17,'Valle');
Insert into TBL_LUGARES (CODIGO_LUGAR, NOMBRE_LUGAR)
values (18,'Yoro');



--Insertar Tipo de usuario--
Insert into TBL_TIPO_USUARIO (CODIGO_TIPO_USUARIO, NOMBRE_TIPO_USUARIO)
values (1,'Administrador');
Insert into TBL_TIPO_USUARIO (CODIGO_TIPO_USUARIO, NOMBRE_TIPO_USUARIO)
values (2,'Usuario normal del sistema');



--Insertar genero--
Insert into TBL_GENERO (CODIGO_GENERO, NOMBRE_GENERO)
values (1,'Masculino');
Insert into TBL_GENERO (CODIGO_GENERO, NOMBRE_GENERO)
values (2,'Femenino');



--Insertar Usuarios--
Insert into TBL_USUARIOS (CODIGO_USUARIO, CODIGO_TIPO_USUARIO, CODIGO_LUGAR, CODIGO_GENERO, NOMBRE, APELLIDO, CORREO_ELECTRONICO, CONTRASENA, TELEFONO, FECHA_NACIMIENTO)
values (1,2,1,1,'Carlos','Ramos','carlos9@gmail.com','contrasena123',50495441898,TO_DATE('06-05-1994', 'DD-MM-YYYY'));
Insert into TBL_USUARIOS (CODIGO_USUARIO, CODIGO_TIPO_USUARIO, CODIGO_LUGAR, CODIGO_GENERO, NOMBRE, APELLIDO, CORREO_ELECTRONICO, CONTRASENA, TELEFONO, FECHA_NACIMIENTO)
values (2,2,5,2,'Gloria','Mendez','gloria2020@gmail.com','Gloria2020',50498745236,TO_DATE('01-06-1990', 'DD-MM-YYYY'));
Insert into TBL_USUARIOS (CODIGO_USUARIO, CODIGO_TIPO_USUARIO, CODIGO_LUGAR, CODIGO_GENERO, NOMBRE, APELLIDO, CORREO_ELECTRONICO, CONTRASENA, TELEFONO, FECHA_NACIMIENTO)
values (3,2,9,1,'Pedro','Maradiaga','maradiaga.pedro2020@gmail.com','Pedro2',50489654123,TO_DATE('20-10-1998', 'DD-MM-YYYY'));