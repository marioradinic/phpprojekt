<?php

include("provjerimain.php");

$act = 1;
$id = 0;
$msginfo =  "";

if(isset($_GET['act'])) { $act = $_GET['act']; }

if(isset($_POST['act'])) { $act = $_POST['act']; }

if(isset($_GET['id'])) { $id = $_GET['id']; }

if ($act == 2)
{
	$kosarica = "";
	$postoji = "0";
	if (isset($_SESSION['kosarica']))
	{
		$kosaricasession= explode(";", $_SESSION['kosarica']);
		foreach ($kosaricasession as $proizvodi)
		{
			if ($proizvodi!="")
			{
				$proizvod = explode("|", $proizvodi);
				if ($proizvod[0]==$id)
				{
					$proizvod[1] = $proizvod[1] + 1;
					$postoji = "1";
				}
				$kosarica = $kosarica . ";" . $proizvod[0] . "|" . $proizvod[1];
			}				
		}
		if ($postoji == "0" && is_numeric($id))
		{
			$kosarica = $kosarica . ";" . $id . "|" . 1;
		}
	}
	else
	{
		$kosarica= ";" .$id . "|" . 1;
	}
	$_SESSION['kosarica'] = $kosarica;
}
else if ($act == 3)
{
	unset($_SESSION['kosarica']);
}
else if ($act == 4)
{
	$kosarica = "";
	if (isset($_SESSION['kosarica']))
	{
		$kosaricasession= explode(";", $_SESSION['kosarica']);
		foreach ($kosaricasession as $proizvodi)
		{
			if ($proizvodi!="")
			{
				$proizvod = explode("|", $proizvodi);
				if ($proizvod[0]!=$id)
				{
					$kosarica = $kosarica . ";" . $proizvod[0] . "|" . $proizvod[1];
				}
			}				
		}
	}
	$_SESSION['kosarica'] = $kosarica;
}
else if ($act == 5)
{
	$checkbrojproizvoda = 0;
	if (isset($_SESSION['kosarica']))
	{
		$kosaricasession = explode(";", $_SESSION['kosarica']);
		$checkbrojproizvoda = count($kosaricasession);

		if ($checkbrojproizvoda - 1 > 0)
		{	
			$checkbrojproizvoda = 0;
			
			foreach ($kosaricasession as $proizvodi)
			{
				if ($proizvodi!="")
				{
					$proizvod = explode("|", $proizvodi);
						
					$query  = "SELECT * FROM products";
					$query .= " WHERE active='Y' and id=" . $proizvod[0];
					$result = @mysqli_query($MySQL, $query);
					$row = @mysqli_fetch_array($result);
					$rowcount = mysqli_num_rows($result);
						
					if ($rowcount > 0) 
					{
						$checkbrojproizvoda = $checkbrojproizvoda + 1;
					}
				}
			}
			if ($checkbrojproizvoda > 0)
			{
				$user_id = "NULL";
				if (isset($_SESSION['user']['id']))
					$user_id = $_SESSION['user']['id'];
				
				$query  = "INSERT INTO orders (name, lastname, email, note, user_id)";
				$query .= " VALUES ('" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "', '" . $_POST['email'] . "', '" . htmlspecialchars($_POST['note'], ENT_QUOTES) . "', " . $user_id . ")";
				$result = @mysqli_query($MySQL, $query);
						
				$new_ID = mysqli_insert_id($MySQL);
				
				foreach ($kosaricasession as $proizvodi)
				{
					if ($proizvodi!="")
					{
						$proizvod = explode("|", $proizvodi);
						
						$query  = "INSERT INTO order_items (order_id, product_id, quantity)";
						$query .= " VALUES (" . $new_ID . ", " . $proizvod[0] . ", " . $proizvod[1] . ")";
						$result = @mysqli_query($MySQL, $query);							
					}
				}
				
				$_SESSION['order_id'] = $new_ID;
			}
		}
	}
	
	unset($_SESSION['kosarica']);
	
	if ($checkbrojproizvoda > 0)
	{
		header("Location: index.php?pg=11");
		//$msginfo =  "Vaša narudžba je zaprimljena!";
	}
	else
	{
		$msginfo =  "Vaša košarica je prazna!";
	}	
}
?>
<h2><?php print $title ?></h2>
<?php
$brojproizvoda = 0;
if (isset($_SESSION['kosarica']))
{
	$kosaricasession = explode(";", $_SESSION['kosarica']);
	$brojproizvoda = count($kosaricasession);

	if ($brojproizvoda - 1 > 0)
	{
		$brojproizvoda = 0;
		
		foreach ($kosaricasession as $proizvodi)
		{
			if ($proizvodi!="")
			{
				$proizvod = explode("|", $proizvodi);
				
				$query  = "SELECT * FROM products";
				$query .= " WHERE active='Y' and id=" . $proizvod[0];
				$result = @mysqli_query($MySQL, $query);
				$row = @mysqli_fetch_array($result);
				$rowcount = mysqli_num_rows($result);
				
				if ($rowcount > 0) 
				{
					$brojproizvoda = $brojproizvoda + 1;
				}
			}
		}
		if ($brojproizvoda > 0)
		{
?>	
<hr />
	<table class="table table-striped">
        <thead>
          <tr>
            <th scope="col" style="width:50px"></th>
            <th scope="col">Proizvod</th>
            <th scope="col">Cijena</th>
			<th scope="col">Količina</th>
            <th scope="col">Ukupno</th>        
          </tr>
        </thead>
        <tbody>
<?php
			$products_pricetotal = 0;
			foreach ($kosaricasession as $proizvodi)
			{
				if ($proizvodi!="")
				{
					$proizvod = explode("|", $proizvodi);
					
					$query  = "SELECT * FROM products";
					$query .= " WHERE active='Y' and id=" . $proizvod[0];
					$result = @mysqli_query($MySQL, $query);
					$row = @mysqli_fetch_array($result);
					$rowcount = mysqli_num_rows($result);
				
					if ($rowcount > 0) 
					{	
						$products_title = $row['title'];
						$products_price = number_format($row['price'], 2, ',', ' ');
						$products_pricetotal = $products_pricetotal + ($row['price']*$proizvod[1]);
						$products_pricesubtotal = number_format($row['price']*$proizvod[1], 2, ',', ' ');
?>
          <tr>
            <td>
              <a onclick="return obrisi();" href="index.php?pg=<?php print $pg ?>&act=4&id=<?php print $proizvod[0] ?>"><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button></a>
            </td>
			<td><?php print $products_title ?></td>
            <td><?php print $products_price ?> kn</td>
            <td><?php print $proizvod[1] ?></td>
            <td><?php print $products_pricesubtotal ?> kn</td>
          </tr>
<?php
					}
				}
			}	
?>
        </tbody>
      </table>
	  <div style="text-align:right;font-weight:bold;margin-bottom:5px">Ukupno: <?php print number_format($products_pricetotal, 2, ',', ' '); ?> kn</div>
	  <div class="basket" style="text-align:right"><a href="index.php?pg=10&act=3" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Isprazni košaricu</a></div>
<?php
		}
		else
		{
			$msginfo =  "Vaša košarica je prazna!";
		}
	}
	else
	{
		$msginfo =  "Vaša košarica je prazna!";
	}
}
else
{
	if ($act != 5)
		$msginfo =  "Vaša košarica je prazna!";
}
?>
<hr />
<div>
	<div class="msginfo"><?php print $msginfo ?></div>
   <form action="" id="contact_form" name="contact_form" method="POST">
      <input type="hidden" id="act" name="act" value="5">
      <label for="fname">Ime: *</label>
      <input type="text" id="fname" name="firstname" value="<?php print $user_active_name ?>" placeholder="Vaše ime.." required>
      <label for="lname">Prezime: *</label>
      <input type="text" id="lname" name="lastname" value="<?php print $user_active_lastname ?>" placeholder="Vaše prezime.." required>
      <label for="email">E-mail: *</label>
      <input type="email" id="email" name="email" value="<?php print $user_active_email ?>" placeholder="Vaš e-mail.." required>
      <label for="note">Napomena</label>
      <textarea id="note" name="note" placeholder="Vaša napomena.." style="height:200px"></textarea>
      <input type="submit" class="btn btn-primary btn-lg" <?php ($brojproizvoda == 0 ? print "disabled" : "") ?> value="Naruči">
   </form>
</div>