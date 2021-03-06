--CREAR SECUENCIA DE USUARIOS--
CREATE SEQUENCE USUARIOS_SEQ
INCREMENT BY 1
START WITH 1;


--VER VALOR ACTUAL DE LA SECUENCIA--
SELECT USUARIOS_SEQ.CURRVAL AS VALOR_ACTUAL2
FROM DUAL;


--VER SIGUIENTE VALOR DE LA SECUENCIA--
SELECT USUARIOS_SEQ.NEXTVAL AS VALOR_ACTUAL2
FROM DUAL;


--PROCEDIMIENTO PARA INGRESAR USUARIOS DE MODULO DE REGISTRO--
create or replace PROCEDURE P_AGREGAR_NUEVO_USUARIO (
            P_CODIGO_TIPO_USUARIO IN INTEGER,
            P_CODIGO_LUGAR IN INTEGER,
            P_CODIGO_GENERO IN INTEGER,
            P_CODIGO_CODIGO IN INTEGER,
            P_NOMBRE IN VARCHAR2,
            P_APELLIDO IN VARCHAR2,
            P_CORREO_ELECTRONICO IN VARCHAR2,
            P_CONTRASENA IN VARCHAR2,
            P_TELEFONO IN NUMBER,
            P_FECHA_NACIMIENTO IN DATE,
            P_FECHA_REGISTRO IN DATE,
            P_CIUDAD IN VARCHAR2,
            P_CODIGO_USUARIO out integer
)AS
BEGIN
    P_CODIGO_USUARIO:=USUARIOS_SEQ.NEXTVAL;
    INSERT INTO TBL_USUARIOS (
            CODIGO_USUARIO,
            CODIGO_TIPO_USUARIO,
            CODIGO_LUGAR,
            CODIGO_GENERO,
            CODIGO_CODIGO,
            NOMBRE,
            APELLIDO,
            CORREO_ELECTRONICO,
            CONTRASENA,
            TELEFONO,
            FECHA_NACIMIENTO,
            FECHA_REGISTRO,
            CIUDAD
    ) VALUES (
            P_CODIGO_USUARIO,
            P_CODIGO_TIPO_USUARIO,
            P_CODIGO_LUGAR,
            P_CODIGO_GENERO,
            P_CODIGO_CODIGO,
            P_NOMBRE,
            P_APELLIDO,
            P_CORREO_ELECTRONICO,
            P_CONTRASENA,
            P_TELEFONO,
            P_FECHA_NACIMIENTO,
            P_FECHA_REGISTRO,
            P_CIUDAD
    );
END;

SET SERVEROUTPUT ON;

--INVOCACION DE PROCEDIMIENTO ALMACENADO PARA GUARDAR LA CONSULTA--
DECLARE
    V_CODIGO_USUARIO INTEGER;
BEGIN
    P_AGREGAR_NUEVO_USUARIO (2, 8, 1, 1, 'Ronald', 'Arrazola', 'ronald@gmail.com', 'contrasena1234567', 70489654741, TO_DATE('12-05-1970', 'DD-MM-YYYY'), SYSDATE, 'Tegucigalpa', V_CODIGO_USUARIO);
    DBMS_OUTPUT.PUT_LINE('CODIGO_USUARIO_AGREGADO: '||V_CODIGO_USUARIO);
END;





--CREAR SECUENCIA DE TIENDAS--
CREATE SEQUENCE TIENDAS_SEQ
INCREMENT BY 1
START WITH 1;

--PROCEDIMIENTO PARA INGRESAR TIENDAS DE MODULO DE REGISTRO--
create or replace PROCEDURE P_AGREGAR_NUEVA_TIENDA (
            P_NOMBRE_TIENDA IN VARCHAR2,
            P_RTN IN NUMBER,
            P_CODIGO_TIENDA out integer
)AS
BEGIN
    P_CODIGO_TIENDA:=TIENDAS_SEQ.NEXTVAL;
    INSERT INTO TBL_TIENDAS (
            CODIGO_TIENDA,
            NOMBRE_TIENDA,
            RTN
    ) VALUES (
            P_CODIGO_TIENDA,
            P_NOMBRE_TIENDA,
            P_RTN
    );
END;

--INVOCACION DE PROCEDIMIENTO ALMACENADO PARA GUARDAR LA CONSULTA DE TIENDAS--
DECLARE
    V_CODIGO_TIENDA INTEGER;
BEGIN
    P_AGREGAR_NUEVA_TIENDA ('JETSTEREO', 12345678912345, V_CODIGO_TIENDA);
    DBMS_OUTPUT.PUT_LINE('CODIGO_TIENDA_AGREGADO: '||V_CODIGO_TIENDA);
END;






--CREAR SECUENCIA DE PRODUCTOS O SERVICIOS--
CREATE SEQUENCE PRODUCTOS_SEQ
INCREMENT BY 1
START WITH 1;


--VER VALOR ACTUAL DE LA SECUENCIA--
SELECT PRODUCTOS_SEQ.CURRVAL AS VALOR_ACTUAL
FROM DUAL;


--VER SIGUIENTE VALOR DE LA SECUENCIA--
SELECT PRODUCTOS_SEQ.NEXTVAL AS VALOR_ACTUAL
FROM DUAL;


--PROCEDIMIENTO PARA INGRESAR PRODUCTOS O SERVICIOS--
create or replace PROCEDURE P_AGREGAR_PRODUCTO_SERVICIO (
            P_CODIGO_TIPO_PUBLICACION IN INTEGER,
            P_CODIGO_TIPO_MONEDA IN INTEGER,
            P_CODIGO_ESTADO_PRODUCTO IN INTEGER,
            P_CODIGO_CATEGORIA IN INTEGER,
            P_CODIGO_ESTADO_PUBLICACION IN INTEGER,
            P_NOMBRE_PRODUCTO IN VARCHAR2,
            P_PRECIO IN NUMBER,
            P_DESCRIPCION IN VARCHAR2,
            P_FECHA_PUBLICACION IN DATE,
            P_ELIMINACION_LOGICA IN INTEGER,
            P_CODIGO_PUBLICACION_PRODUCTO out integer
)AS
BEGIN
    P_CODIGO_PUBLICACION_PRODUCTO:=PRODUCTOS_SEQ.NEXTVAL;
    INSERT INTO TBL_PUBLICACION_PRODUCTOS (
            CODIGO_PUBLICACION_PRODUCTO,
            CODIGO_TIPO_PUBLICACION,
            CODIGO_TIPO_MONEDA,
            CODIGO_ESTADO_PRODUCTO,
            CODIGO_CATEGORIA,
            CODIGO_ESTADO_PUBLICACION,
            NOMBRE_PRODUCTO,
            PRECIO,
            DESCIPCION,
            FECHA_PUBLICACION,
            ELIMINACION_LOGICA
    ) VALUES (
            P_CODIGO_PUBLICACION_PRODUCTO,
            P_CODIGO_TIPO_PUBLICACION,
            P_CODIGO_TIPO_MONEDA,
            P_CODIGO_ESTADO_PRODUCTO,
            P_CODIGO_CATEGORIA,
            P_CODIGO_ESTADO_PUBLICACION,
            P_NOMBRE_PRODUCTO,
            P_PRECIO,
            P_DESCRIPCION,
            P_FECHA_PUBLICACION,
            P_ELIMINACION_LOGICA
    );
END;

--INVOCACION DE PROCEDIMIENTO ALMACENADO PARA GUARDAR LA CONSULTA--
DECLARE
    V_CODIGO_PUBLICACION_PRODUCTO INTEGER;
BEGIN
    P_AGREGAR_PRODUCTO_SERVICIO (1, 1, 1, 1, 1, 'Iphone XS', 21000, 'El iphone es nuevo esa en caja nunca abierto solo interesados', SYSDATE, 1, V_CODIGO_PUBLICACION_PRODUCTO);
    DBMS_OUTPUT.PUT_LINE('CODIGO_PUBLICACION_PRODUCTO: '||V_CODIGO_PUBLICACION_PRODUCTO);
END;







--CREAR SECUENCIA DE IMAGENES--
CREATE SEQUENCE IMG_SEQ
INCREMENT BY 1
START WITH 1;


--VER VALOR ACTUAL DE LA SECUENCIA--
SELECT IMG_SEQ.CURRVAL AS VALOR_ACTUAL
FROM DUAL;


--VER SIGUIENTE VALOR DE LA SECUENCIA--
SELECT IMG_SEQ.NEXTVAL AS VALOR_ACTUAL
FROM DUAL;


--PROCEDIMIENTO PARA INGRESAR IMAGENES--
create or replace PROCEDURE P_AGREGAR_IMAGEN (
            P_CODIGO_TIPO_IMAGEN IN INTEGER,
            P_RUTA_IMAGEN IN VARCHAR2,
            P_ALTO_IMAGEN IN NUMBER,
            P_ANCHO_IMAGEN IN NUMBER,
            P_CODIGO_IMAGEN out integer
)AS
BEGIN
    P_CODIGO_IMAGEN:=IMG_SEQ.NEXTVAL;
    INSERT INTO TBL_IMAGENES (
            CODIGO_IMAGEN,
            CODIGO_TIPO_IMAGEN,
            RUTA_IMAGEN,
            ALTO_IMAGEN,
            ANCHO_IMAGEN
    ) VALUES (
            P_CODIGO_IMAGEN,
            P_CODIGO_TIPO_IMAGEN,
            P_RUTA_IMAGEN,
            P_ALTO_IMAGEN,
            P_ANCHO_IMAGEN
    );
END;

--INVOCACION DE PROCEDIMIENTO ALMACENADO PARA GUARDAR LA CONSULTA--
DECLARE
    V_CODIGO_IMAGEN INTEGER;
BEGIN
    P_AGREGAR_IMAGEN (1,'img/cuadrada.jpg',200,200,V_CODIGO_IMAGEN);
    DBMS_OUTPUT.PUT_LINE('CODIGO_IMAGEN: '||V_CODIGO_IMAGEN);
END;







--CREAR SECUENCIA DE ADM ELIMINACIONES--
CREATE SEQUENCE ADM_ELIMINACION_SEQ
INCREMENT BY 1
START WITH 1;


--PROCEDIMIENTO PARA INGRESAR ADM ELIMINACIONES--
CREATE OR REPLACE PROCEDURE P_AGREGAR_ADM_ELIMINACION (
            P_CODIGO_USUARIO_VENDEDOR IN INTEGER,
            P_CODIGO_PUBLICACION_PRODUCTO IN INTEGER,
            P_CODIGO_MOTIVO_ELIMINACION IN INTEGER,
            P_COMENTARIOS IN VARCHAR2,
            P_FECHA_EMITIO IN DATE,
            P_CODIGO_ELIMINACION OUT INTEGER
)AS
BEGIN
    P_CODIGO_ELIMINACION:=ADM_ELIMINACION_SEQ.NEXTVAL;
    INSERT INTO TBL_ADM_ELIMINACIONES (
            CODIGO_ELIMINACION,
            CODIGO_USUARIO_VENDEDOR,
            CODIGO_PUBLICACION_PRODUCTO,
            CODIGO_MOTIVO_ELIMINACION,
            COMENTARIOS,
            FECHA_EMITIO
    ) VALUES (
            P_CODIGO_ELIMINACION,
            P_CODIGO_USUARIO_VENDEDOR,
            P_CODIGO_PUBLICACION_PRODUCTO,
            P_CODIGO_MOTIVO_ELIMINACION,
            P_COMENTARIOS,
            P_FECHA_EMITIO
    );
END;

--INVOCACION DE PROCEDIMIENTO ALMACENADO PARA GUARDAR LA CONSULTA--
DECLARE
    V_CODIGO_ELIMINACION INTEGER;
BEGIN
    P_AGREGAR_ADM_ELIMINACION (1,2,1,'Comentarios',SYSDATE,V_CODIGO_ELIMINACION);
    DBMS_OUTPUT.PUT_LINE('CODIGO_ELIMINACION: '||V_CODIGO_ELIMINACION);
END;







--CREAR SECUENCIA DE MENSAJES--
CREATE SEQUENCE MENSAJE_SEQ
INCREMENT BY 1
START WITH 1;


--VER VALOR ACTUAL DE LA SECUENCIA--
SELECT MENSAJE_SEQ.CURRVAL AS VALOR_ACTUAL2
FROM DUAL;


--VER SIGUIENTE VALOR DE LA SECUENCIA--
SELECT MENSAJE_SEQ.NEXTVAL AS VALOR_ACTUAL2
FROM DUAL;


--PROCEDIMIENTO PARA INGRESAR VALORES A LA TABLA TBL_MENSAJES--
CREATE OR REPLACE PROCEDURE P_AGREGAR_MENSAJES (
            P_CODIGO_USUARIO_COMPRADOR IN INTEGER,
            P_CODIGO_USUARIO_VENDEDOR IN INTEGER,
            P_MENSAJE IN VARCHAR2,
            P_FECHA_ENVIO IN DATE,
            P_CODIGO_PUBLICACION IN INTEGER,
            P_NOMBRE_PUBLICACION IN VARCHAR2,
            P_CODIGO_MENSAJE OUT INTEGER
)AS
BEGIN
    P_CODIGO_MENSAJE:=MENSAJE_SEQ.NEXTVAL;
    INSERT INTO TBL_MENSAJES (
            CODIGO_MENSAJE,
            CODIGO_USUARIO_COMPRADOR,
            CODIGO_USUARIO_VENDEDOR,
            MENSAJE,
            FECHA_ENVIO,
            CODIGO_PUBLICACION,
            NOMBRE_PUBLICACION
    ) VALUES (
            P_CODIGO_MENSAJE,
            P_CODIGO_USUARIO_COMPRADOR,
            P_CODIGO_USUARIO_VENDEDOR,
            P_MENSAJE,
            P_FECHA_ENVIO,
            P_CODIGO_PUBLICACION,
            P_NOMBRE_PUBLICACION
    );
END;

--INVOCACION DE PROCEDIMIENTO ALMACENADO PARA GUARDAR LA CONSULTA--
DECLARE
    V_CODIGO_MENSAJE INTEGER;
BEGIN
    P_AGREGAR_MENSAJES (9,1,'Disponible aun?',SYSDATE,21,'Ps4 edicion Spider-man',V_CODIGO_MENSAJE);
    DBMS_OUTPUT.PUT_LINE('CODIGO_MENSAJE: '||V_CODIGO_MENSAJE);
END;




/*PROCEDIMIENTOS DE VALORACION*/

CREATE OR REPLACE FUNCTION obtener_valoracion(
    p_codigo_usuario_vendedor IN TBL_RANKING.CODIGO_USUARIO_VENDEDOR%TYPE
)
RETURN NUMBER 
IS
    vn_num_estrellas INTEGER := 0;--se usara para sumar todas las valoraciones recibidad
    vn_num_valoraciones INTEGER := 0;--se usara para obtener el numero de personas que han valorado
BEGIN
  SELECT NVL(SUM(NUMERO_ESTRELLAS), 0), COUNT(CODIGO_USUARIO_COMPRADOR) INTO 
    vn_num_estrellas, vn_num_valoraciones 
  FROM TBL_RANKING
  WHERE CODIGO_USUARIO_VENDEDOR = p_codigo_usuario_vendedor;
  
  --Verificando que no ocurra una divicion por cero
  IF vn_num_valoraciones = 0 THEN
    --Indica que nadie a calificado al vendedor con una estrella
    RETURN 0;
  ELSE
    --El promedio es la valoracion final del vendedor
    RETURN ROUND(vn_num_estrellas/ vn_num_valoraciones, 1);
  END IF;
END obtener_valoracion;
/

--Procedimiento almacenado para getionar la insercion y actualizacion de valoraciones
CREATE OR REPLACE PROCEDURE SP_CalificarVendedor(
    p_codigoVendedor IN TBL_VENDEDORES.CODIGO_USUARIO_VENDEDOR%TYPE,
    p_codigoComprador IN TBL_COMPRADORES.CODIGO_USUARIO_COMPRADOR%TYPE,
    pn_estrellas IN INTEGER
)
IS
    vn_conteo INTEGER := 0;
BEGIN
    IF p_codigoVendedor IS NULL AND p_codigoComprador IS NULL AND pn_estrellas IS NULL THEN
        return;
    END IF;

    IF pn_estrellas = 0 THEN
        RETURN;
    END IF;

    --Verificando que el comprador ya ha puntuado al vendedor anteriormente
    SELECT COUNT(*) INTO vn_conteo FROM TBL_RANKING
    WHERE TBL_RANKING.CODIGO_USUARIO_VENDEDOR = p_codigoVendedor 
    AND TBL_RANKING.CODIGO_USUARIO_COMPRADOR = p_codigoComprador;

    IF vn_conteo > 0 THEN
        UPDATE TBL_RANKING SET NUMERO_ESTRELLAS = pn_estrellas
        WHERE CODIGO_USUARIO_VENDEDOR = p_codigoVendedor
        AND CODIGO_USUARIO_COMPRADOR = p_codigoComprador;

        UPDATE TBL_RANKING SET FECHA_RANKING = SYSDATE
        WHERE CODIGO_USUARIO_VENDEDOR = p_codigoVendedor
        AND CODIGO_USUARIO_COMPRADOR = p_codigoComprador;
    ELSE
        INSERT INTO TBL_RANKING(CODIGO_USUARIO_COMPRADOR, CODIGO_USUARIO_VENDEDOR, 
            NUMERO_ESTRELLAS, FECHA_RANKING)
        VALUES(p_codigoComprador, p_codigoVendedor, pn_estrellas, SYSDATE);
    END IF;
END;
/






--CREAR SECUENCIA DE SERVICIOS--
CREATE SEQUENCE SERVICIOS_SEQ
INCREMENT BY 1
START WITH 5;

--PROCEDIMIENTO PARA INGRESAR VALORES A LA TABLA TBL_SERVICIOS--
CREATE OR REPLACE PROCEDURE P_AGREGAR_SERVICIOS (
            P_NOMBRE_SERVICIO IN VARCHAR2,
            P_CODIGO_SERVICIO OUT INTEGER
)AS
BEGIN
    P_CODIGO_SERVICIO:=SERVICIOS_SEQ.NEXTVAL;
    INSERT INTO TBL_SERVICIOS (
            CODIGO_SERVICIO,
            NOMBRE_SERVICIO
    ) VALUES (
            P_CODIGO_SERVICIO,
            P_NOMBRE_SERVICIO
    );
END;

--INVOCACION DE PROCEDIMIENTO ALMACENADO PARA GUARDAR LA CONSULTA--
DECLARE
    V_CODIGO_SERVICIO INTEGER;
BEGIN
    P_AGREGAR_SERVICIOS ('Servicios de telefonia',V_CODIGO_SERVICIO);
    DBMS_OUTPUT.PUT_LINE('CODIGO_SERVICIO: '||V_CODIGO_SERVICIO);
END;






-----Ejecutar privilegio desde SYSTEM----
GRANT CREATE JOB TO DB_GOOD_SHOPPING;
-----------------------------------------

--PROCEDIMIENTO PARA ELIMINAR PUBLICACIONES POR N DIAS CONFIGURADOS POR ADMIN--
CREATE OR REPLACE PROCEDURE P_UDP_ELIMINACION_PRODUCTOS
IS
    DIAS_IND INTEGER := 0;
    DIAS_EMP INTEGER := 0;
    REGISTRO_IND SYS_REFCURSOR;
    REGISTRO_EMP SYS_REFCURSOR;
    COD_PROD_ TBL_PUBLICACION_PRODUCTOS.CODIGO_PUBLICACION_PRODUCTO%TYPE;
    FECHA_PUB_ TBL_PUBLICACION_PRODUCTOS.FECHA_PUBLICACION%TYPE;
BEGIN
    SELECT DIAS_VIGENTES INTO DIAS_IND FROM TBL_G_PUBLICACIONES
    WHERE CODIGO_TIPO_VENDEDOR = 1;
    SELECT DIAS_VIGENTES INTO DIAS_EMP FROM TBL_G_PUBLICACIONES
    WHERE CODIGO_TIPO_VENDEDOR = 2;
    --Actualiza las publicaciones de vendedores individuales 
    OPEN REGISTRO_IND FOR
        SELECT A.CODIGO_PUBLICACION_PRODUCTO,A.FECHA_PUBLICACION 
        FROM TBL_PUBLICACION_PRODUCTOS A
        INNER JOIN TBL_VEND_X_TBL_PUBLI B
        ON A.CODIGO_PUBLICACION_PRODUCTO = B.CODIGO_PUBLICACION_PRODUCTO
        INNER JOIN TBL_VENDEDORES C
        ON B.CODIGO_USUARIO_VENDEDOR = C.CODIGO_USUARIO_VENDEDOR
        WHERE C.CODIGO_TIPO_VENDEDOR = 1
        AND A.CODIGO_ESTADO_PUBLICACION <> 3;
    LOOP
        FETCH REGISTRO_IND INTO COD_PROD_, FECHA_PUB_;
        EXIT WHEN REGISTRO_IND%NOTFOUND;
        UPDATE TBL_PUBLICACION_PRODUCTOS 
        SET CODIGO_ESTADO_PUBLICACION = 3 
        WHERE CODIGO_PUBLICACION_PRODUCTO = COD_PROD_
        AND to_date(SYSDATE, 'dd/mm/yyyy') - to_date(FECHA_PUB_, 'dd/mm/yyyy') > DIAS_IND;
    END LOOP;
    CLOSE REGISTRO_IND;
    --Actualiza las publicaciones de vendedores empresariales 
    OPEN REGISTRO_EMP FOR
        SELECT A.CODIGO_PUBLICACION_PRODUCTO,A.FECHA_PUBLICACION 
        FROM TBL_PUBLICACION_PRODUCTOS A
        INNER JOIN TBL_VEND_X_TBL_PUBLI B
        ON A.CODIGO_PUBLICACION_PRODUCTO = B.CODIGO_PUBLICACION_PRODUCTO
        INNER JOIN TBL_VENDEDORES C
        ON B.CODIGO_USUARIO_VENDEDOR = C.CODIGO_USUARIO_VENDEDOR
        WHERE C.CODIGO_TIPO_VENDEDOR = 2
        AND A.CODIGO_ESTADO_PUBLICACION <> 3;
    LOOP
        FETCH REGISTRO_EMP INTO COD_PROD_, FECHA_PUB_;
        EXIT WHEN REGISTRO_EMP%NOTFOUND;
        UPDATE TBL_PUBLICACION_PRODUCTOS 
        SET CODIGO_ESTADO_PUBLICACION = 3 
        WHERE CODIGO_PUBLICACION_PRODUCTO = COD_PROD_
        AND to_date(SYSDATE, 'dd/mm/yyyy') - to_date(FECHA_PUB_, 'dd/mm/yyyy') > DIAS_EMP;
    END LOOP;
    CLOSE REGISTRO_EMP;
END;

--CREACION DE TRABAJO PARA EJECUTAR EL PROCEDIMIENTO AUTOMATICAMENTE--
BEGIN
    DBMS_SCHEDULER.CREATE_JOB (
    job_name => 'ELIMINA_PUBLICACIONES_X_DIAS',
    job_type => 'STORED_PROCEDURE',
    job_action => 'P_UDP_ELIMINACION_PRODUCTOS',
    number_of_arguments => 0,
    start_date => TO_TIMESTAMP('18/04/2020 20:00:00','DD/MM/YYYY HH24:MI:SS'),
    repeat_interval => 'FREQ=DAILY;BYHOUR=20;BYMINUTE=0;BYSECOND=0',
    enabled => TRUE );
END;

--PONE EN MARCHA EL TRABAJO DE ARRIBA PARA EJECUTARSE--
BEGIN
    DBMS_SCHEDULER.enable('ELIMINA_PUBLICACIONES_X_DIAS');
END;

--EJECUTA TRABAJO AL INSTANTE--
--***NO ES NECESARIO EJECUTAR***--
BEGIN
    DBMS_SCHEDULER.RUN_JOB(
    JOB_NAME => 'ELIMINA_PUBLICACIONES_X_DIAS'
    );
END;




--CREAR SECUENCIA DE DENUNCIAS A PUBLICACIONES--
CREATE SEQUENCE REPORTES_SEQ
INCREMENT BY 1
START WITH 1;

--PROCEDIMIENTO PARA INGRESAR VALORES A LA TABLA TBL_SERVICIOS--
CREATE OR REPLACE PROCEDURE P_AGREGAR_REPORTE_DENUNCIAS (
            P_CODIGO_USUARIO_COMPRADOR IN INTEGER,
            P_CODIGO_TIPO_REPORTE IN INTEGER,
            P_CODIGO_PUBLICACION_PRODUCTO IN INTEGER,
            P_CODIGO_USUARIO_VENDEDOR IN INTEGER,
            P_CODIGO_MOTIVO_REPORTE IN INTEGER,
            P_FECHA_EMITIO IN DATE,
            P_COMENTARIO_REPORTE IN VARCHAR2,
            P_CODIGO_REPORTE OUT INTEGER
)AS
BEGIN
    P_CODIGO_REPORTE:=REPORTES_SEQ.NEXTVAL;
    INSERT INTO TBL_REPORTES (
            CODIGO_REPORTE,
            CODIGO_USUARIO_COMPRADOR,
            CODIGO_TIPO_REPORTE,
            CODIGO_PUBLICACION_PRODUCTO,
            CODIGO_USUARIO_VENDEDOR,
            CODIGO_MOTIVO_REPORTE,
            FECHA_EMITIO,
            COMENTARIO_REPORTE
    ) VALUES (
            P_CODIGO_REPORTE,
            P_CODIGO_USUARIO_COMPRADOR,
            P_CODIGO_TIPO_REPORTE,
            P_CODIGO_PUBLICACION_PRODUCTO,
            P_CODIGO_USUARIO_VENDEDOR,
            P_CODIGO_MOTIVO_REPORTE,
            P_FECHA_EMITIO,
            P_COMENTARIO_REPORTE
    );
END;

--INVOCACION DE PROCEDIMIENTO ALMACENADO PARA GUARDAR LA CONSULTA--
DECLARE
    V_CODIGO_REPORTE INTEGER;
BEGIN
    P_AGREGAR_REPORTE_DENUNCIAS (8, 2, 21, 1, 6, SYSDATE, 'El vendedor no contesta', V_CODIGO_REPORTE);
    DBMS_OUTPUT.PUT_LINE('CODIGO_REPORTE: '||V_CODIGO_REPORTE);
END;


--CREAR SECUENCIA DE SUBCATEGORIAS--
CREATE SEQUENCE SUBCATEGORIAS_SEQ
INCREMENT BY 1
START WITH 14;

--PROCEDIMIENTO PARA INGRESAR SUBCATEGORIAS--
CREATE OR REPLACE PROCEDURE P_AGREGAR_SUBCATEGORIAS (
            P_NOMBRE_SUB_CATEGORIA IN VARCHAR2,
            P_CODIGO_CATEGORIA IN INTEGER,
            P_CODIGO_SUB_CATEGORIA OUT INTEGER
)AS
BEGIN
    P_CODIGO_SUB_CATEGORIA:=SUBCATEGORIAS_SEQ.NEXTVAL;
    INSERT INTO TBL_SUB_CATEGORIAS (
            CODIGO_SUB_CATEGORIA,
            NOMBRE_SUB_CATEGORIA
    ) VALUES (
            P_CODIGO_SUB_CATEGORIA,
            P_NOMBRE_SUB_CATEGORIA
    );
    INSERT INTO TBL_CATEGO_X_TBL_SUBCATEGO (
            CODIGO_CATEGORIA,
            CODIGO_SUB_CATEGORIA
    ) VALUES (
            P_CODIGO_CATEGORIA,
            P_CODIGO_SUB_CATEGORIA
    );
END;

