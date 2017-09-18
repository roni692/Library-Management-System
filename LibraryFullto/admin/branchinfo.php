<?php include "header.html";?>
<!--<div id="menu"> -->
<?php include "checklogin.html";?>
</div>
<div id="section">
 <?php
 $status =0;
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
				$name="";
				$address = "";
				$nameErr ="";
				$addressErr = "";
								if(isset($_GET['counter'])){
								echo "<span class='error'>Branch has been added.</span>";}
								/*$sql = "select * from branches";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
									echo '<table style="width:50%" border="1">';
									echo '<tr><td>Branch Name</td><td>Branch Address</td></tr>';
								while($row = $result->fetch_assoc()){
									echo '<tr><td>'.$row["Bname"].'</td><td>'.$row["Blocation"].'</td></tr>';
								}
									echo '</table>';
								}
								}
								else{
								$sql = "select * from branches";
								$result = $conn->query($sql);
								if ($result -> num_rows > 0) {
									echo '<div id="created"><table style="width:50%" border="1">';
									echo '<tr><td>Branch Name</td><td>Branch Address</td></tr>';
								while($row = $result->fetch_assoc()){
									echo '<tr><td>'.$row["Bname"].'</td><td>'.$row["Blocation"].'</td></tr>';
								}
									echo '</table></div>';
								}
								}*/
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					if (empty($_POST["name"])) {
						$nameErr = "Branch Name is required";
					} else {
						$name = test_input($_POST["name"]);
						// check if name only contains letters and whitespace
						if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
							$nameErr = "Only letters and white space are allowed"; 
						}
					}
					if(empty($_POST['address'])){
						$addressErr = "Branch Address is required.";
					} else{
						$address = test_input($_POST["address"]);
						// check if name only contains letters and whitespace
						if (!preg_match("/^[a-zA-Z0-9 ]*$/",$address)) {
							$nameErr = "Only letters and numbers and white space are allowed"; 
						}
					}
					if($nameErr == null && $addressErr == null){
						if($name != null && $address != null){
							$sql = "insert into branches(Bname,Blocation) values ('".$name."','".$address."')";
							$result= $conn->query($sql);
							if ($result === TRUE){
								header('location:branchinfo.php?counter=1');
							}else if(mysqli_errno($conn) == '1062'){
								echo "<span class='error'>Branch already exist.</span>";
							}else {
								echo "<span class='error'>Database Error.Could not Add.</span>";
							}
						}
					}
				}	
?>

<form id="create" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">
        <tr bgcolor="#CCCCCC">
          <th colspan="2"> BRANCH INFORMATION</th>
        </tr>
		<tr> <td> Branch Name: </td>
				<td><input type="text" name="name" class="txt_form"></td><span class="error"><?php echo $nameErr;?></span></tr>
<tr> <td> Branch Address: </td>
<td> <input type="text" name="address" class="txt_form"></td><span class="error"> <?php echo $addressErr;?></span></tr>
<tr> <td colspan="2" align="center">
<input type="submit" name="Submit" value="Submit"></td>
</tr>
</table>
</form>
<?php
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