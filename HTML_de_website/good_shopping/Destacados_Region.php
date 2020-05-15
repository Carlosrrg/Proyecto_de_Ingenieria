<html lang="es" class="layout-signup">
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">     
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">        
      <title>Destacados por Región - Good Shopping</title>
      <link rel="icon" href="img/logo2.png"><!--favicon de la pagina-->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/inicio_session.css">
  </head>
  <body class="page-signup page-signup reboot ">

    <?php
      include_once("class/conexion_copy.php");
      $conexion = new Conexion();
      $conexion->establecerConexion();
    ?>
                
    <div class="wrap">
      <div class="sign-up">
        <div class="l-signup-header">
          <div class="container">
            <div class="">
              <a class="" href="index.php">
              <center><img src="img/logo.png"></center>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="l-signup-body">
      <div class="container">
        <div class="l-box-content">
          <section class="signup-select"></section>
            <center><h2 style="margin-top: 5px">Destacados por Región</h2></center>

              <h4 style="margin-top:20px">REGIÓN OCCIDENTAL</h4>
              <p>Productos y servicios más destacados de Ocotepeque, Copán y Lempira.</p>
              <?php
                $resultado = $conexion->ejecutarInstruccion("
                  SELECT * FROM (
                  SELECT PP.CODIGO_PUBLICACION_PRODUCTO, PP.NOMBRE_PRODUCTO,
                  PP.CODIGO_TIPO_MONEDA, PP.PRECIO
                  FROM TBL_PUBLICACION_PRODUCTOS PP
                  INNER JOIN TBL_VEND_X_TBL_PUBLI VXP
                  ON PP.CODIGO_PUBLICACION_PRODUCTO=VXP.CODIGO_PUBLICACION_PRODUCTO
                  INNER JOIN TBL_USUARIOS U
                  ON VXP.CODIGO_USUARIO_VENDEDOR=U.CODIGO_USUARIO
                  INNER JOIN TBL_LUGARES L
                  ON U.CODIGO_LUGAR=L.CODIGO_LUGAR
                  WHERE PP.CODIGO_ESTADO_PUBLICACION=1
                  AND L.CODIGO_LUGAR IN (6,13,14)
                  ORDER BY obtener_valoracion(U.CODIGO_USUARIO) DESC)
                  WHERE ROWNUM <= 4");
                oci_execute($resultado);
                echo '<ul style="margin:-10px 0 10px 20px">';
                while ($fila = $conexion->obtenerFila($resultado)) {
                  echo '<li><a href="InfodeProductos.php?codigo-publicacion='.$fila["CODIGO_PUBLICACION_PRODUCTO"].'">'.$fila["NOMBRE_PRODUCTO"].' - ';
                  if ($fila["CODIGO_TIPO_MONEDA"] == 1) {
                    echo 'L.';
                  } else {
                    echo '$';
                  }
                  echo $fila["PRECIO"].'</a></li>';
                }
                echo '</ul>';
              ?>

              <h4 style="margin-top:20px">REGIÓN NOROCCIDENTAL</h4>
              <p>Productos y servicios más destacados de Cortés, Santa Bárbara y Yoro.</p>
              <?php
                $resultado = $conexion->ejecutarInstruccion("
                  SELECT * FROM (
                  SELECT PP.CODIGO_PUBLICACION_PRODUCTO, PP.NOMBRE_PRODUCTO,
                  PP.CODIGO_TIPO_MONEDA, PP.PRECIO
                  FROM TBL_PUBLICACION_PRODUCTOS PP
                  INNER JOIN TBL_VEND_X_TBL_PUBLI VXP
                  ON PP.CODIGO_PUBLICACION_PRODUCTO=VXP.CODIGO_PUBLICACION_PRODUCTO
                  INNER JOIN TBL_USUARIOS U
                  ON VXP.CODIGO_USUARIO_VENDEDOR=U.CODIGO_USUARIO
                  INNER JOIN TBL_LUGARES L
                  ON U.CODIGO_LUGAR=L.CODIGO_LUGAR
                  WHERE PP.CODIGO_ESTADO_PUBLICACION=1
                  AND L.CODIGO_LUGAR IN (7,16,18)
                  ORDER BY obtener_valoracion(U.CODIGO_USUARIO) DESC)
                  WHERE ROWNUM <= 4");
                oci_execute($resultado);
                echo '<ul style="margin:-10px 0 10px 20px">';
                while ($fila = $conexion->obtenerFila($resultado)) {
                  echo '<li><a href="InfodeProductos.php?codigo-publicacion='.$fila["CODIGO_PUBLICACION_PRODUCTO"].'">'.$fila["NOMBRE_PRODUCTO"].' - ';
                  if ($fila["CODIGO_TIPO_MONEDA"] == 1) {
                    echo 'L.';
                  } else {
                    echo '$';
                  }
                  echo $fila["PRECIO"].'</a></li>';
                }
                echo '</ul>';
              ?>

              <h4 style="margin-top:20px">REGIÓN NORORIENTAL</h4>
              <p>Productos y servicios más destacados de Atlántida, Colón, Gracias a Dios e Islas de la Bahía.</p>
              <?php
                $resultado = $conexion->ejecutarInstruccion("
                  SELECT * FROM (
                  SELECT PP.CODIGO_PUBLICACION_PRODUCTO, PP.NOMBRE_PRODUCTO,
                  PP.CODIGO_TIPO_MONEDA, PP.PRECIO
                  FROM TBL_PUBLICACION_PRODUCTOS PP
                  INNER JOIN TBL_VEND_X_TBL_PUBLI VXP
                  ON PP.CODIGO_PUBLICACION_PRODUCTO=VXP.CODIGO_PUBLICACION_PRODUCTO
                  INNER JOIN TBL_USUARIOS U
                  ON VXP.CODIGO_USUARIO_VENDEDOR=U.CODIGO_USUARIO
                  INNER JOIN TBL_LUGARES L
                  ON U.CODIGO_LUGAR=L.CODIGO_LUGAR
                  WHERE PP.CODIGO_ESTADO_PUBLICACION=1
                  AND L.CODIGO_LUGAR IN (2,4,9,11)
                  ORDER BY obtener_valoracion(U.CODIGO_USUARIO) DESC)
                  WHERE ROWNUM <= 4");
                oci_execute($resultado);
                echo '<ul style="margin:-10px 0 10px 20px">';
                while ($fila = $conexion->obtenerFila($resultado)) {
                  echo '<li><a href="InfodeProductos.php?codigo-publicacion='.$fila["CODIGO_PUBLICACION_PRODUCTO"].'">'.$fila["NOMBRE_PRODUCTO"].' - ';
                  if ($fila["CODIGO_TIPO_MONEDA"] == 1) {
                    echo 'L.';
                  } else {
                    echo '$';
                  }
                  echo $fila["PRECIO"].'</a></li>';
                }
                echo '</ul>';
              ?>

              <h4 style="margin-top:20px">REGIÓN CENTRO-OCCIDENTAL</h4>
              <p>Productos y servicios más destacados de Intibucá, Comayagua y La Paz.</p>
              <?php
                $resultado = $conexion->ejecutarInstruccion("
                  SELECT * FROM (
                  SELECT PP.CODIGO_PUBLICACION_PRODUCTO, PP.NOMBRE_PRODUCTO,
                  PP.CODIGO_TIPO_MONEDA, PP.PRECIO
                  FROM TBL_PUBLICACION_PRODUCTOS PP
                  INNER JOIN TBL_VEND_X_TBL_PUBLI VXP
                  ON PP.CODIGO_PUBLICACION_PRODUCTO=VXP.CODIGO_PUBLICACION_PRODUCTO
                  INNER JOIN TBL_USUARIOS U
                  ON VXP.CODIGO_USUARIO_VENDEDOR=U.CODIGO_USUARIO
                  INNER JOIN TBL_LUGARES L
                  ON U.CODIGO_LUGAR=L.CODIGO_LUGAR
                  WHERE PP.CODIGO_ESTADO_PUBLICACION=1
                  AND L.CODIGO_LUGAR IN (5,10,12)
                  ORDER BY obtener_valoracion(U.CODIGO_USUARIO) DESC)
                  WHERE ROWNUM <= 4");
                oci_execute($resultado);
                echo '<ul style="margin:-10px 0 10px 20px">';
                while ($fila = $conexion->obtenerFila($resultado)) {
                  echo '<li><a href="InfodeProductos.php?codigo-publicacion='.$fila["CODIGO_PUBLICACION_PRODUCTO"].'">'.$fila["NOMBRE_PRODUCTO"].' - ';
                  if ($fila["CODIGO_TIPO_MONEDA"] == 1) {
                    echo 'L.';
                  } else {
                    echo '$';
                  }
                  echo $fila["PRECIO"].'</a></li>';
                }
                echo '</ul>';
              ?>

              <h4 style="margin-top:20px">REGIÓN CENTRO-ORIENTAL</h4>
              <p>Productos y servicios más destacados de Francisco Morazán, El Paraíso y Olancho.</p>
              <?php
                $resultado = $conexion->ejecutarInstruccion("
                  SELECT * FROM (
                  SELECT PP.CODIGO_PUBLICACION_PRODUCTO, PP.NOMBRE_PRODUCTO,
                  PP.CODIGO_TIPO_MONEDA, PP.PRECIO
                  FROM TBL_PUBLICACION_PRODUCTOS PP
                  INNER JOIN TBL_VEND_X_TBL_PUBLI VXP
                  ON PP.CODIGO_PUBLICACION_PRODUCTO=VXP.CODIGO_PUBLICACION_PRODUCTO
                  INNER JOIN TBL_USUARIOS U
                  ON VXP.CODIGO_USUARIO_VENDEDOR=U.CODIGO_USUARIO
                  INNER JOIN TBL_LUGARES L
                  ON U.CODIGO_LUGAR=L.CODIGO_LUGAR
                  WHERE PP.CODIGO_ESTADO_PUBLICACION=1
                  AND L.CODIGO_LUGAR IN (1,8,15)
                  ORDER BY obtener_valoracion(U.CODIGO_USUARIO) DESC)
                  WHERE ROWNUM <= 4");
                oci_execute($resultado);
                echo '<ul style="margin:-10px 0 10px 20px">';
                while ($fila = $conexion->obtenerFila($resultado)) {
                  echo '<li><a href="InfodeProductos.php?codigo-publicacion='.$fila["CODIGO_PUBLICACION_PRODUCTO"].'">'.$fila["NOMBRE_PRODUCTO"].' - ';
                  if ($fila["CODIGO_TIPO_MONEDA"] == 1) {
                    echo 'L.';
                  } else {
                    echo '$';
                  }
                  echo $fila["PRECIO"].'</a></li>';
                }
                echo '</ul>';
              ?>

              <h4 style="margin-top:20px">REGIÓN SUR</h4>
              <p>Productos y servicios más destacados de Choluteca y Valle.</p>
              <?php
                $resultado = $conexion->ejecutarInstruccion("
                  SELECT * FROM (
                  SELECT PP.CODIGO_PUBLICACION_PRODUCTO, PP.NOMBRE_PRODUCTO,
                  PP.CODIGO_TIPO_MONEDA, PP.PRECIO
                  FROM TBL_PUBLICACION_PRODUCTOS PP
                  INNER JOIN TBL_VEND_X_TBL_PUBLI VXP
                  ON PP.CODIGO_PUBLICACION_PRODUCTO=VXP.CODIGO_PUBLICACION_PRODUCTO
                  INNER JOIN TBL_USUARIOS U
                  ON VXP.CODIGO_USUARIO_VENDEDOR=U.CODIGO_USUARIO
                  INNER JOIN TBL_LUGARES L
                  ON U.CODIGO_LUGAR=L.CODIGO_LUGAR
                  WHERE PP.CODIGO_ESTADO_PUBLICACION=1
                  AND L.CODIGO_LUGAR IN (3,17)
                  ORDER BY obtener_valoracion(U.CODIGO_USUARIO) DESC)
                  WHERE ROWNUM <= 4");
                oci_execute($resultado);
                echo '<ul style="margin:-10px 0 10px 20px">';
                while ($fila = $conexion->obtenerFila($resultado)) {
                  echo '<li><a href="InfodeProductos.php?codigo-publicacion='.$fila["CODIGO_PUBLICACION_PRODUCTO"].'">'.$fila["NOMBRE_PRODUCTO"].' - ';
                  if ($fila["CODIGO_TIPO_MONEDA"] == 1) {
                    echo 'L.';
                  } else {
                    echo '$';
                  }
                  echo $fila["PRECIO"].'</a></li>';
                }
                echo '</ul>';
              ?>

        </div>
      </div>
    </div>
        
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>