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
 $name = "";
 $title = "";
 $authorname="";
 $publisher = "";
 $pdate="";
 $ISBNErr="";
 $titleErr="";
 $authornameErr ="";
 $publisherErr = "";
 $pdateErr = "";
 
 if(isset($_POST['Submit']))
 {
	if (empty($_POST["name"])) {
		$ISBNErr = "Book ISBN is required";
	} else {
		$name = test_input($_POST["name"]);
	// check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z0-9]*$/",$name)) {
       $ISBNErr = "Only letters, numbers allowed"; 
     }
	 $sql_err = "select ISBN from bookinfo where ISBN='".$_POST["name"]."'";
	 $result = $conn->query($sql_err);
		if ($result->num_rows > 0) {
			$ISBNErr = "Book already exist.";
		}
	 }
	 if(empty($_POST['title'])){
		$titleErr = "Book Title is required.";
	 }else {
		$title = test_input($_POST['title']);
		$sql_title = "select title from bookinfo where title='".$title."'";
		$result_title = $conn->query($sql_title);
		 if (!preg_match("/^[a-zA-Z0-9 ]*$/",$title)) {
			$titleErr = "Only letters, numbers and white space  allowed"; 
		}elseif ($result_title->num_rows > 0) {
			$titlerr = "Title already exist.";
		}
	 }
	 if(empty($_POST["authorname"])){
		$authornameErr = "Author Name is required";
	}else{
		$authorname = test_input($_POST["authorname"]);
		if (!preg_match("/^[a-zA-Z0-9 ]*$/",$authorname)) {
			$authornameErr = "Only letters, numbers and white space allowed"; 
		}
	}
	 if(empty($_POST["pdate"])){
		$pdateErr = "Publisher date is required";
	}else{
		$pdate = test_input($_POST["pdate"]);
	}
	if($ISBNErr == null && $authornameErr == null && $titleErr == null && $pdateErr == null)	
{
	if($title != null && $pdate != null && $authorname != null && $name != null){
		$date = explode('/',$pdate); 
		$pdate= $date[0];
		$sql= "SELECT AuthorId,name FROM author WHERE LOWER(name) = '" . strtolower($authorname) . "'";
		$result = $conn->query($sql);
		if($result)
		{
		if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$authorname = $row['AuthorId'];
		}
		}else {
		$sql_author = "insert into author (name) values ('".strtolower($authorname)."')";
		if ($conn->query($sql_author) === TRUE){
		$authorname=$conn->insert_id;
		}
		}
		$sql1 = "insert into bookinfo (ISBN,Title,AuthorId,PublisherId,PublicationDate) values ('".$name."','".$title."','".$authorname."','".$_POST['publisher']."','".$pdate."')";
		if ($conn->query($sql1) === TRUE){
		echo "<span class='error'>Book Successfully added.</span>";
		}
		}
		else
		{
			echo "Database Error:".mysqli_error();
		}
		
}
 }
	}

 ?>
 <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
 <table width="80%" cellpadding="10" cellspacing="0" align="center" border="1" class="tbl_form">
        <tr bgcolor="#CCCCCC">
          <th colspan="2"> ADD BOOK INFORMATION</th>
        </tr>
		<tr><td>ISBN: </td>
			<td><input type="text" name="name" class="txt_form"></td><span class="error"><?php echo $ISBNErr;?></span>
		</tr>
		<tr> <td>Title: </td>
			<td><input type="text" name="title" class="txt_form"></td><span class="error"><?php echo $titleErr;?></span></tr>
		<tr><td> Author Name: </td>
		<td><input type="text" name="authorname" class="txt_form"></td><span class="error"> <?php echo $authornameErr;?></span></tr>
		<tr> <td> Publisher: </td>
		<td> <select name="publisher" class="txt_form"><?php
$sql = "select PublisherId,Pname from publisher";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	echo "<option value= '".$row['PublisherId']."'>".$row['Pname']."</option>";
    }
	}
	$conn->close();?>
</select></td></tr>
<tr>
<td> Publication Date:</td>
<td> <input type="date" name="pdate" class="txt_form"></td><span class="error"> <?php echo $pdateErr;?></span></tr>
<tr> <td colspan="2" align="center">
<input type="submit" name="Submit" value="Add New Book"> </td></tr>
</table>
</form>
<?php
}else
{
echo "<p><span class='error'>Please Login.</span></p>";
}
?>
</div>
<?php include "footer.php";?>
</body>
</html>