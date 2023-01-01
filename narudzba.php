<?php

include("provjerimain.php");

$msginfo =  "";

?>
<h2><?php print $title ?></h2>
<hr />
<?php
$brojproizvoda = 0;
if (isset($_SESSION['order_id']))
{
	$order_id = $_SESSION['order_id'];
	
	$query  = "SELECT * FROM orders";
	$query .= " WHERE id=" . $order_id;
	$result = @mysqli_query($MySQL, $query);
	$row = @mysqli_fetch_array($result);
	$rowcount = mysqli_num_rows($result);
				
	if ($rowcount > 0) 
	{
		$msginfo = "Vaša narudžba je zaprimljena!";
		$order_date = DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at']);
		$order_created_at = $order_date->format('d. m. Y H:i:s');
?>
<div>
	<div class="msginfo"><?php print $msginfo ?></div>
	<label>Ime:</label>
	<label><?php print $row['name'] ?></label>
	<label>Prezime:</label>
	<label><?php print $row['lastname'] ?></label>
	<label>E-mail:</label>
	<label><?php print $row['email'] ?></label>
	<label>Napomena:</label>
	<label><?php print $row['note'] ?></label>
	<label>Vrijeme kreiranja:</label>
	<label><?php print $order_created_at ?></label>
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
		$query .= " WHERE order_id=" . $order_id;
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
	unset($_SESSION['order_id']);
}
else
{
	$msginfo =  "Narudžba ne postoji!";
?>	
	<div>
		<div class="msginfo"><?php print $msginfo ?></div>
	</div>
<?php
}	
?>	
