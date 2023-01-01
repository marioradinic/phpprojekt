<?php

include("provjeriadminprava.php");	

$act = 1;

if(isset($_GET['act'])) { $act = $_GET['act']; }

if(isset($_POST['act'])) { $act = $_POST['act']; }

?>
<?php
if ($act == 1)
{
$query  = "SELECT * FROM news";
$query .= " ORDER BY created_at DESC";
$result = @mysqli_query($MySQL, $query);
?>

    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col" style="width:150px"></th>
            <th scope="col">Naslov</th>
            <th scope="col">Aktivan</th>
            <th scope="col">Vrijeme kreiranja</th>        
          </tr>
        </thead>
        <tbody>

<?php
while($row = @mysqli_fetch_array($result)) {
	
$news_id = $row['id'];
$news_title = $row['title'];
$news_active = ($row['active'] == 'Y' ? 'DA' : 'NE');
$news_url = "index.php?pg={$pg}&act=2&id={$news_id}";

$news_date = DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at']);
$news_created_at = $news_date->format('d. m. Y H:i:s');

?>
          <tr>
            <td>
              <a href="index.php?pg=<?php print $pg ?>&act=2&id=<?php print $news_id ?>" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></a>
              <a href="index.php?pg=<?php print $pg ?>&act=3&id=<?php print $news_id ?>" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span></a>
			  <a onclick="return obrisi();" href="index.php?pg=<?php print $pg ?>&act=5&id=<?php print $news_id ?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
            </td>
			<td><?php print $news_title ?></td>
            <td><?php print $news_active ?></td>
            <td><?php print $news_created_at ?></td>
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
$query  = "SELECT n.*, u.name u_name FROM news n join users u on n.creator_id=u.id";
$query .= " WHERE n.id=" . $_GET['id'];
$result = @mysqli_query($MySQL, $query);
$row = @mysqli_fetch_array($result);
$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) 
{
$news_id = $row['id'];
$news_img = $row['img'];
$news_title = $row['title'];
$news_summary = $row['summary'];
$news_description = $row['description'];
$news_active = ($row['active'] == 'Y' ? 'DA' : 'NE');
$news_date = DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at']);
$news_created_at = $news_date->format('d. m. Y H:i:s');
$news_u_name = $row['u_name'];

$news_updateddate = DateTime::createFromFormat('Y-m-d H:i:s', $row['updated_at']);
$news_updated_at = $news_updateddate->format('d. m. Y H:i:s');
?>
	<div class="details">
	<b>Vijest:</b><br>
	<label>Id: </label>
	<div><?php print $news_id ?></div>
	<label>Naslov: </label>
	<div><?php print $news_title ?></div>
	<label>Slika: </label>
	<div><img style="max-width:200px;" src="vijesti/<?php print $news_img ?>" alt="" title=""></div>
	<label>Sažetak: </label>
	<div><?php print $news_summary ?></div>
	<label>Opširnije: </label>
	<div><?php print $news_description ?></div>
	<label>Aktivan: </label>
	<div><?php print $news_active ?></div>
	<label>Vrijeme kreiranja: </label>
	<div><?php print $news_created_at ?></div>
	<label>Kreirao: </label>
	<div><?php print $news_u_name ?></div>
	<label>Vrijeme zadnjeg ažuriranja: </label>
	<div><?php print $news_updated_at ?></div>
	</div>
<?php
}
else{
	print '<div class="msginfo">Ne postoji odabrani zapis!</div>';
}
}
else if ($act == 3 && is_numeric($_GET['id']))
{
$query  = "SELECT * FROM news";
$query .= " WHERE id=" . $_GET['id'];
$result = @mysqli_query($MySQL, $query);
$row = @mysqli_fetch_array($result);
$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) 
{
$news_id = $row['id'];
$news_img = $row['img'];
$news_title = $row['title'];
$news_summary = $row['summary'];
$news_description = $row['description'];
$news_active = $row['active'];
?>
		<div class="details">
		<b>Vijest:</b><br>
		<form action="" id="news_form" name="news_form" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="act" name="act" value="4">
			
			<label>Naslov *</label>
			<input type="text" id="title" name="title" value="<?php print $news_title ?>" placeholder="Naslov.." required>

			<label>Sažetak *</label>
			<textarea id="summary" name="summary" placeholder="Sažetak.." required rows="10"><?php print $news_summary ?></textarea>
			
			<label>Opširnije *</label>
			<textarea id="description" name="description" placeholder="Opširnije.." required rows="10"><?php print $news_description ?></textarea>
				
			<label>Slika</label>
			<input type="file" id="picture" name="picture">
			<div><img style="max-width:200px;" src="vijesti/<?php print $news_img ?>" alt="" title=""></div>
				
			<label>Aktivan:</label><br />
            <input type="radio" name="active" value="Y" <?php ($news_active == 'Y' ? print 'checked' : '') ?>> DA &nbsp;&nbsp;
			<input type="radio" name="active" value="N" <?php ($news_active == 'N' ? print 'checked' : '') ?>> NE
			
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
$query  = "SELECT * FROM news";
$query .= " WHERE id=" . $_GET['id'];
$result = @mysqli_query($MySQL, $query);
$row = @mysqli_fetch_array($result);
$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) 
{
$query  = "UPDATE news SET title='" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', summary='" . htmlspecialchars($_POST['summary'], ENT_QUOTES) . "', description='" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', active='" . $_POST['active'] . "'";
$query .= " WHERE id=" . $_GET['id'];
$query .= " LIMIT 1";
$result = @mysqli_query($MySQL, $query);

$news_id = $_GET['id'];

if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {               
			$ext = strtolower(strrchr($_FILES['picture']['name'], "."));            
			$_picture = (int)$news_id . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'], "vijesti/".$_picture);	
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') {
				$_query  = "UPDATE news SET img='" . $_picture . "'";
				$_query .= " WHERE id=" . (int)$news_id . " LIMIT 1";
				$_result = @mysqli_query($MySQL, $_query);
				$_SESSION['message'] .= '<p>You successfully added picture.</p>';
			}
        }

print '<div class="msginfo">Ažuriran je zapis id: '. $news_id .'.</div>';		
}
else{
	print '<div class="msginfo">Ne postoji odabrani zapis!</div>';
}
}
else if ($act == 5 && is_numeric($_GET['id']))
{
$query  = "SELECT * FROM news";
$query .= " WHERE id=" . $_GET['id'];
$result = @mysqli_query($MySQL, $query);
$row = @mysqli_fetch_array($result);
$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) 
{
$news_id = $row['id'];

$query  = "DELETE FROM news";
$query .= " WHERE id=" . $_GET['id'];
$query .= " LIMIT 1";
$result = @mysqli_query($MySQL, $query);
	
print '<div class="msginfo">Obrisan je zapis id: '. $news_id .'.</div>';
}
else{
	print '<div class="msginfo">Ne postoji odabrani zapis!</div>';
}
}
else if ($act == 6)
{
?>
		<div class="details">
		<b>Vijest:</b><br>
		<form action="" id="news_form" name="news_form" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="act" name="act" value="7">
			
			<label>Naslov *</label>
			<input type="text" id="title" name="title" placeholder="Naslov.." required>

			<label>Sažetak *</label>
			<textarea id="summary" name="summary" placeholder="Sažetak.." required rows="10"></textarea>
			
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
	
$query  = "INSERT INTO news (title, summary, description, active, creator_id)";
$query .= " VALUES ('" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', '" . htmlspecialchars($_POST['summary'], ENT_QUOTES) . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', '" . $_POST['active'] . "', " . $_SESSION['user']['id'] . ")";
$result = @mysqli_query($MySQL, $query);
		
$new_ID = mysqli_insert_id($MySQL);

if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {            
			$ext = strtolower(strrchr($_FILES['picture']['name'], "."));		
            $_picture = $new_ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'], "vijesti/".$_picture);
			
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') {
				$_query  = "UPDATE news SET img='" . $_picture . "'";
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