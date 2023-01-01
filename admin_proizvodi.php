<?php

include("provjeriadminprava.php");	

$act = 1;

if(isset($_GET['act'])) { $act = $_GET['act']; }

if(isset($_POST['act'])) { $act = $_POST['act']; }

?>
<?php
if ($act == 1)
{
$query  = "SELECT * FROM products";
$query .= " ORDER BY created_at DESC";
$result = @mysqli_query($MySQL, $query);
?>

    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col" style="width:150px"></th>
            <th scope="col">Naslov</th>
            <th scope="col">Cijena</th>
			<th scope="col">Aktivan</th>
            <th scope="col">Vrijeme kreiranja</th>        
          </tr>
        </thead>
        <tbody>

<?php
while($row = @mysqli_fetch_array($result)) {
	
$products_id = $row['id'];
$products_title = $row['title'];
$products_active = ($row['active'] == 'Y' ? 'DA' : 'NE');
$products_url = "index.php?pg={$pg}&act=2&id={$products_id}";
$product_price = number_format($row['price'], 2, ',', ' ');

$products_date = DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at']);
$products_created_at = $products_date->format('d. m. Y H:i:s');

?>
          <tr>
            <td>
              <a href="index.php?pg=<?php print $pg ?>&act=2&id=<?php print $products_id ?>" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></a>
              <a href="index.php?pg=<?php print $pg ?>&act=3&id=<?php print $products_id ?>" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span></a>
			  <a onclick="return obrisi();" href="index.php?pg=<?php print $pg ?>&act=5&id=<?php print $products_id ?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
            </td>
			<td><?php print $products_title ?></td>
            <td><?php print $product_price ?> kn</td>
            <td><?php print $products_active ?></td>
            <td><?php print $products_created_at ?></td>
          </tr>
<?php
}
?>
        </tbody>
      </table>
	  <a href="index.php?pg=<?php print $pg ?>&act=6" class="btn btn-primary btn-lg">Dodaj novo</a>
<?php
}
else if ($act == 2 && is_numeric($_GET['id']))
{
$query  = "SELECT p.*, u.name u_name FROM products p join users u on p.creator_id=u.id";
$query .= " WHERE p.id=" . $_GET['id'];
$result = @mysqli_query($MySQL, $query);
$row = @mysqli_fetch_array($result);
$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) 
{
$products_id = $row['id'];
$products_img = $row['img'];
$products_title = $row['title'];
$products_description = $row['description'];
$products_price = number_format($row['price'], 2, ',', ' ');
$products_active = ($row['active'] == 'Y' ? 'DA' : 'NE');
$products_date = DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at']);
$products_created_at = $products_date->format('d. m. Y H:i:s');
$products_u_name = $row['u_name'];

$products_updateddate = DateTime::createFromFormat('Y-m-d H:i:s', $row['updated_at']);
$products_updated_at = $products_updateddate->format('d. m. Y H:i:s');
?>
	<div class="details">
	<b>Proizvod:</b><br>
	<label>Id: </label>
	<div><?php print $products_id ?></div>
	<label>Naslov: </label>
	<div><?php print $products_title ?></div>
	<label>Cijena: </label>
	<div><?php print $products_price ?> kn</div>
	<label>Slika: </label>
	<div><img style="max-width:200px;" src="proizvodi/<?php print $products_img ?>" alt="" title=""></div>
	<label>Opširnije: </label>
	<div><?php print $products_description ?></div>
	<label>Aktivan: </label>
	<div><?php print $products_active ?></div>
	<label>Vrijeme kreiranja: </label>
	<div><?php print $products_created_at ?></div>
	<label>Kreirao: </label>
	<div><?php print $products_u_name ?></div>
	<label>Vrijeme zadnjeg ažuriranja: </label>
	<div><?php print $products_updated_at ?></div>
	</div>
<?php
}
else{
	print '<div class="msginfo">Ne postoji odabrani zapis!</div>';
}
}
else if ($act == 3 && is_numeric($_GET['id']))
{
$query  = "SELECT * FROM products";
$query .= " WHERE id=" . $_GET['id'];
$result = @mysqli_query($MySQL, $query);
$row = @mysqli_fetch_array($result);
$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) 
{
$products_id = $row['id'];
$products_img = $row['img'];
$products_title = $row['title'];
$products_description = $row['description'];
$products_active = $row['active'];
//$products_price = number_format($row['price'], 2, ',', ' ');
$products_price = $row['price'];
?>
		<div class="details">
		<b>Proizvod:</b><br>
		<form action="" id="products_form" name="products_form" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="act" name="act" value="4">
			
			<label>Naslov *</label>
			<input type="text" id="title" name="title" value="<?php print $products_title ?>" placeholder="Naslov.." required>
			
			<label>Cijena *</label>
			<input type="text" id="price" name="price" value="<?php print $products_price ?>" placeholder="Naslov.." required>

			<label>Opširnije *</label>
			<textarea id="description" name="description" placeholder="Opširnije.." required rows="10" ><?php print $products_description ?></textarea>
				
			<label>Slika</label>
			<input type="file" id="picture" name="picture">
			<div><img style="max-width:200px;" src="proizvodi/<?php print $products_img ?>" alt="" title=""></div>
				
			<label>Aktivan:</label><br />
            <input type="radio" name="active" value="Y" <?php ($products_active == 'Y' ? print 'checked' : '') ?>> DA &nbsp;&nbsp;
			<input type="radio" name="active" value="N" <?php ($products_active == 'N' ? print 'checked' : '') ?>> NE
			
			<hr>
			
			<input type="submit" class="btn btn-primary btn-lg" value="Izmijeni">
		</form>
		</div>
<?php
}
else{
	print '<div class="msginfo">Ne postoji odabrani zapis!</div>';
}
}
else if ($act == 4)
{
$query  = "SELECT * FROM products";
$query .= " WHERE id=" . $_GET['id'];
$result = @mysqli_query($MySQL, $query);
$row = @mysqli_fetch_array($result);
$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) 
{
$query  = "UPDATE products SET title='" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', price=" . $_POST['price'] . ", description='" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', active='" . $_POST['active'] . "'";
$query .= " WHERE id=" . $_GET['id'];
$query .= " LIMIT 1";
$result = @mysqli_query($MySQL, $query);

$products_id = $_GET['id'];

if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {               
			$ext = strtolower(strrchr($_FILES['picture']['name'], "."));            
			$_picture = (int)$products_id . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'], "proizvodi/".$_picture);	
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') {
				$_query  = "UPDATE products SET img='" . $_picture . "'";
				$_query .= " WHERE id=" . (int)$products_id . " LIMIT 1";
				$_result = @mysqli_query($MySQL, $_query);
				$_SESSION['message'] .= '<p>You successfully added picture.</p>';
			}
        }

print '<div class="msginfo">Ažuriran je zapis id: '. $products_id .'.</div>';		
}
else{
	print '<div class="msginfo">Ne postoji odabrani zapis!</div>';
}
}
else if ($act == 5 && is_numeric($_GET['id']))
{
	$query  = "SELECT * FROM products";
	$query .= " WHERE id=" . $_GET['id'];
	$result = @mysqli_query($MySQL, $query);
	$row = @mysqli_fetch_array($result);
	$rowcount = mysqli_num_rows($result);

	if ($rowcount > 0) 
	{
		$products_id = $row['id'];

		$query  = "SELECT * FROM order_items";
		$query .= " WHERE product_id=" . $_GET['id'];
		$result = @mysqli_query($MySQL, $query);
		$rowcount = mysqli_num_rows($result);
		
		if ($rowcount > 0) 
		{
			print '<div class="msginfo">Ne možete obrisan proizvod id: '. $products_id .'. Postoji narudžba za taj proizvod!</div>';
		}
		else
		{
			$query  = "DELETE FROM products";
			$query .= " WHERE id=" . $_GET['id'];
			$query .= " LIMIT 1";
			$result = @mysqli_query($MySQL, $query);
			
			print '<div class="msginfo">Obrisan je zapis id: '. $products_id .'.</div>';
		}
	}
	else
	{
		print '<div class="msginfo">Ne postoji odabrani zapis!</div>';
	}
}
else if ($act == 6)
{
?>
		<div class="details">
		<b>Proizvod:</b><br>
		<form action="" id="products_form" name="products_form" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="act" name="act" value="7">
			
			<label>Naslov *</label>
			<input type="text" id="title" name="title" placeholder="Naslov.." required>

			<label>Cijena *</label>
			<input type="text" id="price" name="price" placeholder="Naslov.." required>

			<label>Opširnije *</label>
			<textarea id="description" name="description" placeholder="Opširnije.." required rows="10"></textarea>
				
			<label>Slika</label>
			<input type="file" id="picture" name="picture" required>
						
			<label>Aktivan:</label><br />
            <input type="radio" name="active" value="Y" checked> DA &nbsp;&nbsp;
			<input type="radio" name="active" value="N"> NE
			
			<hr>
			
			<input type="submit" class="btn btn-primary btn-lg" value="Dodaj">
		</form>
		</div>
<?php
}
else if ($act == 7)
{
	
$query  = "INSERT INTO products (title, price, description, active, creator_id)";
$query .= " VALUES ('" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', " . $_POST['price'] . ", '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', '" . $_POST['active'] . "', " . $_SESSION['user']['id'] . ")";
$result = @mysqli_query($MySQL, $query);
		
$new_ID = mysqli_insert_id($MySQL);

if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {            
			$ext = strtolower(strrchr($_FILES['picture']['name'], "."));		
            $_picture = $new_ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'], "proizvodi/".$_picture);
			
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') {
				$_query  = "UPDATE products SET img='" . $_picture . "'";
				$_query .= " WHERE id=" . $new_ID . " LIMIT 1";
				$_result = @mysqli_query($MySQL, $_query);
			}
        }

print '<div class="msginfo">Dodan je novi zapis id: '. $new_ID .'.</div>';

}
?>
<?php
if ($act != 1)
{
?>	
<div style="margin-top:20px;padding-left:15px"><a href="index.php?pg=<?php print $pg ?>&act=1">Natrag</a></div>
<?php
}
?>