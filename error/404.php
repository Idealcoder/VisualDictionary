<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$pagetitle="Error 404";
include("$root/scripts/header.php"); 
?>
		<p>Error 404 - File Does Not Exist</p>
<?php 
include("$root/scripts/footer.php"); 
?>