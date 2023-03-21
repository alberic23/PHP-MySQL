
<? php
    
session_start();
require '../extern/dbh.ext.php';
$id = $_SESSION["userId"];
    
$theme = $_GET["theme"];
$sql = "SELECT * FROM heuf WHERE theme='".$theme."' AND id=".$id;
$res = mysqli_query($conn,$sql);

if(!res){
    echo $sql;
    exit();
}

$tab = mysqli_fetch_assoc($res);
$score = $tab["currentore"];
$nbrErreur = $tab["nbrErreur"];
$ordretanv = $tab["ordretanv"];

$sql1 = "SELECT * FROM gamecard WHERE id=".$id;
$res1 = mysqli_query($conn,$sql1);

if(!res1){
    echo $sql1;
    exit();
}

$tab1 = mysqli_fetch_assoc($res1);
$bestScore = $tab["bestScore"];

if($score>$bestScore){
    $sql = "UPDATE gamecard SET bestScore=".$score." WHERE id=".$id;
    $res = mysqli_query($conn,$sql);

if(!res){
    echo $sql;
    exit();
}
    
    
}

$sql = "UPDATE heuf SET ordreActuel='".ordretanv."', ordretanv=NULL, nbrErreur=0, currentore=0 WHERE theme='".$theme."' AND id=".$id;
$res = mysqli_query($conn,$sql);

if(!res){
    echo $sql;
    exit();
}




?>



<!DOCTYPE html>

<html>

<head>
    <title>Jeu Principal</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="endofthegame.css">

</head>

<body>
    <div class="logo">
        <a href="../home.php" style="text-decoration:none;">Game Card</a>
    </div>

    <div class="gif" style="text-align:center">
        <img src="../img-site/original%20(1).gif" width="400px;">

    </div>
    <div class="p" style="text-align:center;font-style:italic;margin-bottom:10px">
        END OF THE GAME!<br><br>
        SCORE: <?php   echo $score; ?>
       
        <br>
        Vous avez fait<?php echo $nbrErreur; ?>
         erreurs!<br>
        
    </div>
    <div class="endBack">
        <a href="jeu-principal.php" style="text-decoration:none;margin-top:10px;">BACK HOME</a>
    </div>






</body>


</html>
