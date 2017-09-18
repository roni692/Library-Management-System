<?php include "header.html"?>
 
<div id="section">
<ul id="menu">
	<table width="100%">
  <tr align="center" colspan="2" style="color:#C60001; font-weight:bolder;"> <td align="center" bgcolor="#99CC99"> <a href="reader.php" class="menu_font"> READER </a></td>
		<td align="center" bgcolor="#99CC99"> <a href="location.php" class="menu_font"> LOCATIONS </a></td>
		<td align="center" bgcolor="#99CC99"> <a href="aboutus.php" class="menu_font"> ABOUT US </a></td>
		<td align="center" bgcolor="#99CC99"> <a href="contactus1.php" class="menu_font"> CONTACT US </a></td>
	</tr>
	</table>
</ul>

<div id="section">
 <?php
 include_once 'db_connect_inc.php';
 if(isset($_SESSION['readerid']))
{
 $reader = $_SESSION['readerid'];
}else
{
	$reader = null;
}
if($reader != null)
{
 ?>
 
<?php
$name ="";
$address = "";
$nameErr = "";
$addressErr = "";
$phone="";
$phoneErr="";
if(isset($_POST['Submit']))
{
	if (empty($_POST["name"]))
	{
		$nameErr = "Reader Name is required";
	} 
	else 
	{
		$name = test_input($_POST["name"]);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z0-9 ]*$/",$name)) 
		{
			$nameErr = "Only letters, numbers and white space allowed"; 
		}
	}
	if(empty($_POST["address"]))
	{
		$addressErr = "Reader Address is required";
	}
	else
	{
		$address = test_input($_POST["address"]);
		if (!preg_match("/^[a-zA-Z0-9 ]*$/",$address))
		{
			$addressErr = "Only letters, numbers and white space allowed"; 
		}
	}
	if($_POST['phone'] != null)
	{
		$phone = test_input($_POST["phone"]);
		if (!preg_match("/^[0-9 ]*$/",$phone) && strlen($phone) != 10)
		{
			$phoneErr = "Invalid Number.";
		}
		
	} 
	if($nameErr == null && $addressErr == null && $phoneErr == null)
	{
		if($name != null && $address != null && $phone != null)
		{
			$sql = "insert into reader (Name,Address,Phoneno) values ('".$name."','".$address."','".$phone."')";
			if ($conn->query($sql) === TRUE)
			{
				echo "<span class='error'>New record created successfully</span>";
				//header('location:addpublisher.php?counter=1');
			} 
			else 
			{
			echo "<span class='error'>Error: ". $conn->error. "</span>";
			}
		}
	}
  }
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">
        <tr bgcolor="#CCCCCC">
          <th colspan="2"> ADD READER</th>
        </tr>
		<tr> <td> Reader Name: </td>
		   <td>	<input type="text" name="name" class="txt_form"></td><span class="error"> <?php echo $nameErr;?></span></tr>
<tr> <td> Reader Address: </td>
<td> <input type="text" name="address" class="txt_form"></td><span class="error"> <?php echo $addressErr;?></span></tr>
<tr> <td>
Reader Phone number: </td> <td><input type="number" name="phone" class="txt_form"></td><span class="error"><?php echo $phoneErr;?></span></tr>
<tr> <td colspan="2" align="center">
<input type="submit" name="Submit" value="Submit"></td></tr></table>
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