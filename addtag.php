<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

include("scripts/db-connection.php"); 
include("scripts/settings.php");

$stmt = $dbh->prepare("INSERT INTO `imagetag`(`imageid`, `languageid`, `toogeneric`, `name`) VALUES (?,?,?,?)");
$stmt->bindParam(1, $_POST["imageid"]);
$stmt->bindParam(2, $language["id"]);
$stmt->bindParam(3, $_POST["toogeneric"]);
$stmt->bindParam(4, $_POST["name"]);
$stmt->execute();

    $errors = $stmt->errorInfo();
    echo($errors[2]);

//localhost/UK/addtag.php?imageid=3&toogeneric=0&name=Many Apples!
//header("Location: /".$language["acrro"]."/");
//exit;
?>