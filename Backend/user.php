<?php
include 'session.php';

// Ensure that user is logged in
if (!isset($uid))
{
	echo '<script type="text/javascript">';
	echo 'window.location.href = "index.php"';
	echo '</script>';
}

?>
