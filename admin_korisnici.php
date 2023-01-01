<?php

include("provjeriadminprava.php");	

$act = 1;

if(isset($_GET['act'])) { $act = $_GET['act']; }

if(isset($_POST['act'])) { $act = $_POST['act']; }

?>
<?php
if ($act == 1)
{
$query  = "SELECT * FROM users";
$query .= " ORDER BY created_at DESC";
$result = @mysqli_query($MySQL, $query);
?>

    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col" style="width:150px"></th>
            <th scope="col">Ime</th>
			<th scope="col">Prezime</th>
            <th scope="col">Korisničko ime</th>
			<th scope="col">Aktivan</th>
			<th scope="col">Admin</th>
			<th scope="col">Superadmin</th>
            <th scope="col">Vrijeme kreiranja</th>        
          </tr>
        </thead>
        <tbody>

<?php
while($row = @mysqli_fetch_array($result)) {
	
$users_id = $row['id'];
$users_name= $row['name'];
$users_lastname = $row['lastname'];
$users_username = $row['username'];
$users_active = ($row['isactive'] == 'Y' ? 'DA' : 'NE');
$users_admin = ($row['isadmin'] == 'Y' ? 'DA' : 'NE');
$users_superadmin = ($row['issuperadmin'] == 'Y' ? 'DA' : 'NE');
$users_url = "index.php?pg={$pg}&act=2&id={$users_id}";

$users_date = DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at']);
$users_created_at = $users_date->format('d. m. Y H:i:s');

?>
          <tr>
            <td>
              <a href="index.php?pg=<?php print $pg ?>&act=2&id=<?php print $users_id ?>" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></a>
              <a href="index.php?pg=<?php print $pg ?>&act=3&id=<?php print $users_id ?>" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span></a>
			  <a onclick="return obrisi();" href="index.php?pg=<?php print $pg ?>&act=5&id=<?php print $users_id ?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
            </td>
			<td><?php print $users_name ?></td>
            <td><?php print $users_lastname ?></td>
			<td><?php print $users_username ?></td>
			<td><?php print $users_active ?></td>
            <td><?php print $users_admin ?></td>
            <td><?php print $users_superadmin ?></td>
            <td><?php print $users_created_at ?></td>
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
$query  = "SELECT u.*, c.name c_name FROM users u join countries c on u.country_id=c.id";
$query .= " WHERE u.id=" . $_GET['id'];
$result = @mysqli_query($MySQL, $query);
$row = @mysqli_fetch_array($result);
$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) 
{
$users_id = $row['id'];
$users_name= $row['name'];
$users_lastname = $row['lastname'];
$users_email = $row['email'];
$users_username = $row['username'];
$users_active = ($row['isactive'] == 'Y' ? 'DA' : 'NE');
$users_admin = ($row['isadmin'] == 'Y' ? 'DA' : 'NE');
$users_superadmin = ($row['issuperadmin'] == 'Y' ? 'DA' : 'NE');
$users_c_name = $row['c_name'];
$users_date = DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at']);
$users_created_at = $users_date->format('d. m. Y H:i:s');

$users_updateddate = DateTime::createFromFormat('Y-m-d H:i:s', $row['updated_at']);
$users_updated_at = $users_updateddate->format('d. m. Y H:i:s');
?>
	<div class="details">
	<b>Korisnik:</b><br>
	<label>Id: </label>
	<div><?php print $users_id ?></div>
	<label>Ime: </label>
	<div><?php print $users_name ?></div>
	<label>Prezime: </label>
	<div><?php print $users_lastname ?></div>
	<label>Email: </label>
	<div><?php print $users_email ?></div>
	<label>Korisničko ime: </label>
	<div><?php print $users_username ?></div>
	<label>Država: </label>
	<div><?php print $users_c_name ?></div>
	<label>Aktivan: </label>
	<div><?php print $users_active ?></div>
	<label>Admin: </label>
	<div><?php print $users_admin ?></div>
	<label>Superadmin: </label>
	<div><?php print $users_superadmin ?></div>
	<label>Vrijeme kreiranja: </label>
	<div><?php print $users_created_at ?></div>
	<label>Vrijeme zadnjeg ažuriranja: </label>
	<div><?php print $users_updated_at ?></div>
	</div>
<?php
}
else{
	print '<div class="msginfo">Ne postoji odabrani zapis!</div>';
}
}
else if ($act == 3 && is_numeric($_GET['id']))
{
$query  = "SELECT * FROM users";
$query .= " WHERE id=" . $_GET['id'];
$result = @mysqli_query($MySQL, $query);
$row = @mysqli_fetch_array($result);
$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) 
{
$users_id = $row['id'];
$users_name= $row['name'];
$users_lastname = $row['lastname'];
$users_email = $row['email'];
$users_active = $row['isactive'];
$users_admin = $row['isadmin'];
$users_superadmin = $row['issuperadmin'];
$users_iscurrent = ($row['id'] == $_SESSION['user']['id'] ? 'Y' : 'N');
?>
		<div class="details">
		<b>Korisnik:</b><br>
		<form action="" id="users_form" name="users_form" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="act" name="act" value="4">
			
			<label>Ime *</label>
			<input type="text" id="name" name="name" value="<?php print $users_name ?>" placeholder="Ime.." required>
			
			<label>Prezime *</label>
			<input type="text" id="lastname" name="lastname" value="<?php print $users_lastname ?>" placeholder="Prezime.." required>
			
			<label>Email *</label>
			<input type="text" id="email" name="email" value="<?php print $users_email ?>" placeholder="Email.." required>
			
			<label>Aktivan:</label>
            <input type="radio" <?php ($users_superadmin == 'Y' || $users_iscurrent == 'Y' ? print 'disabled' : '') ?> name="active" value="Y" <?php ($users_active == 'Y' ? print 'checked' : '') ?>> DA &nbsp;&nbsp;
			<input type="radio" <?php ($users_superadmin == 'Y' || $users_iscurrent == 'Y' ? print 'disabled' : '') ?> name="active" value="N" <?php ($users_active == 'N' ? print 'checked' : '') ?>> NE
			
			<label>Admin:</label>
            <input type="radio" <?php ($users_superadmin == 'Y' || $users_iscurrent == 'Y' ? print 'disabled' : '') ?> name="admin" value="Y" <?php ($users_admin == 'Y' ? print 'checked' : '') ?>> DA &nbsp;&nbsp;
			<input type="radio" <?php ($users_superadmin == 'Y' || $users_iscurrent == 'Y' ? print 'disabled' : '') ?> name="admin" value="N" <?php ($users_admin == 'N' ? print 'checked' : '') ?>> NE
			
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
$query  = "SELECT * FROM users";
$query .= " WHERE id=" . $_GET['id'];
$result = @mysqli_query($MySQL, $query);
$row = @mysqli_fetch_array($result);
$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) 
{
$users_superadmin = $row['issuperadmin'];
$users_iscurrent = ($row['id'] == $_SESSION['user']['id'] ? 'Y' : 'N');

$query  = "UPDATE users SET name='" . $_POST['name'] . "', lastname='" . $_POST['lastname'] . "', email='" . $_POST['email'] . "'";
$query .= " WHERE id=" . $_GET['id'];
$query .= " LIMIT 1";
$result = @mysqli_query($MySQL, $query);

if ($users_superadmin == 'N' && $users_iscurrent == 'N')
{
	$query  = "UPDATE users SET isactive='" . $_POST['active'] . "', isadmin='" . $_POST['admin'] . "'";
	$query .= " WHERE id=" . $_GET['id'];
	$query .= " LIMIT 1";
	$result = @mysqli_query($MySQL, $query);
}

$users_id = $_GET['id'];

print '<div class="msginfo">Ažuriran je zapis id: '. $users_id .'.</div>';		
}
else{
	print '<div class="msginfo">Ne postoji odabrani zapis!</div>';
}
}
else if ($act == 5 && is_numeric($_GET['id']))
{
$query  = "SELECT * FROM users";
$query .= " WHERE id=" . $_GET['id'];
$result = @mysqli_query($MySQL, $query);
$row = @mysqli_fetch_array($result);
$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) 
{
$users_id = $row['id'];
$users_superadmin = $row['issuperadmin'];
$users_iscurrent = ($row['id'] == $_SESSION['user']['id'] ? 'Y' : 'N');

if ($users_superadmin == 'N' && $users_iscurrent == 'N')
{
	$query  = "DELETE FROM users";
	$query .= " WHERE id=" . $_GET['id'];
	$query .= " LIMIT 1";
	$result = @mysqli_query($MySQL, $query);
	print '<div class="msginfo">Obrisan je zapis id: '. $users_id .'.</div>';
}
else
{
	print '<div class="msginfo">Nemože se obrisati odabrani zapis.</div>';
}
}
else{
	print '<div class="msginfo">Ne postoji odabrani zapis!</div>';
}
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