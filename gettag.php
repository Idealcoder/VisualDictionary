<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

include("scripts/db-connection.php"); 
include("scripts/settings.php");

$stmt = $dbh->prepare("(SELECT NULL AS 'count',`images`.`url` AS 'url',`images`.`id` AS 'imagesid' FROM `images` LEFT JOIN `yrs-2013`.`imagetag` ON `images`.`id` = `imagetag`.`imageid` WHERE `imagetag`.`languageid`!=1 OR `imagetag`.`languageid` IS NULL  GROUP BY `images`.`id`)
UNION ALL
(SELECT COUNT(`imagetag`.`toogeneric`) AS 'count',`images`.`url`,`images`.`id` AS 'imagesid' FROM `images` LEFT JOIN `yrs-2013`.`imagetag` ON `images`.`id` = `imagetag`.`imageid` WHERE `imagetag`.`languageid`=1 GROUP BY `images`.`id` )  ORDER BY `count` ASC");
$stmt->bindParam(1, $language["id"]);
$stmt->execute();

$image = $stmt->fetch();

echo json_encode($image);

?>