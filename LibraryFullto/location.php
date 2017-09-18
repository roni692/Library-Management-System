<?php include "header.html";?>
<div id="section">
<ul id="menu">
	<table width="100%">
  <tr align="center" colspan="2" style="color:#C60001; font-weight:bolder;"> <td align="center" bgcolor="#99CC99"> <a href="reader.php" class="menu_font"> READER </a></td>
		<td align="center" bgcolor="#99CC99"> <a href="location.php" class="menu_font"> LOCATIONS </a></td>
		<td align="center" bgcolor="#99CC99"> <a href="aboutus.php" class="menu_font"> ABOUT US </a></td>
		<td align="center" bgcolor="#99CC99"> <a href="contactus1.php" class="menu_font"> CONTACT US </a></td>
	</tr>
	</table>
</ul>

<?php
session_destroy();
/**
 
 */
echo '<p>Welcome to the online library system. Administator needs to login to the system to use the online services.<br/>';
echo 'Reader should register before using online library system.</p>';

?>
<?php
echo '<img src="image.jpg" width="800" height="380">'
?>
</div>
<?php include "footer.php"; ?>
</body>
</html>