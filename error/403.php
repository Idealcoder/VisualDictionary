<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$pagetitle="Error 403";
include("$root/scripts/header.php"); 
?>
		<p>Error 403 - Forbidden</p>
<?php 
include("$root/scripts/footer.php"); 
?>