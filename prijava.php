<?php

include("provjerimain.php");

if (isset($_SESSION['user']['is_logon']) && $_SESSION['user']['is_logon'] == '1')
{
	header("Location: index.php?pg=1");
}

$act = 2;
$msginfo =  "";

if(isset($_POST['act'])) { $act = $_POST['act']; }

if ($act == 1)
{
	$query  = "SELECT * FROM users";
	$query .= " WHERE username='" . $_POST['username'] . "'";
	$query .= " and password='" . $_POST['password'] . "'";
	$query .= " and isactive='Y'";
	$result = @mysqli_query($MySQL, $query);
	$row = @mysqli_fetch_array($result);
	$rowcount = mysqli_num_rows($result);
	
	if ($rowcount > 0) 
	{
		$user_isadmin = $row['isadmin'];
		$_SESSION['user']['is_logon'] = '1';
		$_SESSION['user']['id'] = $row['id'];
		$_SESSION['user']['is_admin'] = ($user_isadmin == 'Y' ? '1' : '0');
		header("Location: index.php?pg=1");
	}
	else 
	{
		$msginfo =  "Neuspješna prijava!";
	}	
}

?>
<h2><?php print $title ?></h2>
<hr />
<div>
	<div class="msginfo"><?php print $msginfo ?></div>
   <form action="" name="myForm" id="myForm" method="POST">
      <input type="hidden" id="act" name="act" value="1">
      <label for="username">Korisničko ime: *</label>
      <input type="text" id="username" name="username" value="" required>
      <label for="password">Lozinka: *</label>
      <input type="password" id="password" name="password" value="" required>
      <input type="submit" class="btn btn-primary btn-lg" value="Prijavi se">
   </form>
</div>