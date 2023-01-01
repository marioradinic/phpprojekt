<?php

include("provjeriadminprava.php");	

$h3title = "Korisnici";

	switch ($pg) 
	{
		case "8":
		$page = "admin_proizvodi.php";
		$h3title="Proizvodi";
		break;
		case "9":
		$page = "admin_vijesti.php";
		$h3title="Vijesti";
		break;
		case "12":
		$page = "admin_narudzbe.php";
		$h3title="Narudžbe";
		break;
		default:
		$page = "admin_korisnici.php";
	}
?>
<script type="text/javascript">
function obrisi() {
	var conf = confirm("Želite obrisati odabrani zapis?");
	if (conf == true)
		return true;
	else
		return false;
	}
</script>
<h2><?php print $title ?></h2>
<hr />
<div class="admin">
	<ul>
		<li><a href="index.php?pg=7&act=1" class="<?php ($pg == 7 ? print 'active' : '') ?>">Korisnici</a></li>
		<li><a href="index.php?pg=8&act=1" class="<?php ($pg == 8 ? print 'active' : '') ?>">Proizvodi</a></li>
		<li><a href="index.php?pg=9&act=1" class="<?php ($pg == 9 ? print 'active' : '') ?>">Vijesti</a></li>
		<li><a href="index.php?pg=12&act=1" class="<?php ($pg == 12 ? print 'active' : '') ?>">Narudžbe</a></li>
	</ul>
	<hr class="clear" />
	<h4><?php print $h3title ?></h4>
    <?php
	include($page);	
	?>
</div>