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
	$result = @mysqli_query($MySQL, $query);
	$row = @mysqli_fetch_array($result);
	$rowcount = mysqli_num_rows($result);
	
	if ($rowcount == 0) 
	{
		$query  = "INSERT INTO users (name, lastname, email, username, password, country_id)";
		$query .= " VALUES ('" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "', '" . $_POST['email'] . "', '" . $_POST['username'] . "', '" . $_POST['password'] . "', " . $_POST['country'] . ")";
		$result = @mysqli_query($MySQL, $query);
		
		$msginfo =  "Uspješno ste se registrirali!";
	}
	else 
	{
		$msginfo =  "Neuspješna registracija - korisničko ime se već koristi!";
	}	
}

?>
<h2><?php print $title ?></h2>
<hr />
<div>
	<div class="msginfo"><?php print $msginfo ?></div>
   <form action="" id="registration_form" name="registration_form" method="POST">
      <input type="hidden" id="act" name="act" value="1">
      <label for="fname">Ime: *</label>
      <input type="text" id="fname" name="firstname" placeholder="Vaše ime.." required>
      <label for="lname">Prezime: *</label>
      <input type="text" id="lname" name="lastname" placeholder="Vaše prezime.." required>
      <label for="email">E-mail: *</label>
      <input type="email" id="email" name="email" placeholder="Vaš e-mail.." required>
      <label for="username">Korisničko ime: *</label>
      <input type="text" id="username" name="username" placeholder="Korisničko ime.." required><br>
      <label for="password">Lozinka: *</label>
      <input type="password" id="password" name="password" placeholder="Lozinka.." required>
      <label for="country">Država:</label>
      <select id="country" name="country" required>
         <?php 
		 $query  = "SELECT * FROM countries";
		 $result = @mysqli_query($MySQL, $query);
		 while($row = @mysqli_fetch_array($result)) {
		 $selected='';
		 if ($row['code'] == 'HR')
		 {
			 $selected='selected';
		 }
		 print '<option ' . $selected . ' value="' . $row['id'] . '">' . $row['name'] . '</option>';
		 }
		 ?>
      </select>
      <input type="submit" class="btn btn-primary btn-lg" value="Registriraj se">
   </form>
</div>