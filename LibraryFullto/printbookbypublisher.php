<?php include "header.html";?>
<!--<div id="menu" align="center"> -->
<?php include "readermenu1.html";?>
</div>
<div id="section">

<?php
include_once 'db_connect_inc.php';
if(isset($_SESSION['readerid']))
{
 $readerid = $_SESSION['readerid'];
}else
{
	$readerid = null;
}
if($readerid != null)
{
	$publisher ="";
	$publisherErr = "";
	if(isset($_POST['Submit']))
	{
		if(isset($_POST['publisher']))
		{
		$publisher = $_POST['publisher'];
		}
		if($publisher == 0)
		{
			$publisherErr = "Please select Publisher";
		}
		if($publisherErr == null && $publisher != 0)
		{
			$sql = "select ISBN,Title from bookinfo where PublisherId=".$publisher;
			$result = $conn->query($sql);
			if($result)
			{
				if ($result->num_rows > 0) 
				{
					echo '<table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">';
					echo '<tr bgcolor="#CCCCCC"><td align="center"><strong>Book ISBN </strong></td><td align="center"><strong>Book Title </strong></td></tr>';
					while($row = $result->fetch_assoc())
					{
						echo '<tr><td>'.$row["ISBN"].'</td><td>'.$row["Title"].'</td></tr>';
					}
					echo '</table><br/><br/>';
				}
				else
				{
					echo 'Currently there are no book for the publication.<br/><br/>';
				}
			}
		}
	}
	?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">
        <tr bgcolor="#CCCCCC">
          <th colspan="2"> PRINT BOOK BY PUBLISHER </th>
        </tr>
		<tr>
			<td> <strong> PUBLISHER: </strong> </td>
			<td><select name="publisher"  class="txt_form"><option value='0'>select publisher</option><?php
	$sql = "select PublisherId,Pname from publisher";
		$result = $conn->query($sql);
		if ($result->num_rows > 0)
		{
			// output data of each row
			while($row = $result->fetch_assoc()) 
			{
				echo "<option value= '".$row['PublisherId']."'>".$row['Pname' ]."</option>";
			}
		}
		$conn->close();?>
	</select></td><?php echo $publisherErr;?></td> </tr>
<br><br>
<tr>
<td colspan="2" align="center">
	<input type="submit" name="Submit" value="Submit">
	</td> </tr> </table>
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