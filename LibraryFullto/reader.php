<?php include "header.html"?>
 
<div id="section">
<!--<ul id="menu"> -->
	<table>
  <tr align="center" colspan="2" style="color:#C60001; font-weight:bolder;"> <td align="center" bgcolor="#99CC99"> <a href="reader.php" class="menu_font"> READER </a></td>
		<td align="center" bgcolor="#99CC99"> <a href="contactus1.php" class="menu_font"> CONTACT US </a></td>
	</tr>
	</table>
</ul>
<?php
include_once 'db_connect_inc.php';
$ReaderidErr='';
if(isset($_POST['Submit']))
{
	if(empty($_POST['Readerid']))
	{
		$ReaderidErr = "Please enter reader ID";
	}
	else
	{ 
		$Readerid = $_POST['Readerid'];
		$sql = "select ReaderId from reader where ReaderId='".$Readerid."'";
		$result = $conn->query($sql);
		if($result)
		{
			if ($result->num_rows > 0) 
			{
				$_SESSION['readerid'] = $Readerid;
				header('location:readerindex.php');
			}
			else
			{
				$ReaderidErr = "Reader does not exist.";
			}
		}
	}
	
}
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
 <table style="border:solid #99CC99; text-align:center; margin:70px 300px;;  width:40%; line-height:40px;" class="tbl_form">
<tr bgcolor="#99CC99">
          <td align="center" colspan="2" style="color:#C60001; font-weight:bolder;" >READER LOGIN :</td>
        </tr>
         
<tr><td><strong> ENTER ID: </strong></td><td><input type="text" name="Readerid" class="txt_form"></td> <?php echo $ReaderidErr;?></tr>
<tr><td colspan="3" align="center"><input type="submit" name="Submit" value="Submit"></td></tr>
<tr> <td colspan="3" align="center"> <a href="addreader1.php"> click here to Register </a> </td> </tr>
</table>
</form>
</div>
<?php include "footer.php";?>
</body>