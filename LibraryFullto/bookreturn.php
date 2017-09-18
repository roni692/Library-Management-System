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
	$readerid=$_SESSION['readerid'];
	$returnbook = '';
	$returnbookErr = '';
	if(isset($_POST['return']))
	{
		if(isset($_POST['returnbook']))
		{
			$returnbook=$_POST['returnbook'];
		}
		else
		{
			$returnbookErr = "Please select a book.";
			echo "<span class='error'>".$returnbookErr."</span>";
		}
		if($returnbook != null)
		{
			$book = explode('-', $returnbook);
			$sql ="update borrow set Fine=".$book[1]." ,RDateTime='".date("Y-m-d H:i:s")."' where BookId=".$book[0]." and LibId=".$book[2];
			
			if ($conn->query($sql) === TRUE)
			{
				echo "<span class='error'>Thank you. Book return successfully.<span>";
			} 
			else 
			{
				echo "<span class='error'>Error: ". $conn->error. "</span>";
			}
			
		}
	}
	$sql ="select * from borrow where readerid=".$readerid." and rdatetime is null";
	$result = $conn->query($sql);
	if($result)
	{
		if ($result->num_rows > 0) 
		{
			echo '<table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form"><form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';
			echo '<tr bgcolor="#CCCCCC"><td align="center"><strong>Reader ID </strong> </td><td align="center"><strong>Branch ID </strong></td><td align="center"><strong>Book ID </strong></td><td align="center"> <strong> Borrow Time </strong></td><td align="center"> <strong>Return Time</strong></td><td align="center"><strong> Fine </strong></td><td align="center"><strong>Select Book </strong></td></tr>';
			while($row = $result->fetch_assoc())
			{
				$today = date("Y-m-d H:i:s");
				$datetime1 = date_create($today);
				$datetime2 = date_create($row['BDateTime']);
				$interval = date_diff($datetime2, $datetime1);
				$days=$interval->format('%a');
				if($days > 20)
				{
					$days= $days-20;
					$fine=$days*0.20;
				}
				else
				{
					$fine=0;
				}
				echo '<tr><td>'.$row["ReaderId"].'</td><td>'.$row['LibId'].'</td><td>'.$row['BookId'].'</td><td>'.$row['BDateTime'].'</td><td>'.$row['RDateTime'].'</td><td>'.$fine.'</td><td><input type="radio" name="returnbook" value="'.$row['BookId'].'-'.$fine.'-'.$row['LibId'].'"></td></tr>';
			}
			echo '<tr><td colspan="100%" align="center"><input type="submit" name="return" value="Return"></td></tr></form></table><br/><br/>';
		}
		else
		{
			echo 'Currently users do not have books to return.';
		}
	}
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