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
	$branch ="";
	$BranchErr = "";
	if(isset($_POST['Submit']))
	{
		if(isset($_POST['branch']))
		{
			$branch = $_POST['branch'];
		}
		if($branch == 0)
		{
			$BranchErr = "Please select branch.";
		}
		if($BranchErr == null && $branch != null)
		{
			$sql="SELECT borrow.BookId,bookinfo.Title,count(*) AS count FROM borrow,book,bookinfo WHERE LibId =".$branch." and borrow.BookId = book.BookId and book.ISBN =bookinfo.ISBN GROUP BY ReaderId ORDER BY count DESC limit 10";
			$result = $conn->query($sql);
				if($result)
				{
					if ($result->num_rows > 0) 
					{
						echo '<table style="width:50%" border="1">';
						echo '<tr><td>Book Title</td><td>Total Borrowed time</td></tr>';
						while($row = $result->fetch_assoc())
						{
							echo '<tr><td>'.$row["Title"].'</td><td>'.$row['count'].'</td></tr>';
						}
						echo '</table><br/><br/>';
					}
					else
					{
						echo 'Currently there are no books that are borrowed.<br/><br/>';
					}
				}
			
		}
	}
	?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">
        <tr bgcolor="#CCCCCC">
          <th colspan="2"> MOST BORROWED BOOKS</th>
        </tr>
		<tr> <td> Branch Name: </td> <td> <select name="branch" class="txt_form"><option value='0'>select Branch</option>
	<?php
	$sql = "select * from branches";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) 
	{
		// output data of each row
		while($row = $result->fetch_assoc()) 
		{
			echo "<option value= '".$row['LibId']."'>".$row['Bname']."</option>";
		}
	}
	$conn->close();?>
	</select></td>		
	<span class="error"> <?php echo $BranchErr;?></span></tr>
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