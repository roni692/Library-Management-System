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
	$bookidErr = '';
	if(isset($_POST['Submit']))
	{
		if (empty($_POST["bookid"])) 
		{
			$bookidErr = "BookId is required";
		}
		else 
		{
			$bookid = test_input($_POST["bookid"]);
			$sql = "select bookid,ISBN from book where bookid=".$bookid;
			$result = $conn->query($sql);
			if($result)
			{
				if ($result->num_rows > 0) 
				{
					$row =mysqli_fetch_row($result);
					$sql_book = "select * from borrow 
									where bookid=".$row[0]." 
									order by BDatetime desc limit 1";
					$result_book = $conn->query($sql_book);
					if($result_book)
					{
						if ($result_book->num_rows > 0) 
						{
							$row_book =mysqli_fetch_row($result_book);
							if($row_book[4] == null)
							{
								if($row_book[0] == $readerid)
								{
									echo "You have Borrowed book on ".$row_book[3];
								}
								else
								{
									
									echo "Other user has borrowed the book.";
								}
							}
							else
							{
								echo "This Book ID is available to borrow or reserve.";
							}
						}
						else
						{
							echo "This Book ID is available to borrow or reserve.";
						}
					}
					else
					{
						echo "Database Error";
					}
				}
				else
				{
					$bookidErr = "bookid doesnot exist.";
				}
			}
			else
			{
				echo "Database Error";
			}
			
		}
	}
 ?>
 <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
 <table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">
        <tr bgcolor="#CCCCCC">
          <th colspan="2"> SEARCH BOOK BY ID</th>
        </tr>
		<tr>
<td><strong> BOOK ID: </strong></td>
<td><input type="number" name="bookid" class="txt_form"/></td><?php echo $bookidErr;?></tr>
<br><br>
<tr>
<td colspan="2" align="center">
<input type="submit" name="Submit" value="Submit"/>
</td>
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