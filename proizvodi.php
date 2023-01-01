<?php

include("provjerimain.php");

$act = 1;
if(isset($_GET['act'])) { $act = $_GET['act']; }

$h2title = $title;
$divclass = "proizvodi";

if ($act == 2)
{
	$h2title = "Proizvod";
	$divclass = "";
}

?>
<h2><?php print $h2title ?></h2>
<hr />
<div class="<?php print $divclass ?>">
<?php
if ($act == 1)
{
$query  = "SELECT * FROM products";
$query .= " WHERE active='Y'";
$query .= " ORDER BY created_at DESC";
$result = @mysqli_query($MySQL, $query);

while($row = @mysqli_fetch_array($result)) {
	
$product_id = $row['id'];
$product_img = $row['img'];
$product_title = $row['title'];
$product_url = "index.php?pg={$pg}&act=2&id={$product_id}";
$product_price = number_format($row['price'], 2, ',', ' ');

?>
	<div class="pr">
		<div class="prin">
			<div class="thumb">
				<a href="<?php print $product_url ?>"><img src="proizvodi/<?php print $product_img ?>" alt="" title=""></a>
			</div>
			<div class="title"><a href="<?php print $product_url ?>"><?php print $product_title ?></a></div>
			<div class="price"><?php print $product_price ?> kn</div>
			<div class="basket"><a href="index.php?pg=10&act=2&id=<?php print $product_id ?>" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-shopping-cart"></span> Kupi</a></div>
		</div>
	</div>
<?php
}
}
else
{
$id = 1;
if(isset($_GET['id']) && is_numeric($_GET['id'])) { $id = $_GET['id']; }
	
$query  = "SELECT * FROM products";
$query .= " WHERE active='Y' and id=" . $id;
$result = @mysqli_query($MySQL, $query);
$row = @mysqli_fetch_array($result);
$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) 
{
$product_id = $row['id'];
$product_img = $row['img'];
$product_title = $row['title'];
$product_description = $row['description'];
$product_price = number_format($row['price'], 2, ',', ' ');

?>
	<div class="proizvodvise">
		<h2><?php print $product_title ?></h2>
		<div class="img">
			<img src="proizvodi/<?php print $product_img ?>" alt="" title="">
		</div>
		<div class="txt">
			<p>
			<?php print $product_description ?>
			</p>
			<div class="price">Cijena: <?php print $product_price ?> kn</div>
			<div class="basket"><a href="index.php?pg=10&act=2&id=<?php print $product_id ?>" class="btn btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span> Kupi&nbsp;&nbsp;&nbsp;</a></div>
		</div>
		<hr>
	</div>
<?php
}
}
?>
</div>