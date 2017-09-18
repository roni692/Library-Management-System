<?php include "header.html";?>
<!--<div id="menu"> -->
<?php include "checklogin.html";?>
</div>
<div id="section">
 <?php
 include_once 'db_connect_inc.php';
 $bookidErr = '';
 if(isset($_SESSION['username']))
{
 $admin = $_SESSION['username'];
}else
{
	$admin = null;
}
if($admin != null)
{
	$nameErr = '';
	if(isset($_POST['Submit']))
	{	
		if (empty($_POST["name"])) 
		{
			$nameErr = "Book Title is required";
		}
		else 
		{
			$name = test_input($_POST["name"]);
			/*$sql = "select bookinfo.ISBN,author.name, bookid 
					from book,bookinfo,author
					where bookinfo.ISBN=book.ISBN
					and Bookinfo.authorid= author.authorid
					and bookinfo.title='".$name."'";*/
			$sql = "select bookinfo.ISBN,book.bookid ,count(*) as count
					from bookinfo,book, borrow 
					where bookinfo.title='".$name."' 
					and bookinfo.ISBN=book.ISBN
					and book.bookid = borrow.bookid 
					and borrow.Bdatetime is NULL group by borrow.bookid";
			echo $sql;
			$result = $conn->query($sql);
			print_r($result);
			if($result)
			{
				if ($result->num_rows > 0) 
				{
					$row = $result->fbsql_fetch_row();
					$sql = "select count(*) from borrow where ISBN=".$row['ISBN']." and Rda";
					$result = $conn->query($sql);
					if($result)
					{
						if ($result->num_rows > 0) 
						{
							$status= "Borrowed";
						}
						else
						{
							$sql1= "select bookid from reserve where bookid=".$bookid;
							$result1 = $conn->query($sql1);
							if($result)
							{
								if ($result->num_rows > 0) 
								{
									$status= "Reserved";
								}
								else
								{
									$status ="Available";
								}
							}
						}
					}
				}
				else
				{
					$bookidErr = "bookid doesnot exist.";
				}
			}
			
		}
	}
 ?>
 
 <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
 <table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">
        <tr bgcolor="#CCCCCC">
          <th colspan="2"> SEARCH BOOK</th>
        </tr>
<tr> <td> Book Title:</td> <td> <input type="text" name="name" class="txt_form"></td><span class="error"> <?php echo $nameErr;?></span></tr>
<tr> <td colspan="2" align="center">
<input type="submit" name="Submit" value="Submit"> </td>
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