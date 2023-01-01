<?php

include("provjerimain.php");	

$act = 1;
if(isset($_GET['act'])) { $act = $_GET['act']; }

$h2title = $title;

if ($act == 2)
{
	$h2title = "Vijest";
}

?>
<h2><?php print $h2title ?></h2>
<hr />
<div>
<?php
if ($act == 1)
{
$query  = "SELECT * FROM news";
$query .= " WHERE active='Y'";
$query .= " ORDER BY created_at DESC";
$result = @mysqli_query($MySQL, $query);

while($row = @mysqli_fetch_array($result)) {
	
$news_id = $row['id'];
$news_img = $row['img'];
$news_title = $row['title'];
$news_summary = $row['summary'];
$news_url = "index.php?pg={$pg}&act=2&id={$news_id}";

$news_date = DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at']);
$news_created_at = $news_date->format('d. m. Y H:i:s');

?>
	<div class="vijest">
		<div class="img">
			<img src="vijesti/<?php print $news_img ?>" alt="" title="">
		</div>
		<div class="txt">
			<h2><a href="<?php print $news_url ?>"><?php print $news_title ?></a></h2>
			<?php print $news_summary ?> <a href="<?php print $news_url ?>">Više</a>
			<time><?php print $news_created_at ?></time>
		</div>
		<hr>
	</div>
<?php
}
}
else
{
$id = 1;
if(isset($_GET['id']) && is_numeric($_GET['id'])) { $id = $_GET['id']; }
	
$query  = "SELECT * FROM news";
$query .= " WHERE active='Y' and id=" . $id;
$result = @mysqli_query($MySQL, $query);
$row = @mysqli_fetch_array($result);
$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) 
{
$news_img = $row['img'];
$news_title = $row['title'];
$news_description = $row['description'];

$news_date = DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at']);
$news_created_at = $news_date->format('d. m. Y H:i:s');

?>
	<div class="vijestvise">
		<h2><?php print $news_title ?></h2>
		<div class="img">
			<img src="vijesti/<?php print $news_img ?>" alt="&quot;EGIPATSKI MESSI&quot;, LEGENDA LIVERPOOLA Kako mu je to uspjelo za samo Äetiri mjeseca?" title="&quot;EGIPATSKI MESSI&quot;, LEGENDA LIVERPOOLA Kako mu je to uspjelo za samo Äetiri mjeseca?">
		</div>
		<div class="txt">
			<p>
			<?php print $news_description ?>
			</p>
			<time><?php print $news_created_at ?></time>
		</div>
		<hr>
	</div>
<?php
}
}
?>
</div>