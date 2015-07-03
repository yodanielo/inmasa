<?php
function clean_source ($src) {

	$host = str_replace ('www.', '', $_SERVER['HTTP_HOST']);
	$regex = "/^((ht|f)tp(s|):\/\/)(www\.|)" . $host . "/i";

	$src = preg_replace ($regex, '', $src);
	$src = strip_tags ($src);
    $src = check_external ($src);

    // remove slash from start of string
    if (strpos ($src, '/') === 0) {
        $src = substr ($src, -(strlen ($src) - 1));
    }

    // don't allow users the ability to use '../'
    // in order to gain access to files below document root
    $src = preg_replace ("/\.\.+\//", "", $src);

    // get path to image on file system
    $src = get_document_root ($src) . '/' . $src;

    return $src;

}
function check_external ($src) {

    if (preg_match ('/http:\/\//', $src) == true) {

      $url_info = parse_url ($src);


			$fileDetails = pathinfo ($src);
			$ext = strtolower ($fileDetails['extension']);

			$filename = md5 ($src);
			$local_filepath = DIRECTORY_TEMP . '/' . $filename . '.' . $ext;

			if (!file_exists ($local_filepath)) {

				if (function_exists ('curl_init')) {

					$fh = fopen ($local_filepath, 'w');
					$ch = curl_init ($src);

					curl_setopt ($ch, CURLOPT_URL, $src);
					curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt ($ch, CURLOPT_HEADER, 0);
					curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');
					curl_setopt ($ch, CURLOPT_FILE, $fh);

					if (curl_exec ($ch) === FALSE) {
						if (file_exists ($local_filepath)) {
							unlink ($local_filepath);
						}
						display_error ('error reading file ' . $src . ' from remote host: ' . curl_error($ch));
					}

					curl_close ($ch);
					fclose ($fh);

                } else {

					if (!$img = file_get_contents($src)) {
						display_error('remote file for ' . $src . ' can not be accessed. It is likely that the file permissions are restricted');
					}

					if (file_put_contents ($local_filepath, $img) == FALSE) {
						display_error ('error writing temporary file');
					}

				}

				if (!file_exists($local_filepath)) {
					display_error('local file for ' . $src . ' can not be created');
				}

			}

			$src = $local_filepath;

		}

    return $src;

}
function get_document_root ($src) {

    // check for unix servers
    if (file_exists ($_SERVER['DOCUMENT_ROOT'] . '/' . $src)) {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    // check from script filename (to get all directories to timthumb location)
    $parts = array_diff (explode ('/', $_SERVER['SCRIPT_FILENAME']), explode('/', $_SERVER['DOCUMENT_ROOT']));
    $path = $_SERVER['DOCUMENT_ROOT'];
    foreach ($parts as $part) {
        $path .= '/' . $part;
        if (file_exists($path . '/' . $src)) {
            return $path;
        }
    }

    // the relative paths below are useful if timthumb is moved outside of document root
    // specifically if installed in wordpress themes like mimbo pro:
    // /wp-content/themes/mimbopro/scripts/timthumb.php
    $paths = array (
        ".",
        "..",
        "../..",
        "../../..",
        "../../../..",
        "../../../../.."
    );

    foreach ($paths as $path) {
        if (file_exists($path . '/' . $src)) {
            return $path;
        }
    }

    // special check for microsoft servers
    if (!isset ($_SERVER['DOCUMENT_ROOT'])) {
        $path = str_replace ("/", "\\", $_SERVER['ORIG_PATH_INFO']);
        $path = str_replace ($path, "", $_SERVER['SCRIPT_FILENAME']);

        if (file_exists ($path . '/' . $src)) {
            return $path;
        }
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////
// crop image
//////////////////////////////////////////////////////////////////////////////////////////////
function crop($nW, $nH, $file) {
	$size = getimagesize($file);
	$w = $size[0];
	$h = $size[1];	
	$bits = explode(".", $file);
	$ext = $bits[count($bits)-1];
	switch($ext) {
		case "gif":
		$img = imagecreatefromgif($file);
		break;
		case "jpg":
		$img = imagecreatefromjpeg($file);
		break;
		case "png":
		$img = imagecreatefrompng($file);
		break;
	}
	$newImg = imagecreatetruecolor($nW, $nH);
	$dW = $w/$nW;
	$dH = $h/$nH;
	$hH = $nH/2;
	$hW = $nW/2;
	if($dW > $dH) {
		$aW = $w / $dH;
		$halfW = $aW / 2;
		$intW = $halfW - $hW;
		if($ext == "png" || $ext == "gif"){
		  imagealphablending($newImg, false);
		  imagesavealpha($newImg,true);
		  $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
		  imagefilledrectangle($newImg, 0, 0, $aW, $nH, $transparent);
		}
		imagecopyresampled($newImg, $img, -$intW, 0, 0, 0, $aW, $nH, $w, $h);
	} else {
		$aH = $h / $dW;
		$halfH = $aH / 2;
		$intH = $halfH - $hH;
		if($ext == "png" || $ext == "gif"){
		  imagealphablending($newImg, false);
		  imagesavealpha($newImg,true);
		  $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
		  imagefilledrectangle($newImg, 0, 0, $nW, $aH, $transparent);
		}
		imagecopyresampled($newImg, $img, 0, -$intH, 0, 0, $nW, $aH, $w, $h);
	}
	imageinterlace($newImg, 1);
	switch($ext) {
		case "gif":
		  header('Content-Type: image/gif');
	  	return imagegif($newImg, null, 100);
	  	break;
		case "jpg":
	  	header('Content-Type: image/jpeg');
	  	return imagejpeg($newImg, null, 100);
	  	break;
		case "png":
  		header('Content-Type: image/png');
  		return imagepng($newImg, null, 0);
	  	break;
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////
// resize image
//////////////////////////////////////////////////////////////////////////////////////////////
function resize($nW, $nH, $file) {
	$size = getimagesize($file);
	$w = $size[0];
	$h = $size[1];	
	$bits = explode(".", $file);
	$ext = $bits[count($bits)-1];
	switch($ext) {
		case "gif":
		$img = imagecreatefromgif($file);
		break;
		case "jpg":
		$img = imagecreatefromjpeg($file);
		break;
		case "png":
		$img = imagecreatefrompng($file);
		break;
	}
	$dW = $w/$nW;
	$dH = $h/$nH;
	if($dW > $dH) { // width is max
		$newImg = imagecreatetruecolor($nW, ($nW * $h)/$w);
  	if($ext == "png" || $ext == "gif"){
  	  imagealphablending($newImg, false);
  	  imagesavealpha($newImg,true);
  	  $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
  	  imagefilledrectangle($newImg, 0, 0, $nW, ($nW * $h)/$w, $transparent);
  	}
  	imagecopyresampled($newImg, $img, 0, 0, 0, 0, $nW, ($nW * $h)/$w, $w, $h);		
	} else { // height is max
		$newImg = imagecreatetruecolor(($nH * $w)/$h, $nH);
		if($ext == "png" || $ext == "gif"){
		  imagealphablending($newImg, false);
		  imagesavealpha($newImg,true);
		  $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
		  imagefilledrectangle($newImg, 0, 0, ($nH * $w)/$h, $nH, $transparent);
		}
		imagecopyresampled($newImg, $img, 0, 0, 0, 0, ($nH * $w)/$h, $nH, $w, $h);
	}
	imageinterlace($newImg, 1);
	switch($ext) {
		case "gif":
  		header('Content-Type: image/gif');
  		return imagegif($newImg, null, 100);
  		break;
		case "jpg":
  		header('Content-Type: image/jpeg');
  		return imagejpeg($newImg, null, 100);
  		break;
		case "png":
  		header('Content-Type: image/png');
  		return imagepng($newImg, null, 0);
  		break;
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////
// return new image
// f = filepath
// w = new width
// h = new height
// a = action, c(rop) or r(esize)
//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['f']) && isset($_GET['w']) && isset($_GET['h']) && isset($_GET['a'])) {
	if($_GET['a'] == "c") {
		crop($_GET['w'], $_GET['h'], clean_source($_GET['f']));
	} else {
		resize($_GET['w'], $_GET['h'], clean_source($_GET['f']));
	}
}
?>