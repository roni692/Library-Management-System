<?php include "header.html";?>
<?php include "checklogin.html";?>
</div>
<div id="section">
 <?php
 include_once 'db_connect_inc.php';
 if(isset($_SESSION['username']))
{
 $admin = $_SESSION['username'];
}else
{
	$admin = null;
}
if($admin != null)
{
 ?>
 
<?php
error_reporting(E_ALL ^ E_NOTICE);
$name ="";
$address = "";
$nameErr = "";
$addressErr = "";
if(isset($_GET['counter'])){
								echo "<span class='error'>New record created successfully</span>";
								$sql = "select * from publisher";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
									echo '<table style="width:50%" border="1">';
									echo '<tr><td>Publisher Name</td><td>Publisher Address</td></tr>';
								while($row = $result->fetch_assoc()){
									echo '<tr><td>'.$row["pname"].'</td><td>'.$row["paddress"].'</td></tr>';
								}
									echo '</table><br/><br/>';
								}
								}
if(isset($_POST['Submit'])){
if (empty($_POST["name"])) {
    $nameErr = "Publisher Name is required";
  } else {
    $name = test_input($_POST["name"]);
	// check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z0-9 ]*$/",$name)) {
       $nameErr = "Only letters, numbers and white space allowed"; 
     }
  }
  if(empty($_POST["address"])){
  $addressErr = "Publisher Address is required";
  }else{
  $address = test_input($_POST["address"]);
  if (!preg_match("/^[a-zA-Z0-9 ]*$/",$address)) {
       $addressErr = "Only letters, numbers and white space allowed"; 
     }
  }
  }
  if($nameErr == null && $addressErr == null)
{
	if($name != null && $address != null)
	{
		$sql = "insert into publisher (Pname,Paddress)values ('".$name."','". $address."')";
		if ($conn->query($sql) === TRUE) {
			echo "<span class='error'>New record created successfully</span>";
				header('location:addpublisher.php?counter=1');
		} else {
			echo "<span class='error'>Error: ". $conn->error. "</span>";
		}

$conn->close();
	}
}
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">
        <tr bgcolor="#CCCCCC">
          <th colspan="2"> ADD PUBLISHER</th>
        </tr>
<tr> <td> Publisher Name: </td>
<td><input type="text" name="name" class="txt_form"></td><span class="error"> <?php echo $nameErr;?></span></tr>
<tr><td> Publisher Address: </td>
<td><input type="text" name="address" class="txt_form"></td><span class="error"> <?php echo $addressErr;?></span> </tr>
<tr> <td colspan="2" align="center">
<input type="submit" name="Submit" value="Submit"></td> </tr>
</table>
</form><?php
}
else
{
echo "<p><span class='error'>Please Login.</span></p>";
}
?>
</div>
<?php include "footer.php";?>
</body>
</html>