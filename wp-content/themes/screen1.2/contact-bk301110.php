<?php
session_start();
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
    die('Please do not load this page directly. Thanks!');
}

/* Check if contact form should be shown on this Page/Post */
if (get_post_meta($post->ID, '_screen-showContact', true) == 'true') {
    $contactTitle = get_post_meta($post->ID, '_screen-contact-title', true);
    $showGender = get_post_meta($post->ID, '_screen-contact-showGender', true);
    $showName = get_post_meta($post->ID, '_screen-contact-showName', true);
    $contactNameRequired = get_post_meta($post->ID, '_screen-contact-nameRequired', true);
    $showAddress = get_post_meta($post->ID, '_screen-contact-showAddress', true);
    $contactAddressRequired = get_post_meta($post->ID, '_screen-contact-addressRequired', true);
    $showPostalcode = get_post_meta($post->ID, '_screen-contact-showPostalcode', true);
    $contactPostalcodeRequired = get_post_meta($post->ID, '_screen-contact-postalcodeRequired', true);
    $showCity = get_post_meta($post->ID, '_screen-contact-showCity', true);
    $contactCityRequired = get_post_meta($post->ID, '_screen-contact-cityRequired', true);
    $showCountry = get_post_meta($post->ID, '_screen-contact-showCountry', true);
    $contactCountryRequired = get_post_meta($post->ID, '_screen-contact-countryRequired', true);
    $showTelephone = get_post_meta($post->ID, '_screen-contact-showTelephone', true);
    $contactTelephoneRequired = get_post_meta($post->ID, '_screen-contact-telephoneRequired', true);
    $showEmail = get_post_meta($post->ID, '_screen-contact-showEmail', true);
    $contactEmailRequired = get_post_meta($post->ID, '_screen-contact-emailRequired', true);
    $showMessage = get_post_meta($post->ID, '_screen-contact-showMessage', true);
    $contactMessageRequired = get_post_meta($post->ID, '_screen-contact-messageRequired', true);
    $contactCaptcha = get_post_meta($post->ID, '_screen-contact-captcha', true);

    /* If form has been submitted */
    if (isset($_POST['contact-sent'])) {
        if ($contactCaptcha == 'false' || md5(strtoupper($_POST['captcha'])) == $_SESSION['captchatxt']) {
            $emailTo = get_post_meta($post->ID, '_screen-contact-emailto', true);
            $subject = trnslt('This message was sent from') . ' ' . get_bloginfo('name') . ' (' . get_bloginfo('url') . ')';
            $mailText = $subject . '
------------------------------------------------

';
            if (isset($_POST['contact-gender'])) {
                $mailText .= trnslt('Gender') . ': ';
                if ($_POST['contact-gender'] == 'm') {
                    $mailText .= trnslt('Male') . '
';
                } else {
                    $mailText .= trnslt('Female') . '
';
                }
            }
            if (isset($_POST['contact-name'])) {
                $mailText .= trnslt('Name') . ': ' . $_POST['contact-name'] . '
';
            }
            if (isset($_POST['contact-address'])) {
                $mailText .= trnslt('Address') . ': ' . $_POST['contact-address'] . '
';
            }
            if (isset($_POST['contact-postalcode'])) {
                $mailText .= trnslt('Postal code') . ': ' . $_POST['contact-postalcode'] . '
';
            }
            if (isset($_POST['contact-city'])) {
                $mailText .= trnslt('City') . ': ' . $_POST['contact-city'] . '
';
            }
            if (isset($_POST['contact-country'])) {
                $mailText .= trnslt('Country') . ': ' . $_POST['contact-country'] . '
';
            }
            if (isset($_POST['contact-telephone'])) {
                $mailText .= trnslt('Telephone') . ': ' . $_POST['contact-telephone'] . '
';
            }
            if (isset($_POST['contact-email'])) {
                $mailText .= trnslt('E-mail') . ': ' . $_POST['contact-email'] . '
';
            }
            if (isset($_POST['desautorizo'])) {
                $mailText .= 'El usuario no autoriza el uso de mis datos personales para usos no relacionados estrictamente con la consulta específica realizada a INMASA.';
            }
            //if(isset($_POST['contact-adjunto'])) {
            if (is_uploaded_file($_FILES["contact-adjunto"]['tmp_name'])) {
                $narchivo = mktime() . str_replace(" ", "", basename(strtolower(str_replace(array("á", "é", "í", "ó", "ú", "ñ"), array("a", "e", "i", "o", "u", "n"), $_FILES['contact-adjunto']['name']))));
                $ruta0 = "curriculumvitae/" . str_replace(".pdf", ".pdf", $narchivo);
                move_uploaded_file($_FILES['contact-adjunto']['tmp_name'], $ruta0);
                $link = get_option('siteurl') . "/wp-content/themes/screen1.2/curriculumvitae/" . $narchivo;
                $mailText .= trnslt('Curriculum Vitae') . ': ' . $link . '</a>';
            }
            //}
            if (isset($_POST['contact-message'])) {
                $mailText .= trnslt('Message') . ':
' . $_POST['contact-message'];
            }
            $mailText .= '
    
------------------------------------------------
';

            $message = '';
            $headers = 'From: ' . get_bloginfo('name') . '<' . get_bloginfo('admin_email') . '>' . "\r\n" .
                    'Reply-To: ' . get_bloginfo('admin_email') . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

            /* Send e-mail */
            if (mail($emailTo, $subject, $mailText, $headers)) {
                $message = trnslt('Your information has been successfully sent.');
            } else {
                $message = trnslt('Something went wrong whilst sending your information. Please try again at a later time.');
            }
        } else {
            $message = trnslt('Wrong CAPTCHA code entered.');
        }
    }

    /* Display form elements */
?>
    <div id="formcontacto">
        <form method="post" action="" name="contactform" id="contactform" <?php if ($post->ID == 26) { ?>enctype="multipart/form-data"<?php } ?> >
        <?php
        if (trim($contactTitle) != '') {
        ?>
            <h2><?php echo $contactTitle; ?></h2>
        <?php
        }
        if (isset($message)) {
        ?>
            <div id="contact-message"><?php echo $message; ?></div>
        <?php
        }
        ?>
        <div id="contact-error"><?php echo trnslt('Please fill in all required (*) fields.'); ?></div>
        <?php
        if ($showGender == 'true') {
            $fSel = ($_POST['contact-gender'] == 'f') ? ' checked' : '';
            $mSel = ($fSel == '') ? ' checked' : '';
        ?>
            <div class="contact-row">
                <div class="contact-label"><?php echo trnslt('Gender'); ?>:</div>
                <div class="contact-field"><input type="radio" name="contact-gender" value="m"<?php echo $mSel; ?> /> <?php echo trnslt('Male'); ?><input type="radio" name="contact-gender" value="f"<?php echo $fSel; ?> /> <?php echo trnslt('Female'); ?></div>
            </div>
        <?php
        }
        if ($showName == 'true') {
        ?>
            <div class="contact-row">
                <div class="contact-label"><?php echo trnslt('Name'); ?><?php if ($contactNameRequired == 'true') { ?> *<?php } ?></div>
                <div class="contact-field"><input type="text" name="contact-name" value="<?php echo $_POST['contact-name']; ?>"<?php if ($contactNameRequired == 'true') { ?> class="required-field"<?php } ?> /></div>
            </div>
        <?php
        }
        if ($showAddress == 'true') {
        ?>
            <div class="contact-row">
                <div class="contact-label"><?php echo trnslt('Address'); ?><?php if ($contactAddressRequired == 'true') { ?> *<?php } ?></div>
                <div class="contact-field"><input type="text" name="contact-address" value="<?php echo $_POST['contact-address']; ?>"<?php if ($contactAddressRequired == 'true') { ?> class="required-field"<?php } ?> /></div>
            </div>
        <?php
        }
        if ($showPostalcode == 'true') {
        ?>
            <div class="contact-row">
                <div class="contact-label"><?php echo trnslt('Postalcode'); ?><?php if ($contactPostalcodeRequired == 'true') { ?> *<?php } ?></div>
                <div class="contact-field"><input type="text" name="contact-postalcode" value="<?php echo $_POST['contact-postalcode']; ?>"<?php if ($contactPostalcodeRequired == 'true') { ?> class="required-field"<?php } ?> /></div>
            </div>
        <?php
        }
        if ($showCity == 'true') {
        ?>
            <div class="contact-row">
                <div class="contact-label"><?php echo trnslt('City'); ?><?php if ($contactCityRequired == 'true') { ?> *<?php } ?></div>
                <div class="contact-field"><input type="text" name="contact-city" value="<?php echo $_POST['contact-city']; ?>"<?php if ($contactCityRequired == 'true') { ?> class="required-field"<?php } ?> /></div>
            </div>
        <?php
        }
        if ($showCountry == 'true') {
        ?>
            <div class="contact-row">
                <div class="contact-label"><?php echo trnslt('Country'); ?><?php if ($contactCountryRequired == 'true') { ?> *<?php } ?></div>
                <div class="contact-field"><input type="text" name="contact-country" value="<?php echo $_POST['contact-country']; ?>"<?php if ($contactCountryRequired == 'true') { ?> class="required-field"<?php } ?> /></div>
            </div>
        <?php
        }
        if ($showTelephone == 'true') {
        ?>
            <div class="contact-row">
                <div class="contact-label"><?php echo trnslt('Telephone'); ?><?php if ($contactTelephoneRequired == 'true') { ?> *<?php } ?></div>
                <div class="contact-field"><input type="text" name="contact-telephone" value="<?php echo $_POST['contact-telephone']; ?>"<?php if ($contactTelephoneRequired == 'true') { ?> class="required-field"<?php } ?> /></div>
            </div>
        <?php
        }
        if ($showEmail == 'true') {
        ?>
            <div class="contact-row">
                <div class="contact-label"><?php echo trnslt('E-mail'); ?><?php if ($contactEmailRequired == 'true') { ?> *<?php } ?></div>
                <div class="contact-field"><input type="text" name="contact-email" value="<?php echo $_POST['contact-email']; ?>"<?php if ($contactEmailRequired == 'true') { ?> class="required-field"<?php } ?> /></div>
            </div>
        <?php
        }
        if ($post->ID == 26) {
        ?>
            <div class="contact-row">
                <div class="contact-label"><?php echo trnslt('Ajunta tu CV'); ?>*</div>
                <div class="contact-field"><input type="file" name="contact-adjunto" value="<?php echo $_POST['contact-adjunto']; ?>" class="required-field" /></div>
            </div>
        <?php
        }
        if ($showMessage == 'true') {
        ?>
            <div class="contact-row">
                <div class="contact-label"><?php echo trnslt('Message'); ?><?php if ($contactMessageRequired == 'true') { ?> *<?php } ?></div>
                <div class="contact-field"><textarea name="contact-message" rows="" cols=""<?php if ($contactMessageRequired == 'true') { ?> class="required-field"<?php } ?>><?php echo $_POST['contact-message']; ?></textarea></div>
            </div>
        <?php
        }
        if ($contactCaptcha == 'true') {
        ?>
            <div class="contact-row">
                <div class="contact-label">&nbsp;</div>
                <div class="contact-field"><img src="<?php bloginfo('template_url'); ?>/lib/captcha/captcha.php" style="margin:0 0 5px 0; float:none;" /><br /><input type="text" name="captcha" value="" class="required-field" /></div>
            </div>
        <?php
        }
        if ($post->ID == 26) {
        ?>
            <div class="contact-row">
                <div class="contact-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                <div class="contact-field" style="width:300px">
                    <label>
                        <input type="checkbox" name="desautorizo" value="1" checked />
                        No autorizo el uso de mis datos personales para usos no relacionados estrictamente con la gestión de ofertas de empleo de INMASA”
                    </label>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="contact-row">
                <div class="contact-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                <div class="contact-field" style="width:300px">
                    <label>
                        <input type="checkbox" name="desautorizo" value="1" checked />
                        No autorizo el uso de mis datos personales para usos no relacionados estrictamente con la consulta específica realizada a INMASA.
                    </label>
                </div>
            </div>
        <?php
        }
        ?>
        <div class="contact-row">
            <div class="contact-label"><input type="hidden" name="contact-sent" value="1" />&nbsp;</div>
            <div class="contact-field"><a href="javascript:void(0)" class="cp td-button" id="contact-submit"><span><?php echo trnslt('Submit'); ?></span></a></div>
        </div>
        <div class="floatfix"></div>
    </form>
</div>
<div id="gmapcontacto">
    <?php
        $gmap = get_post_meta($post->ID, "googlemaps", true);
        if ($gmap) {
            echo $gmap;
        }
    ?>
    </div>
<?php
    }
?>
<div id="textocontact">
<?php
    if ($post->ID != 26) {
        //contacto
?>
        <p>
            De conformidad con lo establecido en el art. 5 de la Ley Orgánica 15/1999, le informamos que los datos que se solicitan en este formulario son necesarios para dar contestación a la consulta/solicitud/pedido que nos remite y formarán parte de los ficheros de INMASA como Responsable de Ficheros, para uso interno, así como para la gestión administrativa derivada de la contestación a la consulta / solicitud y/o pedido que nos formula, así como para, en su caso, la gestión derivada de la oferta de aquellos servicios que entendamos encajen dentro del perfil que nos señale.
        </p>
        <p>
            Los derechos de acceso, rectificación, cancelación y oposición a los datos personales que como consecuencia de la cumplimentación de dicho formulario a través de esta página Web queden registrados, se ejercerán en la dirección de INMASA indicada en la página principal de la presente Web
        </p>

        <p>
            &nbsp;
        </p>
<?php
    } else {
        //curriculum
?>
        <p>
            “Conforme a lo establecido en el artículo 5 de la LOPD 15/99, le informamos de la incorporación de los datos personales facilitados a través de su currículum vitae a los ficheros automatizados del Responsable de Ficheros, INMASA, para uso interno, así como para la oferta y gestión de las posibles ofertas de empleo o colaboración que pudieran generarse. Asimismo, autoriza la comunicación de dichos datos para las indicadas finalidades que pueda ser realizada entre la Entidad y otras sociedades relacionadas con la prestación de los productos y/o servicios de la organización para las mismas finalidades expuestas anteriormente. Queda informado de la posibilidad de ejercer sus derechos de acceso, rectificación, cancelación y oposición ante INMASA, para lo cual deberá comunicarnos de forma documentada la solicitud del mismo a la dirección del Responsable de Ficheros: INMASA, Hermanos Menéndez Pidal, 8, 1º izquierda – 33005 - Oviedo – Asturias (España).
        </p>
        <p>
            INMASA, solicita su autorización para realizar el tratamiento de sus datos. No obstante, si usted no desea que el tratamiento mencionado anteriormente se produzca para usos no directamente relacionados con la gestión de posibles ofertas de empleo de INMASA, puede comunicárnoslo dirigiéndose a nosotros a través de los medios anteriormente indicados, marcando una “x” en la casilla que a continuación se detalla, significándole que, conforme a la legislación vigente, si no recibimos noticias suyas en el plazo de un mes, entenderemos otorgado su consentimiento que, en todo caso podría revocar en cualquier momento.
        </p>
        <p>
            <label>

            </label>
        </p>
<?php
    }
?>
</div>