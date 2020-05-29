<head>
	<title>Logging out...</title>
	<style>
		body {
			background-color: white;
		}

	</style>
</head>
<?php

session_name('contact');
session_start();
$err = '';
$user = '';
$type = 'error';
$redi = 'overview';
if (isset($_GET['error']))
{
	$err = $_GET['error'];
}

if (isset($_GET['success']))
{
	$err = $_GET['success'];
	$type = "success";
}

if (isset($_GET['redirect']))
{
	$redi = $_GET['redirect'];
}



if(session_destroy()) // Destroying All Sessions
{


echo '<script type="text/javascript">';

//echo 'window.location.href = "enterance.php"';


echo 'window.location.href = "index.php?&'.$type.'='. $err . '"';

echo '</script>'; // Redirecting To Home Page
}
?>

<body>
	<div> &nbsp;</div>
</body>
