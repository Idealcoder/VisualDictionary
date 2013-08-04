<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$pagetitle="Error 500";
include("$root/scripts/header.php"); 
?>
		<p>Error 500 - Internal Server Error</p>
<?php 
include("$root/scripts/footer.php"); 
?>