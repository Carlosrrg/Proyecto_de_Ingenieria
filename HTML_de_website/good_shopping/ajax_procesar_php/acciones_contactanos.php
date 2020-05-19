<?php
    $nombre = $_POST["txt_nombre"];
    $correo = $_POST["txt_correo"];
    $sugerencia = $_POST["txt_sugerencia"];

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo '0';
    }else if (empty($_POST["txt_nombre"])||empty($_POST["txt_correo"])||empty($_POST["txt_sugerencia"])){
        echo 'Ningun campo debe estar vacio';
    }else{
        //FUNCION PARA ENVIAR CORREO DE CAMBIO DE CONTRASEÑA
        $email_subject = "Sugerencia para Good Shopping";
        $email_message = "Remitente: ".$nombre.":\n\n";
        $email_message .= "Correo electrónico: ".$correo."\n";
        $email_message .= "Mensaje: .\n".$sugerencia."\n\n";
        $header = "From:adm.goodshopping@gmail.com\r\n";
        $header .= "X-Mailer: PHP/" . phpversion() . "  \r\n";
        $header .= "Mime-Version: 1.0 \r\n";
        $header .= "Content-Type:  text/plain";

        if (mail("adm.goodshopping@gmail.com",$email_subject,$email_message,$header)) {
            echo "Se envío correo a adm.goodshopping@gmail.com\n";
        }else{
            echo $mensaje = "Error al enviar correo\n";
        }
    }
    //FIN DE FUNCION PARA ENVIAR CORREO
?>