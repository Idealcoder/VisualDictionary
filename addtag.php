<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

include("scripts/db-connection.php"); 
include("scripts/settings.php");

$stmt = $dbh->prepare("INSERT INTO `imagetag`(`imageid`, `languageid`, `toogeneric`, `name`) VALUES ([value-1],[value-2],[value-3],[value-4])");
$stmt->bindParam(1, $_GET["imageid"]);
$stmt->bindParam(2, $language["id"]);
$stmt->bindParam(3, $_GET["toogeneric"]);
$stmt->bindParam(4, $_GET["name"]);
$stmt->execute();



header("Location: /".$language["acrro"]."/");
exit;
?>