<?php include "header.html";?>
<!--<div id="menu" align="center"> -->
<?php include "checklogin.html";?>
</div>
<h1>
<div id="section">
<?php
include 'db_connect_inc.php';
$admin =$_SESSION['username'];
$sql = "select username from libadmin where username='".$admin."'";
$result = $conn->query($sql);
if($result)
	{   if ($result->num_rows > 0) 
		{
			$row = mysqli_fetch_row($result);
			echo "Logged In Person is ".$row[0];
			echo "<br> please select any option.";
		}
	}
			
?>
</div>
</h1>
<?php include "footer.php"; ?>
</body>