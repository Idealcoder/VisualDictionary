<?php 
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$pagetitle="Add Tag";
include("$root/scripts/db-connection.php"); 
include("$root/scripts/header.php"); 
include("$root/scripts/settings.php");
?>
		<div id ="settings">
			<?php
			$stmt=$dbh->prepare("SELECT * FROM `languages`");
			$stmt->execute();

			while ($row = $stmt->fetch()) {			
echo '			<a href="/'.$row["accro"].'/index2.php"><img src="/static/img/flags/'.$row["flagurl"].'" /></a>';
			}
			
			?>
		
		</div>
		<nav>
			<i class="icon-cogs icon-2x"></i>
		</nav>
		<br>
		
		
		<section style="width:500px;">
			
			<?php echo $messages[2]; ?><br>
			
			<img width="80%" src="/static/img/tags/Red_Apple.jpg" />
			<br><br>
			<form method="POST" action="addtag.php">
				<input type="hidden" name="imageid" value="3">
				<input type="radio" name="toogeneric" value="0" checked="checked"><textarea type="text" name="name"></textarea><br>
				<input type="radio" name="toogeneric" value="1">Too Generic<br>
				
				
				<div style="text-align:right;margin:0.3em;"><button href="/en/index.php">Differen't Image</button><button type="submit">Ok</button></div>
			</form>
			
		</section>
		<br><br>
		
<?php 
include("$root/scripts/footer.php"); 
?>