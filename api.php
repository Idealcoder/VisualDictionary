<?php 
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include("$root/scripts/db-connection.php"); 
include("$root/scripts/settings.php");

switch (strtolower($_GET["type"])) {
// **Misc Requests**
    case "gettag":
		//this is to find out what image the site should be asking the user to tag
        $stmt = $dbh->prepare("(SELECT NULL AS 'count',`images`.`url` AS 'url',`images`.`id` AS 'imagesid' FROM `images` LEFT JOIN `yrs-2013`.`imagetag` ON `images`.`id` = `imagetag`.`imageid` WHERE `imagetag`.`languageid`!=1 OR `imagetag`.`languageid` IS NULL  GROUP BY `images`.`id`)
UNION ALL
(SELECT COUNT(`imagetag`.`toogeneric`) AS 'count',`images`.`url`,`images`.`id` AS 'imagesid' FROM `images` LEFT JOIN `yrs-2013`.`imagetag` ON `images`.`id` = `imagetag`.`imageid` WHERE `imagetag`.`languageid`=1 GROUP BY `images`.`id` )  ORDER BY `count` ASC");
		$stmt->bindParam(1, $language["id"]);
		$stmt->execute();
		$image = $stmt->fetch();

		echo json_encode($image);
        break;
    case "addtag":
		//this is to add a tag, run on submit.
		$stmt = $dbh->prepare("INSERT INTO `imagetag`(`imageid`, `languageid`, `toogeneric`, `name`) VALUES (?,?,?,?)");
		$stmt->bindParam(1, $_GET["imageid"]);
		$stmt->bindParam(2, $language["id"]);
		$stmt->bindParam(3, $_GET["toogeneric"]);
		$stmt->bindParam(4, $_GET["name"]);
		$stmt->execute();
		
		header("Location: index2.php"); //currently not working off ajax.
        break;
//**API Start**
    case "searchimages":
		//this is to search for images with the same meaning as the query
		$stmt=$dbh->prepare("SELECT `images`.`url` FROM `images` LEFT JOIN `yrs-2013`.`imagetag` ON `images`.`id` = `imagetag`.`imageid` WHERE `imagetag`.`name` LIKE ? GROUP BY `images`.`id`");
		$stmt->bindValue(1,"%".$_GET["query"]."%");
		$stmt->execute();
		
		$imageresults = array();
		while ($row = $stmt->fetch()) {
			$imageresults["images"][]="http://".$_SERVER["SERVER_NAME"]."/static/img/tags/".$row["url"];	
		}
	echo json_encode($imageresults);
        break;

}


//


?>