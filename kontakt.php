<?php

include("provjerimain.php");

$act = 2;
$msginfo =  "";

if(isset($_POST['act'])) { $act = $_POST['act']; }

if ($act == 1)
{
	$msginfo =  "Vaš upit je poslan!";	
}
?>
<h2><?php print $title ?></h2>
<hr />
<h3>Trgovina knjiga d.o.o.</h3>
<address>
   Zagrebačka 42<br>
   10410 Velika Gorica<br>
   Telefon: 01/6216-111
</address>
<address>
   <strong>Podrška:</strong>   <a href="mailto:Podrska@TrgovinaKnjiga.com">Podrska@TrgovinaKnjiga.com</a><br>
   <strong>Marketing:</strong> <a href="mailto:Marketing@TrgovinaKnjiga.com">Marketing@TrgovinaKnjiga.com</a>
</address>
<hr />
<div>
	<div class="msginfo"><?php print $msginfo ?></div>
   <form action="" id="contact_form" name="contact_form" method="POST">
      <input type="hidden" id="act" name="act" value="1">
      <label for="fname">Ime: *</label>
      <input type="text" id="fname" name="firstname" placeholder="Vaše ime.." required>
      <label for="lname">Prezime: *</label>
      <input type="text" id="lname" name="lastname" placeholder="Vaše prezime.." required>
      <label for="email">E-mail: *</label>
      <input type="email" id="email" name="email" placeholder="Vaš e-mail.." required>
      <label for="country">Država:</label>
      <select id="country" name="country">
         <option value="">Odaberite...</option>
         <?php 
		 $query  = "SELECT * FROM countries";
		 $result = @mysqli_query($MySQL, $query);
		 while($row = @mysqli_fetch_array($result)) {
		 $selected='';
		 if ($row['code'] == 'HR')
		 {
			 $selected='selected';
		 }
		 print '<option ' . $selected . ' value="' . $row['code'] . '">' . $row['name'] . '</option>';
		 }
		 ?>
      </select>
      <label for="note">Poruka</label>
      <textarea id="note" name="note" placeholder="Vaša poruka.." style="height:200px"></textarea>
      <input type="submit" class="btn btn-primary btn-lg" value="Pošalji">
   </form>
</div>