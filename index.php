<?php 
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$pagetitle="Add Tag";
include("$root/scripts/db-connection.php"); 
include("$root/scripts/settings.php");
include("$root/scripts/header.php"); 

?>

		<section style="width:500px;">
			<br>
			
			<div style="text-align:center;width:40%;float:left;">
			<?php
			$stmt=$dbh->prepare("SELECT * FROM `languages`");
			$stmt->execute();

			while ($row = $stmt->fetch()) {			
echo '			<a href="/'.$row["accro"].'/index2.php"><img src="/static/img/flags/'.$row["flagurl"].'" /></a>';
echo '			<a href="/'.$row["accro"].'/index2.php"><img src="/static/img/flags/'.$row["flagurl"].'" /></a>';
echo '			<a href="/'.$row["accro"].'/index2.php"><img src="/static/img/flags/'.$row["flagurl"].'" /></a>';
			}
			
			?>
			</div>
			
			<div style="text-align:center;width:20%;float:left;">
			<button><i class="icon-exchange icon-2x"></i></button>
			</div>
			
			<div style="text-align:center;width:40%;float:left;">
			<?php
			$stmt=$dbh->prepare("SELECT * FROM `languages`");
			$stmt->execute();

			while ($row = $stmt->fetch()) {			
echo '			<a href="/'.$row["accro"].'/index2.php"><img src="/static/img/flags/'.$row["flagurl"].'" /></a>';
echo '			<a href="/'.$row["accro"].'/index2.php"><img src="/static/img/flags/'.$row["flagurl"].'" /></a>';
echo '			<a href="/'.$row["accro"].'/index2.php"><img src="/static/img/flags/'.$row["flagurl"].'" /></a>';
			}
			
			?>			</div>
			
			<input style="padding:" type="text" placeholder="Type Translation Here" /><br><br>
			
			<img width="40%" height="200px" src="/static/img/tags/Red_Apple.jpg" />
			<img width="40%" height="200px" src="/static/img/tags/Apples.jpg" />
			<br>
			Pomme
			
			<!-- <form method="POST" action="addtag.php">
				<input type="hidden" name="imageid" value="3">
				<input type="radio" name="toogeneric" value="0" checked="checked"><textarea type="text" name="name"></textarea><br>
				<input type="radio" name="toogeneric" value="1">Too Generic<br>
				
				
				<div style="text-align:right;margin:0.3em;"><button href="/en/index.php">Differen't Image</button><button type="submit">Ok</button></div>
			</form> -->
		
		</section>

<?php 
include("$root/scripts/footer.php"); 
?>