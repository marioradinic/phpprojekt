<?php

include("provjeriadminprava.php");	

$act = 1;

if(isset($_GET['act'])) { $act = $_GET['act']; }

if(isset($_POST['act'])) { $act = $_POST['act']; }

?>
<?php
if ($act == 1)
{
$query  = "SELECT * FROM orders";
$query .= " ORDER BY created_at DESC";
$result = @mysqli_query($MySQL, $query);
?>

    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col" style="width:50px"></th>
            <th scope="col">Ime</th>
			<th scope="col">Prezime</th>
            <th scope="col">E-mail</th>
            <th scope="col">Vrijeme kreiranja</th>        
          </tr>
        </thead>
        <tbody>

<?php
while($row = @mysqli_fetch_array($result)) {
	
$orders_id = $row['id'];
$orders_name= $row['name'];
$orders_lastname = $row['lastname'];
$orders_email = $row['email'];

$orders_date = DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at']);
$orders_created_at = $orders_date->format('d. m. Y H:i:s');

?>
          <tr>
            <td>
              <a href="index.php?pg=<?php print $pg ?>&act=2&id=<?php print $orders_id ?>" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></a>
			</td>
			<td><?php print $orders_name ?></td>
            <td><?php print $orders_lastname ?></td>
			<td><?php print $orders_email ?></td>
            <td><?php print $orders_created_at ?></td>
          </tr>
<?php
}
?>
        </tbody>
      </table>
<?php
}
else if ($act == 2 && is_numeric($_GET['id']))
{
	$query  = "SELECT * FROM orders";
	$query .= " WHERE id=" . $_GET['id'];
	$result = @mysqli_query($MySQL, $query);
	$row = @mysqli_fetch_array($result);
	$rowcount = mysqli_num_rows($result);

	if ($rowcount > 0) 
	{
		$orders_id = $row['id'];
		$orders_name= $row['name'];
		$orders_lastname = $row['lastname'];
		$orders_email = $row['email'];
		$orders_note = $row['note'];
		
		$orders_date = DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at']);
		$orders_created_at = $orders_date->format('d. m. Y H:i:s');
?>
	<div class="details">
	<b>Narudžba:</b><br>
	<label>Id: </label>
	<div><?php print $orders_id ?></div>
	<label>Ime: </label>
	<div><?php print $orders_name ?></div>
	<label>Prezime: </label>
	<div><?php print $orders_lastname ?></div>
	<label>Email: </label>
	<div><?php print $orders_email ?></div>
	<label>Napomena:</label>
	<label><?php print $orders_note ?></label>
	<label>Vrijeme kreiranja: </label>
	<div><?php print $orders_created_at ?></div>
	</div>
	<hr />
<h4>Stavke narudžbe:</h4>
<hr />
	<table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Proizvod</th>
            <th scope="col">Cijena</th>
			<th scope="col">Količina</th>
            <th scope="col">Ukupno</th>        
          </tr>
        </thead>
        <tbody>
<?php
		$query  = "SELECT o.*, p.title, p.price FROM order_items o join products p on o.product_id=p.id";
		$query .= " WHERE order_id=" . $_GET['id'];
		$result = @mysqli_query($MySQL, $query);
	
		$products_pricetotal = 0;
		while($row = @mysqli_fetch_array($result)) 
		{
			$product_title = $row['title'];
			$product_price = number_format($row['price'], 2, ',', ' ');
			$quantity = $row['quantity'];
			$products_pricetotal = $products_pricetotal + ($row['price']*$quantity);
			$products_pricesubtotal = number_format($row['price']*$quantity, 2, ',', ' ');
?>
          <tr>
			<td><?php print $product_title ?></td>
            <td><?php print $product_price ?> kn</td>
            <td><?php print $quantity ?></td>
            <td><?php print $products_pricesubtotal ?> kn</td>
          </tr>
<?php
		}
?>
        </tbody>
      </table>
	  <div style="text-align:right;font-weight:bold;margin-bottom:5px">Ukupno: <?php print number_format($products_pricetotal, 2, ',', ' '); ?> kn</div>
<?php	
	}
	else
	{
		print '<div class="msginfo">Ne postoji odabrani zapis!</div>';
	}
}
if ($act != 1)
{
?>	
<div style="margin-top:20px;padding-left:15px"><a href="index.php?pg=<?php print $pg ?>&act=1">Natrag</a></div>
<?php
}
?>