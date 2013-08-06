<?php 
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$pagetitle="Home";
include("$root/scripts/db-connection.php"); 
include("$root/scripts/header.php"); 
include("$root/scripts/settings.php");
?>
		<div id ="settings">
			<?php
			
/*$stmt=$dbh->prepare("SELECT * FROM `languages`");
			
			while (){
			
echo '			<a href="/'.$row["accro"].'/"><img src="/static/img/flags/'.$row["url"].'" /></a>';
			}*/
			
			?>
		
		</div>
		
		<section>
			<i class="icon-cogs"></i> icon-cogs
		
			<?php echo $messages[1]; ?><br>
			Test Flags<br>
			Selected vs not Selected
			<img src="/static/img/flags/United-kingdom-flag-48.png"><img style="opacity:0.5" src="/static/img/flags/United-kingdom-flag-48.png">
			
			
			<p>Welcome to IdealFrame Work, a fork of <a href="http://html5boilerplate.com/">HTML5 Boiler Plate</a>. It also has a client-based version of <a href="http://lesscss.org/">LESS</a>, a dynamic css language. Just a couple of basics to start you off.</p>
			
			<ul>
			<li>Change the project title in /scripts/header.php line 9</li>
			<li>At the top of each page in php set the var <b>$pagetitle</b>, for the title of that page</li>
			<li>Restyle the css, the stuff here is just a guideline</li>
			<li>The error folder contains errors, you will want to edit</li>
			</ul>
			
		</section>
		
<?php 
include("$root/scripts/footer.php"); 
?>