<?php include "header.html";?>
<!--<div id="menu" align="center">-->
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
	$titleErr = '';
	if(isset($_POST['Submit']))
	{
		if (empty($_POST["title"])) 
		{
			$titleErr = "Book Title is required";
		}
		else 
		{
			$title = test_input($_POST["title"]);
			$sql = "select bookinfo.ISBN,author.name, bookid 
					from book,bookinfo,author
					where bookinfo.ISBN=book.ISBN
					and Bookinfo.authorid= author.authorid
					and bookinfo.title='".$title."'";
			$result = $conn->query($sql);
			if($result)
			{
				
				if ($result->num_rows > 0) 
				{
					echo '<table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form"><tr bgcolor="#CCCCCC"><td align="center"><strong>Book ISBN</strong></td><td align="center"><strong>Author Name </strong></td><td align="center"><strong>Book ID </strong></td></tr>';
					while($row = $result->fetch_assoc())
					{
						echo "<tr><td>".$row['ISBN']."</td><td>".$row['name']."</td><td>".$row['bookid']."</td></tr>";
					}
					echo "</table>";
				}
				else
				{
					$titleErr = "Title doesnot exist.";
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
          <th colspan="2"> SEARCH BOOK BY TITLE</th>
        </tr>
		<tr>
<td><strong> BOOK TITLE: </strong></td>
 <td> <input type="text" name="title" class="txt_form"></td><?php echo $titleErr;?></tr>
 <tr>
 <td colspan="2" align="center">
<input type="submit" name="Submit" value="Submit"></td> </tr>
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