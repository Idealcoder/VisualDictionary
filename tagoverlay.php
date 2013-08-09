<?php 
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include("$root/scripts/db-connection.php"); 
include("$root/scripts/settings.php");
include("$root/scripts/header.php"); 

?>
		<div style="opacity:0.3">
		<h1>Visual Dictionary</h1>
		
		<section style="padding-top:1em;">
			<div class="translatebar">
			<div id="sites">
			From<br>
			<?php
			$stmt=$dbh->prepare("SELECT * FROM `languages`");
			$stmt->execute();
		
			while ($row = $stmt->fetch()) {			
if (1==1) {
			echo '			<input type="radio" class="leftradio" name="site" id="'.$row["accro"].'" value="'.$row["accro"].'"/><label title="'.$row["fulltext"].'" id="'.$row["accro"].'21" for="'.$row["accro"].'"><img src="/static/img/flags/'.$row["flagurl"].'"  /></label>';
} else {
			echo '			<input type="radio" class="leftradio" name="site" id="'.$row["accro"].'" value="'.$row["accro"].'"  checked="checked" /><label title="'.$row["fulltext"].'" id="'.$row["accro"].'21" class="selected" for="'.$row["accro"].'"><img src="/static/img/flags/'.$row["flagurl"].'"  /></label>';
}
			}
			
			?>
			</div>
			</div>
			
			<div id="switch">
			<a class="button" title="Swap Languages" id="invertbutton" ><i class="icon-exchange icon-2x"></i></a>
			</div>
			
			<div class="translatebar">
			<div id="sites2">
			To<br>
						<?php
			$stmt=$dbh->prepare("SELECT * FROM `languages`");
			$stmt->execute();
		
			while ($row = $stmt->fetch()) {		
if (1==1) {			
echo '			<input type="radio" class="rightradio" name="site2" id="'.$row["accro"].'2" value="'.$row["accro"].'"/><label title="'.$row["fulltext"].'" id="'.$row["accro"].'22" for="'.$row["accro"].'2"><img src="/static/img/flags/'.$row["flagurl"].'"   /></label>';
} else {
echo '			<input type="radio" class="rightradio" name="site2" id="'.$row["accro"].'2" value="'.$row["accro"].'" checked="checked"/><label title="'.$row["fulltext"].'" id="'.$row["accro"].'22" class="selected" for="'.$row["accro"].'2"><img src="/static/img/flags/'.$row["flagurl"].'"  /></label>';
}
			}
			
			?>			</div></div>
			<br>
			<center>
			<input style="" id="searchbox" type="text" placeholder="Type Search Here" /><br><br>
			</center>
			

			
			<br>

		
		</section>
		<div style="margin:auto;max-width:900px;text-align:right">
		<a href="#">Tag more images</a> to improve translation accuracy
		</div>
		</div>
		
		<div style="position:absolute;top:5.3em;left:0em;text-align:center;width:100%">
		<section style="max-width:500px;">
		
			
			<?php echo $messages[2]; ?>:<div style="margin:0.5em"></div>
			
			<div class="tag-image-wrapper" style="text-align:center"><img  width="320" id="inputimage" class="tag-image" src="" /></div>
			<form method="GET" action="api.php">
				<input type="hidden" name="type" value="addtag">
				<input id="hiddeninput" type="hidden" name="imageid" value="3">
				<input type="radio" name="toogeneric" value="0" checked="checked"><textarea type="text" name="name"></textarea><br>
				<div style="margin:0.5em"></div>
				<input type="radio" name="toogeneric" value="1"> <?php echo $messages[3]; ?><br>
				
				
				<div style="text-align:right;margin:0.3em;"><a style="" class="button" href="/en/tagoverlay.php"><?php echo $messages[4]; ?></a> <button class="button" type="submit">Ok</button></div>
			</form>
			
		</section>
		</div>
		
		<script>
			$('#sites input:radio').addClass('input_hidden');
		$('#sites label').click(function() {
			$(this).addClass('selected').siblings().removeClass('selected');
		});
		$('#sites2 input:radio').addClass('input_hidden');
		$('#sites2 label').click(function() {
			$(this).addClass('selected').siblings().removeClass('selected');
		});
		
		$.getJSON('api.php?type=gettag', function(data) {
			  $( "#hiddeninput" ).attr("value",data.id);
			  $( "#inputimage" ).attr("src",data.url);
			  
		});
		</script>
		
<?php 
include("$root/scripts/footer.php"); 
?>