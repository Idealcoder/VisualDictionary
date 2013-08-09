<?php 
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include("$root/scripts/db-connection.php"); 
include("$root/scripts/settings.php");

//disable as will potentially mess up jsons. Good enough checks are in place
error_reporting(0);

if (isset($_GET["type"])==0) {
			echo json_encode(array("error" => "no type parameter specified"));
			break;
}

switch (strtolower($_GET["type"])) {
// **Misc Requests**
    case "gettag":
		//this is to find out what image the site should be asking the user to tag
        $stmt = $dbh->prepare("SELECT COUNT(`imagetag`.`imageid`) as 'count',`images`.`url`,`images`.`id` FROM `images` LEFT JOIN `yrs-2013`.`imagetag` ON `images`.`id` = `imagetag`.`imageid` AND ((`imagetag`.`languageid`=? OR `imagetag`.`languageid` IS NULL) AND `imagetag`.`machine`=0) GROUP BY `images`.`url` ORDER BY `count` ASC");
		$stmt->bindParam(1, $language["id"]);
		$stmt->execute();
		$image = $stmt->fetch();

		
		$image["url"]="http://".$_SERVER["SERVER_NAME"]."/static/img/tags/".$image["url"];
		
		echo json_encode($image);
        break;
    case "addtag":
		//this is to add a tag, run on submit.
		if (isset($_GET["name"])==0) {
			echo json_encode(array("error" => "no imageid parameter"));
			break;
		if (isset($_GET["name"])==0) {
			echo json_encode(array("error" => "no toogeneric parameter"));
			break;
		}
		}
		if (isset($_GET["name"])==0) {
			echo json_encode(array("error" => "no name string"));
			break;
		}
		//if ((trim($_GET["name"]))=="") {
		//	echo json_encode(array("error" => "name string is blank"));
		//	break;
		//}
		
		$array = explode("\n",strtolower($_GET["name"]));
		
		foreach ($array as &$value) {
			$stmt = $dbh->prepare("INSERT INTO `imagetag`(`imageid`, `languageid`, `toogeneric`, `name`) VALUES (?,?,?,?)");
			$stmt->bindParam(1, $_GET["imageid"]);
			$stmt->bindParam(2, $language["id"]);
			$stmt->bindParam(3, $_GET["toogeneric"]);
			$stmt->bindValue(4, $value);
			$stmt->execute();
		}
		

		
		if ($_GET["toogeneric"]==1) {
			//delete that image!!! 
			$stmt = $dbh->prepare("DELETE FROM `images` WHERE `images`.`id`= ? ");
			$stmt->bindParam(1, $_GET["imageid"]);
			$stmt->execute();			
		}
		if ($_SESSION["tag_added"]==0) {
		$_SESSION["tag_added"]=1;
		header("Location: index.php"); //educated guess user want translation page
		} else {
		header("Location: tag.php"); //currently not working off ajax.		
		}
        break;
//**API Start**
    case "searchimages":
		//this is to search for images with the same meaning as the query	
		if (isset($_GET["query"])==0) {
			echo json_encode(array("error" => "no query string"));
			break;
		}
		
		$stmt = $dbh->prepare("SELECT * FROM `languages` WHERE `accro`= ?");
		$stmt->bindValue(1, strtolower($_GET["from"]));
		$stmt->execute();
		$languagefrom = $stmt->fetch();
		
		if ($stmt->rowCount()==0) {
			echo json_encode(array("error" => "Please Choose Language"));
			break;
		}
		
		$stmt = $dbh->prepare("SELECT * FROM `languages` WHERE `accro`= ?");
		$stmt->bindValue(1, strtolower($_GET["to"]));
		$stmt->execute();
		$languageto = $stmt->fetch();
		
		if ($stmt->rowCount()==0) {
			echo json_encode(array("error" => "Please Choose Language"));
			break;
		}
		
		$stmt=$dbh->prepare("SELECT `images`.`url` FROM `images` LEFT JOIN `yrs-2013`.`imagetag` ON `images`.`id` = `imagetag`.`imageid` WHERE (`imagetag`.`name` LIKE ? ) AND (`imagetag`.`languageid` = ?) GROUP BY `images`.`id` LIMIT 0,20");
		$stmt->bindValue(1,"".trim(strtolower($_GET["query"]))."");
		$stmt->bindParam(2,$languagefrom["id"]);
		$stmt->execute();
		
		$imageresults = array();
		while ($row = $stmt->fetch()) {
			$imageresults["images"][]="http://".$_SERVER["SERVER_NAME"]."/static/img/tags/".$row["url"];	
		}
		
		if ($stmt->rowCount()==0) {
			echo json_encode(array("error" => "No images found. Query has been added to queue to be tagged"));
			$stmt=$dbh->prepare("INSERT INTO `yrs-2013`.`tagque` (`tag`) VALUES (?)");	
			$stmt->bindValue(1,strtolower($_GET["query"]));	
			$stmt->execute();
			break;
		}
		
		echo json_encode($imageresults);
        break;
	case "translate":
	//this will give an array of words ranked by relevance when an array of one or more picture urls is parsed
	if (isset($_GET["array"])==0) {
			echo json_encode(array("error" => "no array parameter"));
			break;
	}
	if ($_GET["array"]=="") {
			echo json_encode(array("error" => "no array parameter"));
			break;
	}
	
	$stmt = $dbh->prepare("SELECT * FROM `languages` WHERE `accro`= ?");
	$stmt->bindValue(1, strtolower($_GET["to"]));
	$stmt->execute();
	$languageto = $stmt->fetch();
		
	if ($stmt->rowCount()==0) {
		echo json_encode(array("error" => "no to language specified"));
		break;
	}
		
	$images = json_decode($_GET["array"],true);
	
	$wherestring="";
	foreach ($images["images"] as &$value) {
		if ($wherestring=="") {
			$wherestring=$wherestring."(`images`.`url`=?) ";
		} else {
			$wherestring=$wherestring."OR (`images`.`url`=?) ";
		}
	}
	
	$stmt = $dbh->prepare("SELECT COUNT(*) as 'count',`imagetag`.`name` FROM `images` JOIN `yrs-2013`.`imagetag` ON `images`.`id` = `imagetag`.`imageid` WHERE ( ".$wherestring." ) AND `languageid`=? GROUP BY `imagetag`.`name` ORDER BY `count` DESC LIMIT 0,10");
	
	$i=0;
	foreach ($images["images"] as &$value) {
		$i++;
		$tokens = explode('/', $value);
		$stmt->bindValue($i,($tokens[sizeof($tokens)-1]));
	}
	$i++;
	$stmt->bindValue($i,$languageto["id"]);
	$stmt->execute();
	
	$results = array();
	while ($row = $stmt->fetch()) {
		$results["results"][]=ucwords($row["name"]);	
	}
	
	echo json_encode($results);
}


//


?>