<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en-GB" xml:lang="en-GB"> <!--<![endif]-->
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Visual Dictionary</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="/static/css/normalize.css">
        <link rel="stylesheet" href="/static/css/main.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet/less" type="text/css" href="/static/css/style.less">
        
		<script src="/static/js/vendor/modernizr-2.6.2.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		
		<script>  
		    document.createElement("article");  
			document.createElement("footer");  
			document.createElement("header");  
			document.createElement("hgroup");  
			document.createElement("nav");
		</script>	
    </head>
    <body>
        <!--[if lt IE 7]>
            <p>Outdated Browser Message Goes Here</p>
        <![endif]-->

        <!-- Main Content -->
		<div id ="settings">
			<?php echo $messages[5]; ?>:
<?php
			$stmt=$dbh->prepare("SELECT * FROM `languages`");
			$stmt->execute();

			while ($row = $stmt->fetch()) {			
				if ($row["id"]==$language["id"]) {
					echo '			<a title="'.$row["fulltext"].'" href="/'.$row["accro"].'/index.php"><img class="flag flag-active" src="/static/img/flags/'.$row["flagurl"].'" /></a>'."\n";
				} else {
					echo '			<a title="'.$row["fulltext"].'" href="/'.$row["accro"].'/index.php"><img class="flag" src="/static/img/flags/'.$row["flagurl"].'" /></a>'."\n";				
				}
			}
			
			?>
		
		</div>
		<nav>
			<span style="float:left;">
			<img width="40" height="40" src="/static/img/flags/<?php echo $language["flagurl"]; ?>" />
			</span>
			<a href="#"><i id="settingsbutton" class="icon-cogs icon-2x"></i></a>
		</nav>