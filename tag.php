<?php 
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include("$root/scripts/db-connection.php"); 
include("$root/scripts/settings.php");
include("$root/scripts/header.php"); 

?>
		<section style="max-width:500px;">
		
			
			<?php echo $messages[2]; ?>:<div style="margin:0.5em"></div>
			
			<div class="tag-image-wrapper" style="text-align:center"><img width="320" id="inputimage" class="tag-image" src="" /></div>
			<form method="GET" action="api.php">
				<input type="hidden" name="type" value="addtag">
				<input id="hiddeninput" type="hidden" name="imageid" value="3">
				<input type="radio" name="toogeneric" value="0" checked="checked"><textarea type="text" name="name"></textarea><br>
				<div style="margin:0.5em"></div>
				<input type="radio" name="toogeneric" value="1"> <?php echo $messages[3]; ?><br>
				
				
				<div style="text-align:right;margin:0.3em;"><a style="" class="button" href="/en/index.php"><?php echo $messages[4]; ?></a> <button class="button" type="submit">Ok</button></div>
			</form>
			
		</section>
		
		<script>
		$.getJSON('api.php?type=gettag', function(data) {
			  $( "#hiddeninput" ).attr("value",data.id);
			  $( "#inputimage" ).attr("src",data.url);
			  
		});
		</script>
		
<?php 
include("$root/scripts/footer.php"); 
?>