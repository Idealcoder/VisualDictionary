﻿<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$pagetitle="Home";
include("$root/scripts/header.php"); 
?>
		<section>
			<p>Welcome to IdealFrame Work, a fork of <a href="http://html5boilerplate.com/">HTML5 Boiler Plate</a>. It also has a client-based version of <a href="http://lesscss.org/">LESS</a>, a dynamic css language. Just a couple of basics to start you off.</p>
			
			<ul>
			<li>Change the project title in /scripts/header.php line 9</li>
			<li>At the top of each page in php set the var <b>$pagetitle</b>, for the title of that page</li>
			<li>Restyle the css, the stuff here is just a guideline</li>
			<li>The error folder contains errors, you will want to edit</li>
			</ul>
			
		<section>
		
<?php 
include("$root/scripts/footer.php"); 
?>