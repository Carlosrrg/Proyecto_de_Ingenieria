--DDL DE BASE DE DATOS--



CREATE TABLE tbl_adm_eliminaciones (
    codigo_eliminacion            INTEGER NOT NULL,
    codigo_usuario_vendedor       INTEGER NOT NULL,
    codigo_publicacion_producto   INTEGER NOT NULL,
    codigo_motivo_eliminacion     INTEGER NOT NULL,
    comentarios                   VARCHAR2(500),
    fecha_emitio                  DATE NOT NULL
);

ALTER TABLE tbl_adm_eliminaciones ADD CONSTRAINT tbl_adm_eliminaciones_pk PRIMARY KEY ( codigo_eliminacion );

CREATE TABLE tbl_catego_x_tbl_subcatego (
    codigo_categoria       INTEGER NOT NULL,
    codigo_sub_categoria   INTEGER NOT NULL
);

CREATE TABLE tbl_categorias (
    codigo_categoria   INTEGER NOT NULL,
    nombre_categoria   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_categorias ADD CONSTRAINT tbl_categorias_pk PRIMARY KEY ( codigo_categoria );

CREATE TABLE tbl_codigos (
    codigo_codigo   INTEGER NOT NULL,
    codigo          VARCHAR2(100) NOT NULL
);

ALTER TABLE tbl_codigos ADD CONSTRAINT tbl_codigos_pk PRIMARY KEY ( codigo_codigo );

CREATE TABLE tbl_compradores (
    codigo_usuario_comprador   INTEGER NOT NULL
);

ALTER TABLE tbl_compradores ADD CONSTRAINT tbl_usuario_comprador_pk PRIMARY KEY ( codigo_usuario_comprador );

CREATE TABLE tbl_estado_producto (
    codigo_estado_producto   INTEGER NOT NULL,
    nombre_estado_producto   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_estado_producto ADD CONSTRAINT tbl_estado_pk PRIMARY KEY ( codigo_estado_producto );

CREATE TABLE tbl_estado_publicacion (
    codigo_estado_publicacion   INTEGER NOT NULL,
    nombre_estado_publicacion   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_estado_publicacion ADD CONSTRAINT tbl_estado_publicacion_pk PRIMARY KEY ( codigo_estado_publicacion );

CREATE TABLE tbl_favoritos (
    codigo_usuario_comprador   INTEGER NOT NULL,
    codigo_usuario_vendedor    INTEGER NOT NULL,
    fecha_agrego               DATE NOT NULL
);

CREATE TABLE tbl_g_publicaciones (
    codigo_gestion         INTEGER NOT NULL,
    codigo_usuario         INTEGER NOT NULL,
    codigo_tipo_vendedor   INTEGER NOT NULL,
    dias_vigentes          INTEGER NOT NULL
);

ALTER TABLE tbl_g_publicaciones ADD CONSTRAINT tbl_g_publicaciones_pk PRIMARY KEY ( codigo_gestion );

CREATE TABLE tbl_genero (
    codigo_genero   INTEGER NOT NULL,
    nombre_genero   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_genero ADD CONSTRAINT tbl_genero_pk PRIMARY KEY ( codigo_genero );

CREATE TABLE tbl_imagenes (
    codigo_imagen        INTEGER NOT NULL,
    codigo_tipo_imagen   INTEGER NOT NULL,
    ruta_imagen          VARCHAR2(500) NOT NULL,
    alto_imagen          NUMBER NOT NULL,
    ancho_imagen         NUMBER NOT NULL
);

ALTER TABLE tbl_imagenes ADD CONSTRAINT tbl_imagenes_pk PRIMARY KEY ( codigo_imagen );

CREATE TABLE tbl_lugares (
    codigo_lugar   INTEGER NOT NULL,
    nombre_lugar   VARCHAR2(300) NOT NULL
);

ALTER TABLE tbl_lugares ADD CONSTRAINT tbl_lugares_pk PRIMARY KEY ( codigo_lugar );

CREATE TABLE tbl_mensajes (
    codigo_mensaje             INTEGER NOT NULL,
    codigo_usuario_comprador   INTEGER NOT NULL,
    codigo_usuario_vendedor    INTEGER NOT NULL,
    mensaje                    VARCHAR2(500) NOT NULL,
    fecha_envio                DATE NOT NULL
);

ALTER TABLE tbl_mensajes ADD CONSTRAINT tbl_mensajes_pk PRIMARY KEY ( codigo_mensaje );

CREATE TABLE tbl_moneda (
    codigo_tipo_moneda   INTEGER NOT NULL,
    nombre_tipo_moneda   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_moneda ADD CONSTRAINT tbl_moneda_pk PRIMARY KEY ( codigo_tipo_moneda );

CREATE TABLE tbl_motivo_eliminacion (
    codigo_motivo_eliminacion   INTEGER NOT NULL,
    nombre_motivo_eliminacion   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_motivo_eliminacion ADD CONSTRAINT tbl_motivo_eliminacion_pk PRIMARY KEY ( codigo_motivo_eliminacion );

CREATE TABLE tbl_motivo_reporte (
    codigo_motivo_reporte   INTEGER NOT NULL,
    nombre_motivo_reporte   VARCHAR2(500) NOT NULL
);

ALTER TABLE tbl_motivo_reporte ADD CONSTRAINT tbl_motivo_reporte_pk PRIMARY KEY ( codigo_motivo_reporte );

CREATE TABLE tbl_prod_x_tbl_img (
    codigo_producto   INTEGER NOT NULL,
    codigo_imagen     INTEGER NOT NULL
);

CREATE TABLE tbl_produ_x_tbl_catego (
    codigo_producto        INTEGER NOT NULL,
    codigo_sub_categoria   INTEGER NOT NULL
);

CREATE TABLE tbl_publicacion_productos (
    codigo_publicacion_producto   INTEGER NOT NULL,
    codigo_tipo_publicacion       INTEGER NOT NULL,
    codigo_tipo_moneda            INTEGER NOT NULL,
    codigo_estado_producto        INTEGER,
    codigo_categoria              INTEGER NOT NULL,
    codigo_estado_publicacion     INTEGER NOT NULL,
    nombre_producto               VARCHAR2(200) NOT NULL,
    precio                        NUMBER NOT NULL,
    descipcion                    VARCHAR2(500) NOT NULL,
    fecha_publicacion             DATE NOT NULL,
    eliminacion_logica            INTEGER NOT NULL
);

ALTER TABLE tbl_publicacion_productos ADD CONSTRAINT tbl_productos_pk PRIMARY KEY ( codigo_publicacion_producto );

CREATE TABLE tbl_ranking (
    codigo_usuario_comprador   INTEGER NOT NULL,
    codigo_usuario_vendedor    INTEGER NOT NULL,
    numero_estrellas           NUMBER NOT NULL,
    fecha_ranking              DATE NOT NULL
);

CREATE TABLE tbl_reportes (
    codigo_reporte                INTEGER NOT NULL,
    codigo_usuario_comprador      INTEGER NOT NULL,
    codigo_tipo_reporte           INTEGER NOT NULL,
    codigo_publicacion_producto   INTEGER,
    codigo_usuario_vendedor       INTEGER,
    codigo_motivo_reporte         INTEGER NOT NULL,
    fecha_emitio                  DATE NOT NULL,
    comentario_reporte            VARCHAR2(500)
);

ALTER TABLE tbl_reportes ADD CONSTRAINT tbl_reportes_pk PRIMARY KEY ( codigo_reporte );

CREATE TABLE tbl_servicios (
    codigo_servicio   INTEGER NOT NULL,
    nombre_servicio   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_servicios ADD CONSTRAINT tbl_servicios_pk PRIMARY KEY ( codigo_servicio );

CREATE TABLE tbl_sub_categorias (
    codigo_sub_categoria   INTEGER NOT NULL,
    nombre_sub_categoria   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_sub_categorias ADD CONSTRAINT tbl_sub_categorias_pk PRIMARY KEY ( codigo_sub_categoria );

CREATE TABLE tbl_tienda_x_tbl_publicacion (
    codigo_tienda                 INTEGER NOT NULL,
    codigo_publicacion_producto   INTEGER NOT NULL
);

CREATE TABLE tbl_tiendas (
    codigo_tienda             INTEGER NOT NULL,
    nombre_tienda             VARCHAR2(200) NOT NULL,
    telefono_tienda           NUMBER,
    correo_tienda             VARCHAR2(200),
    direccion_fisica_tienda   VARCHAR2(500),
    descripcion_tienda        VARCHAR2(500)
);

ALTER TABLE tbl_tiendas ADD CONSTRAINT tbl_tienda_pk PRIMARY KEY ( codigo_tienda );

CREATE TABLE tbl_tipo_imagen (
    codigo_tipo_imagen   INTEGER NOT NULL,
    nombre_tipo_imagen   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_tipo_imagen ADD CONSTRAINT tbl_tipo_imagen_pk PRIMARY KEY ( codigo_tipo_imagen );

CREATE TABLE tbl_tipo_publicacion (
    codigo_tipo_publicacion   INTEGER NOT NULL,
    nombre_tipo_publicacion   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_tipo_publicacion ADD CONSTRAINT tbl_tipo_producto_pk PRIMARY KEY ( codigo_tipo_publicacion );

CREATE TABLE tbl_tipo_reporte (
    codigo_tipo_reporte   INTEGER NOT NULL,
    nombre_tipo_reporte   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_tipo_reporte ADD CONSTRAINT tbl_tipo_reporte_pk PRIMARY KEY ( codigo_tipo_reporte );

CREATE TABLE tbl_tipo_usuario (
    codigo_tipo_usuario   INTEGER NOT NULL,
    nombre_tipo_usuario   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_tipo_usuario ADD CONSTRAINT tbl_tipo_usuario_pk PRIMARY KEY ( codigo_tipo_usuario );

CREATE TABLE tbl_tipo_vendedores (
    codigo_tipo_vendedor   INTEGER NOT NULL,
    nombre_tipo_vendedor   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_tipo_vendedores ADD CONSTRAINT tbl_tipo_vendedores_pk PRIMARY KEY ( codigo_tipo_vendedor );

CREATE TABLE tbl_usuarios (
    codigo_usuario        INTEGER NOT NULL,
    codigo_tipo_usuario   INTEGER NOT NULL,
    codigo_lugar          INTEGER NOT NULL,
    codigo_genero         INTEGER,
    codigo_codigo         INTEGER NOT NULL,
    nombre                VARCHAR2(200) NOT NULL,
    apellido              VARCHAR2(200) NOT NULL,
    correo_electronico    VARCHAR2(200) NOT NULL,
    contrasena            VARCHAR2(300) NOT NULL,
    telefono              NUMBER NOT NULL,
    fecha_nacimiento      DATE NOT NULL,
    fecha_registro        DATE NOT NULL,
    ciudad                VARCHAR2(200)
);

ALTER TABLE tbl_usuarios ADD CONSTRAINT tbl_usuarios_pk PRIMARY KEY ( codigo_usuario );

CREATE TABLE tbl_vend_x_tbl_img (
    codigo_imagen             INTEGER NOT NULL,
    codigo_usuario_vendedor   INTEGER NOT NULL
);

CREATE TABLE tbl_vend_x_tbl_publi (
    codigo_usuario_vendedor       INTEGER NOT NULL,
    codigo_publicacion_producto   INTEGER NOT NULL
);

CREATE TABLE tbl_vend_x_tbl_serv (
    codigo_usuario_vendedor   INTEGER NOT NULL,
    codigo_servicio           INTEGER NOT NULL
);

CREATE TABLE tbl_vendedores (
    codigo_usuario_vendedor   INTEGER NOT NULL,
    codigo_tipo_vendedor      INTEGER NOT NULL,
    codigo_tienda             INTEGER
);

ALTER TABLE tbl_vendedores ADD CONSTRAINT tbl_vendedor_pk PRIMARY KEY ( codigo_usuario_vendedor );

ALTER TABLE tbl_imagenes
    ADD CONSTRAINT img_tipo_img_fk FOREIGN KEY ( codigo_tipo_imagen )
        REFERENCES tbl_tipo_imagen ( codigo_tipo_imagen );

ALTER TABLE tbl_publicacion_productos
    ADD CONSTRAINT prod_tipo_prod_fk FOREIGN KEY ( codigo_tipo_publicacion )
        REFERENCES tbl_tipo_publicacion ( codigo_tipo_publicacion );

ALTER TABLE tbl_favoritos
    ADD CONSTRAINT tbl_favor_tbl_compradores_fk FOREIGN KEY ( codigo_usuario_comprador )
        REFERENCES tbl_compradores ( codigo_usuario_comprador );

ALTER TABLE tbl_favoritos
    ADD CONSTRAINT tbl_favor_tbl_vendedores_fk FOREIGN KEY ( codigo_usuario_vendedor )
        REFERENCES tbl_vendedores ( codigo_usuario_vendedor );

ALTER TABLE tbl_g_publicaciones
    ADD CONSTRAINT tbl_g_p_tbl_t_v_fk FOREIGN KEY ( codigo_tipo_vendedor )
        REFERENCES tbl_tipo_vendedores ( codigo_tipo_vendedor );

ALTER TABLE tbl_g_publicaciones
    ADD CONSTRAINT tbl_g_pub_tbl_usu_fk FOREIGN KEY ( codigo_usuario )
        REFERENCES tbl_usuarios ( codigo_usuario );

ALTER TABLE tbl_vend_x_tbl_img
    ADD CONSTRAINT tbl_img_tbl_ve_fk FOREIGN KEY ( codigo_usuario_vendedor )
        REFERENCES tbl_vendedores ( codigo_usuario_vendedor );

ALTER TABLE tbl_mensajes
    ADD CONSTRAINT tbl_me_tbl_comp_fk FOREIGN KEY ( codigo_usuario_comprador )
        REFERENCES tbl_compradores ( codigo_usuario_comprador );

ALTER TABLE tbl_mensajes
    ADD CONSTRAINT tbl_me_tbl_ve_fk FOREIGN KEY ( codigo_usuario_vendedor )
        REFERENCES tbl_vendedores ( codigo_usuario_vendedor );

ALTER TABLE tbl_adm_eliminaciones
    ADD CONSTRAINT tbl_mot_el_fk FOREIGN KEY ( codigo_motivo_eliminacion )
        REFERENCES tbl_motivo_eliminacion ( codigo_motivo_eliminacion );

ALTER TABLE tbl_produ_x_tbl_catego
    ADD CONSTRAINT tbl_p_x_tbl_cat_fk FOREIGN KEY ( codigo_producto )
        REFERENCES tbl_publicacion_productos ( codigo_publicacion_producto );

ALTER TABLE tbl_publicacion_productos
    ADD CONSTRAINT tbl_pro_tbl_cat_fk FOREIGN KEY ( codigo_categoria )
        REFERENCES tbl_categorias ( codigo_categoria );

ALTER TABLE tbl_prod_x_tbl_img
    ADD CONSTRAINT tbl_pro_tbl_pro_fk FOREIGN KEY ( codigo_producto )
        REFERENCES tbl_publicacion_productos ( codigo_publicacion_producto );

ALTER TABLE tbl_produ_x_tbl_catego
    ADD CONSTRAINT tbl_pro_tbl_sub_cat_fk FOREIGN KEY ( codigo_sub_categoria )
        REFERENCES tbl_sub_categorias ( codigo_sub_categoria );

ALTER TABLE tbl_publicacion_productos
    ADD CONSTRAINT tbl_prod_tbl_est_fk FOREIGN KEY ( codigo_estado_producto )
        REFERENCES tbl_estado_producto ( codigo_estado_producto );

ALTER TABLE tbl_prod_x_tbl_img
    ADD CONSTRAINT tbl_prod_tbl_im_fk FOREIGN KEY ( codigo_imagen )
        REFERENCES tbl_imagenes ( codigo_imagen );

ALTER TABLE tbl_publicacion_productos
    ADD CONSTRAINT tbl_prod_tbl_mon_fk FOREIGN KEY ( codigo_tipo_moneda )
        REFERENCES tbl_moneda ( codigo_tipo_moneda );

ALTER TABLE tbl_publicacion_productos
    ADD CONSTRAINT tbl_pu_p_tbl_e_pub_fk FOREIGN KEY ( codigo_estado_publicacion )
        REFERENCES tbl_estado_publicacion ( codigo_estado_publicacion );

ALTER TABLE tbl_adm_eliminaciones
    ADD CONSTRAINT tbl_pub_pr_fk FOREIGN KEY ( codigo_publicacion_producto )
        REFERENCES tbl_publicacion_productos ( codigo_publicacion_producto );

ALTER TABLE tbl_ranking
    ADD CONSTRAINT tbl_ranking_tbl_comprado_fk FOREIGN KEY ( codigo_usuario_comprador )
        REFERENCES tbl_compradores ( codigo_usuario_comprador );

ALTER TABLE tbl_ranking
    ADD CONSTRAINT tbl_ranking_tbl_vendedo_fk FOREIGN KEY ( codigo_usuario_vendedor )
        REFERENCES tbl_vendedores ( codigo_usuario_vendedor );

ALTER TABLE tbl_reportes
    ADD CONSTRAINT tbl_re_tbl_co_fk FOREIGN KEY ( codigo_usuario_comprador )
        REFERENCES tbl_compradores ( codigo_usuario_comprador );

ALTER TABLE tbl_reportes
    ADD CONSTRAINT tbl_re_tbl_t_re_fk FOREIGN KEY ( codigo_tipo_reporte )
        REFERENCES tbl_tipo_reporte ( codigo_tipo_reporte );

ALTER TABLE tbl_reportes
    ADD CONSTRAINT tbl_repor_tbl_moti_fk FOREIGN KEY ( codigo_motivo_reporte )
        REFERENCES tbl_motivo_reporte ( codigo_motivo_reporte );

ALTER TABLE tbl_reportes
    ADD CONSTRAINT tbl_repor_tbl_publicac_fk FOREIGN KEY ( codigo_publicacion_producto )
        REFERENCES tbl_publicacion_productos ( codigo_publicacion_producto );

ALTER TABLE tbl_reportes
    ADD CONSTRAINT tbl_reportes_tbl_vendedo_fk FOREIGN KEY ( codigo_usuario_vendedor )
        REFERENCES tbl_vendedores ( codigo_usuario_vendedor );

ALTER TABLE tbl_vend_x_tbl_serv
    ADD CONSTRAINT tbl_ser_tbl_ser_fk FOREIGN KEY ( codigo_servicio )
        REFERENCES tbl_servicios ( codigo_servicio );

ALTER TABLE tbl_catego_x_tbl_subcatego
    ADD CONSTRAINT tbl_sub_tbl_cat_fk FOREIGN KEY ( codigo_categoria )
        REFERENCES tbl_categorias ( codigo_categoria );

ALTER TABLE tbl_catego_x_tbl_subcatego
    ADD CONSTRAINT tbl_subc_tbl_sub_fk FOREIGN KEY ( codigo_sub_categoria )
        REFERENCES tbl_sub_categorias ( codigo_sub_categoria );

ALTER TABLE tbl_tienda_x_tbl_publicacion
    ADD CONSTRAINT tbl_ti_x_tbl_p_fkv2 FOREIGN KEY ( codigo_tienda )
        REFERENCES tbl_tiendas ( codigo_tienda );

ALTER TABLE tbl_tienda_x_tbl_publicacion
    ADD CONSTRAINT tbl_ti_x_tbl_pr_fk FOREIGN KEY ( codigo_publicacion_producto )
        REFERENCES tbl_publicacion_productos ( codigo_publicacion_producto );

ALTER TABLE tbl_usuarios
    ADD CONSTRAINT tbl_us_t_usu_fk FOREIGN KEY ( codigo_tipo_usuario )
        REFERENCES tbl_tipo_usuario ( codigo_tipo_usuario );

ALTER TABLE tbl_usuarios
    ADD CONSTRAINT tbl_us_tbl_ge_fk FOREIGN KEY ( codigo_genero )
        REFERENCES tbl_genero ( codigo_genero );

ALTER TABLE tbl_usuarios
    ADD CONSTRAINT tbl_us_tbl_l_fk FOREIGN KEY ( codigo_lugar )
        REFERENCES tbl_lugares ( codigo_lugar );

ALTER TABLE tbl_compradores
    ADD CONSTRAINT tbl_usuario_co_fk FOREIGN KEY ( codigo_usuario_comprador )
        REFERENCES tbl_usuarios ( codigo_usuario );

ALTER TABLE tbl_usuarios
    ADD CONSTRAINT tbl_usuarios_tbl_codigos_fk FOREIGN KEY ( codigo_codigo )
        REFERENCES tbl_codigos ( codigo_codigo );

ALTER TABLE tbl_vend_x_tbl_publi
    ADD CONSTRAINT tbl_v_p_tbl_p_pr_fk FOREIGN KEY ( codigo_publicacion_producto )
        REFERENCES tbl_publicacion_productos ( codigo_publicacion_producto );

ALTER TABLE tbl_adm_eliminaciones
    ADD CONSTRAINT tbl_ve_fk FOREIGN KEY ( codigo_usuario_vendedor )
        REFERENCES tbl_vendedores ( codigo_usuario_vendedor );

ALTER TABLE tbl_vendedores
    ADD CONSTRAINT tbl_ve_tbl_us_fk FOREIGN KEY ( codigo_usuario_vendedor )
        REFERENCES tbl_usuarios ( codigo_usuario );

ALTER TABLE tbl_vend_x_tbl_img
    ADD CONSTRAINT tbl_ve_x_tbl_img_fk FOREIGN KEY ( codigo_imagen )
        REFERENCES tbl_imagenes ( codigo_imagen );

ALTER TABLE tbl_vend_x_tbl_publi
    ADD CONSTRAINT tbl_ve_x_tbl_pu_tbl_ve_fk FOREIGN KEY ( codigo_usuario_vendedor )
        REFERENCES tbl_vendedores ( codigo_usuario_vendedor );

ALTER TABLE tbl_vendedores
    ADD CONSTRAINT tbl_ven_tbl_ti_fk FOREIGN KEY ( codigo_tienda )
        REFERENCES tbl_tiendas ( codigo_tienda );

ALTER TABLE tbl_vend_x_tbl_serv
    ADD CONSTRAINT tbl_ven_x_tbl_ve_fk FOREIGN KEY ( codigo_usuario_vendedor )
        REFERENCES tbl_vendedores ( codigo_usuario_vendedor );

ALTER TABLE tbl_vendedores
    ADD CONSTRAINT tbl_vend_tbl_t_v_fk FOREIGN KEY ( codigo_tipo_vendedor )
        REFERENCES tbl_tipo_vendedores ( codigo_tipo_vendedor );

