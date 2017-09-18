<?php include "header.html"?>
 
<div id="section">
<ul id="menu">
	<table width="100%">
  <tr align="center" colspan="2" style="color:#C60001; font-weight:bolder;"> <td align="center" bgcolor="#99CC99"> <a href="reader.php" class="menu_font"> READER </a></td>
		
		<td align="center" bgcolor="#99CC99"> <a href="aboutus.php" class="menu_font"> ABOUT US </a></td>
		<td align="center" bgcolor="#99CC99"> <a href="contactus1.php" class="menu_font"> CONTACT US </a></td>
	</tr>
	</table>
</ul>

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
$phoneno="";
$phonenoErr="";
if(isset($_POST['Register']))
{
	if (empty($_POST["Name"]))
	{
		$nameErr = "Reader Name is required";
	} 
	else 
	{
		$name = test_input($_POST["Name"]);
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
	if($_POST['phoneno'] != null)
	{
		$phoneno = test_input($_POST["phoneno"]);
		if (!preg_match("/^[0-9 ]*$/",$phoneno) && strlen($phoneno) != 10)
		{
			$phonenoErr = "Invalid Number.";
		}
		
	} 
	if($nameErr == null && $addressErr == null && $phonenoErr == null)
	{
		if($name != null && $address != null && $phoneno != null)
		{
			$sql = "insert into reader (Name,Address,Phoneno) values ('".$name."','".$address."','".$phoneno."')";
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
}
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/main.css"/>
<script type="text/javascript" src="/css/main.js"></script>
</script>
</head>
<body>
<div id="section">
<form action="" method="post" name="frm2" enctype="multipart/form-data" onsubmit="return a();">
      <table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">
        <tr bgcolor="#CCCCCC">
          <th colspan="2"> Reader Registration Form</th>
        </tr>

  <tr>
    <td>Reader Name : </td>
    <td><input type="text" name="Name" id="Name" class="txt_form" /><?php error_reporting(E_ALL ^ E_NOTICE); echo $nameErr;?></td>
  </tr>
  <tr>
    <td>Address :</td>
    <td><textarea name="address" id="address"  class="txt_form" ><?php echo $addressErr;?></textarea></td>
  </tr>
  
    
  <tr>
    <td>Contact No. :</td>
    <td><input type="text" name="Phoneno" id="Phoneno" class="txt_form"/></td><?php echo $phoneErr;?>
  </tr>
  
  <tr>
    <td colspan="2" align="center"><input type="submit" name="register" value="Register" />
      <input type="reset" name="Back" value="Back" /></td>
   
</table>
</form>
</div>

</div>
<div id="footer">
  <?php include('footer.php'); ?>
</div>
</body>
</html>

