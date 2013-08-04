<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$pagetitle="Error 401";
include("$root/scripts/header.php"); 
?>
		<p>Error 401 - Unauthorized</p>
<?php 
include("$root/scripts/footer.php"); 
?>