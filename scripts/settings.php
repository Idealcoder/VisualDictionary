<?php 
$stmt = $dbh->prepare("SELECT * FROM `languages` WHERE `accro`= ?");
$stmt->bindValue(1, strtolower($_GET["lan"]));
$stmt->execute();

if ($stmt->rowCount()==0) {
	header("Location: /uk/");
	exit();
}

$language = $stmt->fetch();
  
//$language["id"]
//$language["accro"]
//$language["fulltext"]
//$language["url"]

$stmt=$dbh->prepare("SELECT * FROM `translations` WHERE `languageid`= ?");
$stmt->bindParam(1, $language["id"]);
$stmt->execute();

$messages = array();
while ($row = $stmt->fetch()) {
    $messages[$row["instructionid"]]=$row["text"];
  }
  

?>