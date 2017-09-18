<?php include "header.html"; ?>
<div id="section">
<!--<ul id="menu"> -->
	<table>
  <tr align="center" colspan="2" style="color:#C60001; font-weight:bolder;"> <td align="center" bgcolor="#99CC99"> <a href="index.php" class="menu_font"> ADMIN </a></td>
      
	</tr>
	</table>
</ul>
 <?php
 include_once 'db_connect_inc.php';
$name ="";
$password = "";
$nameErr = "";
$passwordErr = ""; 
 if(isset($_POST['Submit'])){
if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
	// check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z0-9]*$/",$name)) {
       $nameErr = "Only letters and numbers allowed"; 
     }
  }
  if(empty($_POST["password"])){
  $passwordErr = "Password is required";
  }else{
  $password = test_input($_POST["password"]);
  }
  }
  if($nameErr == null && $passwordErr == null)
  {
  if($name != null && $password != null)
  {
	$sql = "select username,password from libadmin where username ='".$name."' and password = '". $password."';";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$_SESSION['username'] = $row["username"];
		$_SESSION['password'] = $row["password"];
		header("location:adminlogin.php");
    }
} else {
    echo "<span class='error'>Incorrect Username  or Password.</span>";
}
  }
  }
 ?>
 
 <div id="content">
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  
      <table style="border:solid #99CC99; text-align:center; margin:70px 300px;;  width:40%; line-height:40px;">
      	<tr bgcolor="#99CC99">
          <td align="center" colspan="2" style="color:#C60001; font-weight:bolder;" >ADMIN LOGIN :</td>
        </tr>
        <tr>
          <td><strong>USER NAME : </strong></td>
          <td><input type="text" name="name"  class="input"/></td><?php echo $nameErr;?>
        </tr>
        <tr>
          <td><strong>PASSWORD : </strong></td>
          <td><input type="password" name="password"  class="input" /></td><?php echo $passwordErr;?>
        </tr>
        <tr>
          <td colspan="2" align="center"><input type="submit" value="LOGIN" name="Submit"  />
            <input type="reset" value="CANCEL" name="cancel" >          </td>
        </tr>
      </table>
    </form>
  </div>
  
 
</div>
<?php include "footer.php";?>
</body>