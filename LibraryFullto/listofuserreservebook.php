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
}
else
{
	$readerid = null;
}
if($readerid != null)
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
			$avalilable = '';
			$readerid = $_SESSION['readerid'];
			$sql ="select reserve.B_ISBN,title 
			       from reserve,bookinfo 
				   where reserve.B_ISBN = bookinfo.ISBN 
				   and readerid=".$readerid;
			$result = $conn->query($sql);
			if($result)
			{
				if ($result->num_rows > 0) 
				{
					echo '<table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">';
					echo "<tr bgcolor='#CCCCCC'><td align='center'><strong>ISBN </strong></td><td align='center'><strong> Book Name</strong></td><td align='center'><strong> Status </strong></td></tr>";
					while($row = $result->fetch_assoc()) 
					{
						$sql_copies = "select BookInfo.Title FROM Book, BookInfo, BookBranch
							WHERE Book.ISBN = BookInfo.ISBN
							AND Book.BookId = BookBranch.BookId
							AND BookBranch.BranchId = ".$branch."
							AND Book.ISBN = '".$row['B_ISBN']."'
							AND BookBranch.BookId NOT IN (SELECT BookId
													FROM Borrow
													WHERE RDateTime IS NULL)
							ORDER BY Book.BookId";
										 
						$avalilable = '';
						$result_copy = $conn->query($sql_copies);
						if($result_copy)
						{
							if($result_copy->num_rows > 0)
							{
								$avalilable = "Available";
							}
							else
							{
								//$avalilable = "Not Available";
								$sql_avl_branches = "select distinct(Bname)
												FROM BookBranch, Branches
												WHERE BookBranch.BranchId != ".$branch."
												AND BookBranch.BranchId = Branches.LibId
												AND BookBranch.BookId NOT IN (SELECT BookId
																		FROM Borrow
																		WHERE RDateTime IS NULL)";
								$result_avl_branches = $conn->query($sql_avl_branches);
								if($result_avl_branches)
								{
									if($result_avl_branches->num_rows > 0)
									{
										$branches_name = array();
										while($row_branch = $result_avl_branches->fetch_assoc())
										{
										  array_push($branches_name, $row_branch['Bname']);
										}
										
										$comma_sep = implode('<br>',$branches_name);
										$avalilable = "Available at:<br>".$comma_sep;
									}
									else
									{ 
										$avalilable = "Not Available";
									}
								}
																		
							}
						}
						echo "<tr><td>".$row['B_ISBN']."</td><td>".$row['title']."</td><td>".$avalilable."</td></tr>";
					}
					echo "</table>";
				
				}
				else
				{
					echo "You have not reserved any book.";
				}
			}
			else
			{
				echo "Database Error.";
			}
		}
		
	}
	?>
	<form id="create" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">
        <tr bgcolor="#CCCCCC">
          <th colspan="2"> LIST OF RESERVED BOOK </th>
        </tr>
		<tr>
		<td><strong> BRANCH NAME: </strong> </td>
		<td><select name="branch" class="txt_form"><option value='0'>Select branch</option>
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
	<?php echo $BranchErr;?></tr>
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