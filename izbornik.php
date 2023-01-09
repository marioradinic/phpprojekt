<?php
include("provjerimain.php");	
?>
<div class="navbar navbar-inverse">
   <div class="container">
      <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         </button>
         <a href="./index.php?pg=1" class="navbar-brand">Naslovna</a>
      </div>
      <div class="navbar-collapse collapse">
         <ul class="nav navbar-nav">
            <li><a href="index.php?pg=2">Proizvodi</a></li>
            <li><a href="index.php?pg=3">Vijesti</a></li>
            <li><a href="index.php?pg=4">Kontakt</a></li>
			<li><a href="index.php?pg=10">Moja košarica</a></li>
         </ul>
         <ul class="nav navbar-nav navbar-right">
<?php
if (!isset($_SESSION['user']['is_logon']) || !$_SESSION['user']['is_logon'] == '1')
{
?>
            <li><a href="index.php?pg=5">Registracija</a></li>
            <li><a href="index.php?pg=6">Prijava</a></li>
<?php
}
else if ($_SESSION['user']['is_logon'] == '1')
{
	if ($_SESSION['user']['is_admin'] == '1')
	{
?>
            <li><a href="index.php?pg=7">Administracija</a></li>
<?php
	}
	else
	{
?>
            <li><a href="index.php?pg=13">Moje narudžbe</a></li>
<?php
	}
?>
			<li><a href="odjava.php">Odjava</a></li>		
<?php
}
?>
         </ul>
      </div>
   </div>
</div>