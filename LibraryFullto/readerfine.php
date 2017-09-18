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
	$sql ="select * from borrow where readerid=".$readerid." and rdatetime is null";
	$result = $conn->query($sql);
	if($result)
	{
		if ($result->num_rows > 0) 
		{
			echo '<table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">';
			echo '<tr><td><strong>Reader ID </strong></td><td><strong> Branch ID <strong></td><td> <strong> Book ID </strong></td><td><strong> Borrow Time </strong></td><td><strong> Return Time </strong></td><td><strong> Fine </strong></td></tr>';
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
				echo '<tr><td>'.$row["ReaderId"].'</td><td>'.$row['LibId'].'</td><td>'.$row['BookId'].'</td><td>'.$row['BDateTime'].'</td><td>'.$row['RDateTime'].'</td><td>'.$fine.'</td></tr>';
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
echo "<p><span class='error'>Please Login.</span></p>";
}
?>
</div>
<?php include "footer.php";?>
</body>
</html>