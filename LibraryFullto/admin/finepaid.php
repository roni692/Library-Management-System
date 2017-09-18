<?php include "header.html";?>

<!--<div id="menu"> -->
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
	if(isset($_POST['Submit']))
	{
		$reader = $_POST['reader'];
		if($reader == 0)
		{
			$sql = "SELEct borrow.ReaderId, name , avg(fine) as fine from borrow, reader where borrow.ReaderId = reader.ReaderId group by borrow.ReaderId";
			$result = $conn->query($sql);
			if($result)
			{
				if ($result->num_rows > 0) 
				{
					echo '<table style="width:50%" border="1">';
					echo '<tr><td>Reader ID</td><td>Name</td><td>Average fine</td></tr>';
					while($row = $result->fetch_assoc())
					{
						echo '<tr><td>'.$row["ReaderId"].'</td><td>'.$row['name'].'</td><td>'.$row['fine'].'</td></tr>';
					}
					echo '</table><br/><br/>';
				}
				else
				{
					echo 'Currently users do not have outstanding fines.<br/><br/>';
				}
			}
		}
		else
		{
		 $sql = "SELEct borrow.ReaderId, name , avg(fine) from borrow, reader where borrow.ReaderId = reader.ReaderId and borrow.ReaderId =".$reader." group by borrow.readerid";
		 $result = $conn->query($sql);
			if($result)
			{   if ($result->num_rows > 0) 
				{
					$row = mysqli_fetch_row($result);
					echo '<table style="width:50%" border="1">';
					echo '<tr><td>Reader ID</td><td>Name</td><td>Average fine</td></tr>';
					echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td></tr>';
					echo '</table><br/><br/>';
				}
				else
				{
					echo 'Currently this user do not have outstanding fines.<br/><br/>';
				}
				
			}
		}
	}
	?>
	
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">
        <tr bgcolor="#CCCCCC">
          <th colspan="2"> FINE PAID </th>
        </tr>
		<tr> <td> Student Name: </td> 
		<td><select name="reader"><option value='0'>select Reader</option>
	<?php
	$sql = "select * from reader";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) 
	{
		// output data of each row
		while($row = $result->fetch_assoc()) 
		{
			echo "<option value= '".$row['ReaderId']."'>".$row['Name']."</option>";
		}
	}
	$conn->close();?>
	</select></td> </tr>
	<tr> <td colspan="2" align="center">
	<input type="submit" name="Submit" value="Submit"></td></tr>
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