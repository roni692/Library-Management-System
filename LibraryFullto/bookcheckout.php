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
		$sql_count = "select sum(count) from (select count(*) as count
												from reserve
												where readerid = 117 group by readerid
										union
												select count(*) as count
												from borrow
												where readerid =117 
												and RdateTime is null group by readerid) 
									as Sumcount";
		$result_sum = $conn->query($sql_count);
		if($result_sum)
		{
			if($result_sum->num_rows >0)
			{
				$row = mysqli_fetch_row($result_sum);
				if ($row[0] < 10)
				{
					$sql="SELECT Book.BookId, Book.ISBN, BookInfo.Title
					  FROM Book, BookInfo, BookBranch
					  WHERE Book.ISBN = BookInfo.ISBN
						AND Book.BookId = BookBranch.BookId
						AND BookBranch.BranchId = ".$branch." 
						AND BookBranch.BookId NOT IN (SELECT BookId
														FROM Borrow
														WHERE RDateTime IS NULL)
						ORDER BY Book.BookId";
					$result = $conn->query($sql);
					if($result)
					{
						if ($result->num_rows > 0) 
						{
							echo '<table style="width:50%" border="1"><form method="post" action="bookcheckout.php?branch='.$branch.'" >';
							echo '<tr><td>Book ID</td><td>Book ISBN</td><td>Book Title</td><td>Select Book</td></tr>';
							while($row = $result->fetch_assoc())
							{
								echo '<tr><td>'.$row["BookId"].'</td><td>'.$row["ISBN"].'</td><td>'.$row['Title'].'</td><td><input type="radio" name="selectbook" value="'.$row['BookId'].'"></td></tr>';
							}
							echo '<tr><td colspan="100%" align="center"><input type="submit" name="reserve" value="CheckOut"></td></tr></form></table><br/><br/>';
						}
						else
						{
							echo 'Currently there are no book for the publication.<br/><br/>';
						}
					}
				}
				else
				{
					echo "You have exceeded the limit of Borrwing /reserving book.";
				}
			}
		}
		
	}
}
if(isset($_POST['reserve']))
{
	$selectbook='';
	$selectbookErr = '';
	if(isset($_POST['selectbook']))
	{
		$selectbook = $_POST['selectbook'];
	}
	else
	{
		$selectbookErr = "Please select book to reserve.";
	}
	if($selectbookErr == null)
	{
		//echo "bookid ".$selectbook;
		//echo "<br/>readerid ". $_SESSION['readerid'];
		//echo "<br/>branchid " .$_GET['branch'];
	
		$sql = "insert into borrow(bookid,libid,readerid) values(".$selectbook.",".$_GET['branch'].",".$_SESSION['readerid'].")";
		if ($conn->query($sql) === TRUE)
			{
				echo "<span class='error'>Book Borrowed successfully.</span>";
			} 
			else 
			{
				echo "<span class='error'>Error: ". $conn->error. "</span>";
			}
	}
}
?>
<form id="create" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">
        <tr bgcolor="#CCCCCC">
          <th colspan="2"> BOOK CHECKOUT </th>
        </tr>
		<tr>
	<td> <strong> BRANCH NAME: </strong> </td>
	<td> <select name="branch" class="txt_form"><option value='0'>Select Branch</option>
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
</select> </td>		
<?php echo $BranchErr;?></tr>
<br><br>
<tr>
<td colspan="2" align="center">
<input type="submit" name="Submit" value="Submit">
</td> </tr>
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