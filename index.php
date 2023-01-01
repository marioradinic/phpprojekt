<?php
session_start();

$mainchecker = "1";

include ("db.php");

$user_active_name = '';
$user_active_lastname = '';
$user_active_email = '';

if (isset($_SESSION['user']['is_logon']) 
	&& $_SESSION['user']['is_logon'] == '1'
	&& isset($_SESSION['user']['id']))
{
	$query  = "SELECT * FROM users";
	$query .= " WHERE id=" . $_SESSION['user']['id'];
	$result = @mysqli_query($MySQL, $query);
	$row = @mysqli_fetch_array($result);
	$rowcount = mysqli_num_rows($result);
	
	if ($rowcount > 0) 
	{
		$user_active = $row['isactive'];
		if ($user_active == 'N')
		{
			header("Location: odjava.php");
		}
		$user_isadmin = $row['isadmin'];
		$_SESSION['user']['is_admin'] = ($user_isadmin == 'Y' ? '1' : '0');
		$user_active_name = $row['name'];
		$user_active_lastname = $row['lastname'];
		$user_active_email = $row['email'];
	}
	else
	{
		header("Location: odjava.php");
	}
}

$pg = 1;
if(isset($_GET['pg'])) { $pg = $_GET['pg']; }

?>

<?php
	switch ($pg) 
	{
		case "2":
		$page = "proizvodi.php";
		$title="Proizvodi";
		break;
		case "3":
		$page = "vijesti.php";
		$title="Vijesti";
		break;
		case "4":
		$page = "kontakt.php";
		$title="Kontakt";
		break;
		case "5":
		$page = "registracija.php";
		$title="Registracija";
		break;
		case "6":
		$page = "prijava.php";
		$title="Prijava";
		break;
		case "7":
		case "8":
		case "9":
		case "12":
		$page = "administracija.php";
		$title="Administracija";
		break;
		case "10":
		$page = "kosarica.php";
		$title="Moja košarica";
		break;
		case "11":
		$page = "narudzba.php";
		$title="Moja narudžba";
		break;
		default:
		$page = "pocetna.php";
		$title="Trgovina knjiga";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="description" content="Trgovina knjiga">
<meta name="keywords" content="Trgovina knjiga">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="css/bootstrap.css" rel="stylesheet"/>
<link href="css/Site.css" rel="stylesheet"/>
<link href="css/glyphicon.css" rel="stylesheet"/>

<meta itemprop="name" content="<?php print $title ?>">
<meta itemprop="description" content="Trgovina knjiga">

<meta property="og:title" content="<?php print $title ?>">
<meta property="og:description" content="Trgovina knjiga">

<meta name="twitter:title" content="<?php print $title ?>">
<meta name="twitter:description" content="Trgovina knjiga">

<meta name="author" content="mario radinic">
<link rel="icon" href="favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>

<title><?php print $title ?></title>
</head>
<body>
<script src="js/jquery-3.4.1.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>
<div class="head-img"></div>
<?php include("izbornik.php"); ?>
<div class="container body-content">           
<?php
	include($page);	
?>
<hr class="clear" />
<footer>
<p>&copy; <?php print date('Y'); ?> - Trgovina knjiga</p>
</footer>
</div>
</body>
</html>
