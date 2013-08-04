<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$pagetitle="Error 400";
include("$root/scripts/header.php"); 
?>
		<p>Error 400 - Bad Request</p>
<?php 
include("$root/scripts/footer.php"); 
?>