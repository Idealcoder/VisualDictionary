<?php 
$stmt = $dbh->prepare("SELECT * FROM `languages` WHERE `accro`= ?");
$stmt->bindParam(1, $_GET["lan"]);
$stmt->execute();


if ($stmt->rowCount()==0) {
	header("Location: /UK/");
	exit();
}
 
$language = $stmt->fetch();

 print_r($language);

  
//$language["id"]
//$language["accro"]
//$language["fulltext"]
//$language["url"]

$stmt=$dbh->prepare("SELECT * FROM `translations` WHERE `languageid`= ?");
$stmt->bindParam(1, $language["id"]);
$stmt->execute();

$messages = array();
while ($row = $stmt->fetch()) {
    $messages[$row["id"]]=$row["texts"];
  }
  
  print_r($messages);

?>