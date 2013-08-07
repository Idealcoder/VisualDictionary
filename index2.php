<?php 
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$pagetitle="Add Tag";
include("$root/scripts/db-connection.php"); 
include("$root/scripts/settings.php");
include("$root/scripts/header.php"); 

?>
		<section style="max-width:500px;">
		
			
			<?php echo $messages[2]; ?>:<div style="margin:0.5em"></div>
			
			<div class="tag-image-wrapper" style="text-align:center"><img class="tag-image" src="/static/img/tags/Red_Apple.jpg" /></div>
			<form method="POST" action="addtag.php">
				<input type="hidden" name="imageid" value="3">
				<input type="radio" name="toogeneric" value="0" checked="checked"><textarea type="text" name="name"></textarea><br>
				<div style="margin:0.5em"></div>
				<input type="radio" name="toogeneric" value="1"> <?php echo $messages[3]; ?><br>
				
				
				<div style="text-align:right;margin:0.3em;"><a style="padding-bottom:5px" class="button" href="/en/index.php"><?php echo $messages[4]; ?></a><button class="button" type="submit">Ok</button></div>
			</form>
			
		</section>
		
<?php 
include("$root/scripts/footer.php"); 
?>