--DDL DE BASE DE DATOS--

CREATE TABLE tbl_catego_x_tbl_subcatego (
    codigo_categoria       INTEGER NOT NULL,
    codigo_sub_categoria   INTEGER NOT NULL
);

CREATE TABLE tbl_categorias (
    codigo_categoria   INTEGER NOT NULL,
    nombre_categoria   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_categorias ADD CONSTRAINT tbl_categorias_pk PRIMARY KEY ( codigo_categoria );

CREATE TABLE tbl_estado (
    codigo_estado   INTEGER NOT NULL,
    nombre_estado   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_estado ADD CONSTRAINT tbl_estado_pk PRIMARY KEY ( codigo_estado );

CREATE TABLE tbl_genero (
    codigo_genero   INTEGER NOT NULL,
    nombre_genero   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_genero ADD CONSTRAINT tbl_genero_pk PRIMARY KEY ( codigo_genero );

CREATE TABLE tbl_lugares (
    codigo_lugar   INTEGER NOT NULL,
    nombre_lugar   VARCHAR2(300) NOT NULL
);

ALTER TABLE tbl_lugares ADD CONSTRAINT tbl_lugares_pk PRIMARY KEY ( codigo_lugar );

CREATE TABLE tbl_moneda (
    codigo_tipo_moneda   INTEGER NOT NULL,
    nombre_tipo_moneda   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_moneda ADD CONSTRAINT tbl_moneda_pk PRIMARY KEY ( codigo_tipo_moneda );

CREATE TABLE tbl_produ_x_tbl_catego (
    codigo_producto        INTEGER NOT NULL,
    codigo_sub_categoria   INTEGER NOT NULL
);

CREATE TABLE tbl_productos (
    codigo_producto        INTEGER NOT NULL,
    codigo_tipo_producto   INTEGER NOT NULL,
    codigo_tipo_moneda     INTEGER NOT NULL,
    codigo_estado          INTEGER,
    codigo_categoria       INTEGER NOT NULL,
    nombre_producto        VARCHAR2(200) NOT NULL,
    precio                 NUMBER NOT NULL,
    descipcion             VARCHAR2(500) NOT NULL
);

ALTER TABLE tbl_productos ADD CONSTRAINT tbl_productos_pk PRIMARY KEY ( codigo_producto );

CREATE TABLE tbl_servicios_ofrece (
    codigo_servicio_ofrece   INTEGER NOT NULL,
    nombre_servicio_ofrece   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_servicios_ofrece ADD CONSTRAINT tbl_servicios_ofrece_pk PRIMARY KEY ( codigo_servicio_ofrece );

CREATE TABLE tbl_sub_categorias (
    codigo_sub_categoria   INTEGER NOT NULL,
    nombre_sub_categoria   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_sub_categorias ADD CONSTRAINT tbl_sub_categorias_pk PRIMARY KEY ( codigo_sub_categoria );

CREATE TABLE tbl_tienda_x_tbl_producto (
    codigo_tienda     INTEGER NOT NULL,
    codigo_producto   INTEGER NOT NULL
);

CREATE TABLE tbl_tienda_x_tbl_servicio (
    codigo_tienda            INTEGER NOT NULL,
    codigo_servicio_ofrece   INTEGER NOT NULL
);

CREATE TABLE tbl_tiendas (
    codigo_tienda             INTEGER NOT NULL,
    nombre_tienda             VARCHAR2(200) NOT NULL,
    direccion_fisica_tienda   VARCHAR2(500),
    descripcion_tienda        VARCHAR2(500)
);

ALTER TABLE tbl_tiendas ADD CONSTRAINT tbl_tienda_pk PRIMARY KEY ( codigo_tienda );

CREATE TABLE tbl_tipo_producto (
    codigo_producto   INTEGER NOT NULL,
    nombre_producto   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_tipo_producto ADD CONSTRAINT tbl_tipo_producto_pk PRIMARY KEY ( codigo_producto );

CREATE TABLE tbl_tipo_usuario (
    codigo_tipo_usuario   INTEGER NOT NULL,
    nombre_tipo_usuario   VARCHAR2(200) NOT NULL
);

ALTER TABLE tbl_tipo_usuario ADD CONSTRAINT tbl_tipo_usuario_pk PRIMARY KEY ( codigo_tipo_usuario );

CREATE TABLE tbl_usuario_compradores (
    codigo_usuario_comprador   INTEGER NOT NULL,
    codigo_comprador           INTEGER NOT NULL
);

ALTER TABLE tbl_usuario_compradores ADD CONSTRAINT tbl_usuario_comprador_pk PRIMARY KEY ( codigo_usuario_comprador );

CREATE TABLE tbl_usuarios (
    codigo_usuario        INTEGER NOT NULL,
    codigo_tipo_usuario   INTEGER NOT NULL,
    codigo_lugar          INTEGER NOT NULL,
    codigo_genero         INTEGER,
    nombre                VARCHAR2(200) NOT NULL,
    apellido              VARCHAR2(200) NOT NULL,
    correo_electronico    VARCHAR2(200) NOT NULL,
    contrasena            VARCHAR2(300) NOT NULL,
    telefono              NUMBER NOT NULL,
    fecha_nacimiento      DATE NOT NULL
);

ALTER TABLE tbl_usuarios ADD CONSTRAINT tbl_usuarios_pk PRIMARY KEY ( codigo_usuario );

CREATE TABLE tbl_vendedores (
    codigo_usuario_vendedor   INTEGER NOT NULL,
    codigo_vendedor           INTEGER NOT NULL,
    codigo_tienda             INTEGER NOT NULL
);

ALTER TABLE tbl_vendedores ADD CONSTRAINT tbl_vendedor_pk PRIMARY KEY ( codigo_usuario_vendedor );

ALTER TABLE tbl_productos
    ADD CONSTRAINT tbl_prod_tbl_est_fk FOREIGN KEY ( codigo_estado )
        REFERENCES tbl_estado ( codigo_estado );

ALTER TABLE tbl_productos
    ADD CONSTRAINT tbl_prod_tbl_moneda_fk FOREIGN KEY ( codigo_tipo_moneda )
        REFERENCES tbl_moneda ( codigo_tipo_moneda );

ALTER TABLE tbl_productos
    ADD CONSTRAINT tbl_prod_tbl_tipo_prod_fk FOREIGN KEY ( codigo_tipo_producto )
        REFERENCES tbl_tipo_producto ( codigo_producto );

ALTER TABLE tbl_productos
    ADD CONSTRAINT tbl_produ_tbl_catego_fk FOREIGN KEY ( codigo_categoria )
        REFERENCES tbl_categorias ( codigo_categoria );

ALTER TABLE tbl_produ_x_tbl_catego
    ADD CONSTRAINT tbl_produ_x_tbl_catego_fk FOREIGN KEY ( codigo_producto )
        REFERENCES tbl_productos ( codigo_producto );

ALTER TABLE tbl_produ_x_tbl_catego
    ADD CONSTRAINT tbl_produ_x_tbl_sub_catego_fk FOREIGN KEY ( codigo_sub_categoria )
        REFERENCES tbl_sub_categorias ( codigo_sub_categoria );

ALTER TABLE tbl_catego_x_tbl_subcatego
    ADD CONSTRAINT tbl_subcatego_x_tbl_cat_fk FOREIGN KEY ( codigo_categoria )
        REFERENCES tbl_categorias ( codigo_categoria );

ALTER TABLE tbl_catego_x_tbl_subcatego
    ADD CONSTRAINT tbl_subcatego_x_tbl_sub_fk FOREIGN KEY ( codigo_sub_categoria )
        REFERENCES tbl_sub_categorias ( codigo_sub_categoria );

ALTER TABLE tbl_tienda_x_tbl_producto
    ADD CONSTRAINT tbl_tienda_x_tbl_produ_fk FOREIGN KEY ( codigo_producto )
        REFERENCES tbl_productos ( codigo_producto );

ALTER TABLE tbl_tienda_x_tbl_producto
    ADD CONSTRAINT tbl_tienda_x_tbl_produ_fkv2 FOREIGN KEY ( codigo_tienda )
        REFERENCES tbl_tiendas ( codigo_tienda );

ALTER TABLE tbl_tienda_x_tbl_servicio
    ADD CONSTRAINT tbl_tienda_x_tbl_serv_fk FOREIGN KEY ( codigo_servicio_ofrece )
        REFERENCES tbl_servicios_ofrece ( codigo_servicio_ofrece );

ALTER TABLE tbl_tienda_x_tbl_servicio
    ADD CONSTRAINT tbl_tienda_x_tbl_tien_fk FOREIGN KEY ( codigo_tienda )
        REFERENCES tbl_tiendas ( codigo_tienda );

ALTER TABLE tbl_usuario_compradores
    ADD CONSTRAINT tbl_usuario_co_fk FOREIGN KEY ( codigo_usuario_comprador )
        REFERENCES tbl_usuarios ( codigo_usuario );

ALTER TABLE tbl_usuarios
    ADD CONSTRAINT tbl_usuarios_tbl_genero_fk FOREIGN KEY ( codigo_genero )
        REFERENCES tbl_genero ( codigo_genero );

ALTER TABLE tbl_usuarios
    ADD CONSTRAINT tbl_usuarios_tbl_luga_fk FOREIGN KEY ( codigo_lugar )
        REFERENCES tbl_lugares ( codigo_lugar );

ALTER TABLE tbl_usuarios
    ADD CONSTRAINT tbl_usuarios_tipo_usu_fk FOREIGN KEY ( codigo_tipo_usuario )
        REFERENCES tbl_tipo_usuario ( codigo_tipo_usuario );

ALTER TABLE tbl_vendedores
    ADD CONSTRAINT tbl_vendedor_tbl_tienda_fk FOREIGN KEY ( codigo_tienda )
        REFERENCES tbl_tiendas ( codigo_tienda );

ALTER TABLE tbl_vendedores
    ADD CONSTRAINT tbl_vendedor_tbl_usuarios_fk FOREIGN KEY ( codigo_usuario_vendedor )
        REFERENCES tbl_usuarios ( codigo_usuario );
