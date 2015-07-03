<div id="col1contacto">
    <?php
    $gmap = get_post_meta($post->ID, "googlemaps", true);
    if ($gmap) {
        echo $gmap;
    }
    ?>
</div>
<div id="col2contacto">
    <img id="logocontacto" src="<?php bloginfo("template_directory")?>/images/logo-inmasa-contacto.jpg" />
    <div id="col2con_fila">
        <p>
            &nbsp;
            <br/>
            C/ Hnos. Menéndez Pidal, 8 - 1º<br/>
            Telf: 985 27 60 62. Fax: 985 27 45 68.<br/>
            C.P. 33005 Oviedo. ASTURIAS<br/>
            Correo electrónico: <a href="mailto:inmasa@inmasa-ingenieria.com">inmasa@inmasa-ingenieria.com</a>
        </p>
    </div>
</div>