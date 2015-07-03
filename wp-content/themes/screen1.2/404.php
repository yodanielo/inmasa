<?php
/* Instead of a 404 page, search for the requested uri */
header('Location:' . get_bloginfo('url') . '/?s=' . str_replace('/', ' ', $_SERVER['REQUEST_URI']));
exit();
?>