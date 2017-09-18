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
$name='';
$branch = '';
$nameErr = '';
$branchErr = "";
if(isset($_POST['Submit'])){

if(isset($_POST['ISBN'])){
$name =$_POST['ISBN'];
}else{
$nameErr ="required name";
}
if(isset($_POST['branch'])){
$branch = $_POST['branch'];
}else{
$branchErr = "required branch";
}
if($nameErr == null && $branchErr == null){
if($name != null && $branch != null){
			try {
					$sql = "select Numcopy from copies where ISBN='".$name."' and BranchId='".$branch."'";
					$result = $conn->query($sql);
					if($result == true){
						if ($result->num_rows > 0) {
							$copycount = mysqli_fetch_row($result);
							$sql3 = "update copies set Numcopy=".($copycount[0]+1)." where ISBN='".$name."' and BranchId=".$branch;
						}else {
							$sql3 = "insert into copies (BranchId,ISBN,Numcopy) values ('".$branch."','".$name."',1)";
						}
					}
					else{
						throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $conn->error);
					}
					mysqli_autocommit($conn, false);
					$sql1 = "insert into book(ISBN) values ('".$name."')";
					$res = $conn->query($sql1);
					if($res === false)
					{
						throw new Exception('Wrong SQL: ' . $sql1 . ' Error: ' . $conn->error);
					}
					$sql2 = "insert into bookbranch (BookId,BranchId) values ('".mysqli_insert_id($conn)."','".$branch."')";
					$res = $conn->query($sql2);
					if($res === false)
					{
						throw new Exception('Wrong SQL: ' . $sql2 . ' Error: ' . $conn->error);
					}
					$res = $conn->query($sql3);
					if($res === false)
					{
						throw new Exception('Wrong SQL: ' . $sql3 . ' Error: ' . $conn->error);
					}
					mysqli_commit($conn);
					echo "Book copy added to the branch.";
				} catch (Exception $e) {
					print_r( $e->getMessage());
					mysqli_rollback($conn);
			}
			}
			
}
}
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">
        <tr bgcolor="#CCCCCC">
          <th colspan="2"> ADD BOOK COPY</th>
        </tr>
		<tr> <td> Select ISBN: </td>
		<td><select name="ISBN" class="txt_form"><?php
$sql = "select ISBN from bookinfo";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	echo "<option value= '".$row['ISBN']."'>".$row['ISBN']."</option>";
    }
	}else{
	$nameErr = "ISBN Name is required";
	}?> 
</select></td><span class="error"> <?php echo $nameErr;?></span></tr>
<tr>
<td> Select Branch: </td> 
 <td> <select name="branch" class="txt_form">
<?php
	$sql_b = "select LibId,Bname from branches";
	$result_b = $conn->query($sql_b);
	if(!$result_b){
		$branchErr = "Branch does not exist.";
	}
	if ($result_b->num_rows > 0) {
    // output data of each row
    while($row = $result_b->fetch_assoc()) {
	echo "<option value= '".$row['LibId']."'>".$row['Bname']."</option>";
    }
	}
 ?>
 </select></td>
<span class="error"> <?php echo $branchErr;?></span></td>
<tr> <td colspan="2" align="center">
<input type="submit" name="Submit" value="Add Book Copy"></td></tr></table>
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