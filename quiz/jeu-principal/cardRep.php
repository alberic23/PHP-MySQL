<?php

    session_start();
    require '../extern/dbh.ext.php';

    require 'afficheCarte.php';
    $theme = $_GET["theme"];
    $id = $_SESSION["userId"];
    
    
    // POUR LES CARTES 

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $sql = "SELECT * FROM heuf WHERE id=".$id." AND theme='".$theme."';";
    $res = mysqli_query($conn,$sql);
    
    if(!$res){
        header("Location: cardRep.php?error=sqlerror");
        exit();
}
    $tab = mysqli_fetch_assoc($res);
    $ordreActuel = $tab["ordreActuel"];
    $ordretanv = $tab["ordretanv"];
    $nbrErreur = $tab["nbrErreur"];
    $currentore = $tab["currentore"];
    $compteur = $tab["compteur"];
    
    $ordreActuelexp = explode("/",$ordreActuel);
    $a = $ordreActuelexp[0];
    
    $sql = "SELECT * FROM ".$theme." WHERE id=".$a;
    $res = mysqli_query($conn,$sql);
    if(!$res){
        header("Location: cardRep.php?error=sqlerror");
        exit();
}  
    $tab = mysqli_fetch_assoc($res);
    $reponse = $tab["reponse"]; 
    $reponse = strtolower($reponse);
    $type = $tab["type"];
    $level = $tab["level"];
    
    
    if(isset($_POST["prop"])){
        $repClient = $_POST["prop"];
        $repClient = strtolower($repClient);
        
    }else if(isset($_POST["reponse"])){
        
            $repClient = $_POST["reponse"];
            $repClient = strtolower($repClient);

    }else{
        $repClient = "";
    }
    
    
    if($repClient!==$reponse){
        if($type=="qcm"){
            $nbrErreur++;
            $ordretanv =$a."/".$ordretanv;
            $currentore -=30; 
            
        }else{
            $nbrErreur++;
            $ordretanv =$a."/".$ordretanv;
            $currentore -=20; 
            
        }
    }else{
        if($type=="qcm"){
            if($level==1){
                $currentore +=35;
                $ordretanv = $ordretanv.$a."/";
            }else if($level ==2){
                  $currentore +=85;
                  $ordretanv = $ordretanv.$a."/";
            }else{
                $currentore +=250;
                $ordretanv = $ordretanv.$a."/";
            }
            
        }else{
            if($level==1){
                $currentore +=65;
                $ordretanv = $ordretanv.$a."/";
            }else if($level ==2){
                  $currentore +=165;
                  $ordretanv = $ordretanv.$a."/";
            }else{
                $currentore +=550;
                $ordretanv = $ordretanv.$a."/";
            }
        }
    }

    $newOrdreActuel = [];
    for($i=1;$i<count($ordreActuelexp);$i++){
        $newOrdreActuel[$i-1]=$ordreActuelexp[$i];
    }
    
    $ordreActuel = implode("/",$newOrdreActuel);
    $compteur++;
    
    
    $sql = "UPDATE heuf SET ordreActuel='".$ordreActuel."', ordretanv='".$ordretanv."', nbrErreur=".$nbrErreur.", currentore=".$currentore.", compteur=".$compteur."  WHERE id=".$id" AND theme='".$theme."';";
    $res = mysqli_query($conn,$sql);
    if(!$res){
        header("Location: cardRep.php?error=sqlerror");
        exit();
}
    
    
    if(empty($ordreActuel)){
        header("Location: endofthegame.php?theme=".$theme);
        exit();
    }
    
       
}






























// INITIALISATION DE LA PREMIERE CARTE

$sql = "SELECT * FROM heuf WHERE id=".$id." AND theme='".$theme."';";
$res = mysqli_query($conn,$sql);


if(!$res){
     header("Location: cardRep.php?error=sqlerror");
     exit();
}

if(mysqli_num_rows($res)==0){
    
    $ordretanv = "";
    $ordreActuel = "";
    
    
    
    $sql = "SELECT COUNT(*) FROM ".$theme;
    $res = mysqli_query($conn,$sql);
    if(!$res){
        echo $sql;
        exit();
        
    }
    
        $tab = mysqli_fetch_assoc($res);
        $taille = $tab["COUNT(*)"];

        for($i=1;$i<=$taille;$i++){
            $ordreActuel.=$i."/"; //$ordreActuel=$ordreActuel.$i."/";
        }

        $sql = "INSERT INTO heuf(id,ordreActuel,ordretanv,theme,nbrErreur,currentore,compteur)
        VALUES(".$id.",'".$ordreActuel."','".ordretanv."','".$theme."',0,0,1);";
        $res = mysqli_query($conn,$sql);
    
        if(!$res){
            echo $sql;
            exit();
        }    
    
}

 
$sql = "SELECT * FROM heuf WHERE id=".$id." AND theme='".$theme."';";
$res = mysqli_query($conn,$sql);
if(!$res){
    header("Location: cardRep.php?error=sqlerror");
    exit();
}

$tab = mysqli_fetch_assoc($res);
$ordreActuel = $tab["ordreActuel"];


$ordreActuelexp = explode("/",$ordreActuel);
$a = $ordreActuelexp[0];
$sql = "SELECT question, type FROM ".$theme."  WHERE id=".$a;
$res = mysqli_query($conn,$sql);
if(!$res){
    header("Location: cardRep.php?error=sqlerror");
    exit();
}

$tab = mysqli_fetch_assoc($res);
$question = $tab["question"];
$type = $tab["type"];

if($type == "qcm"){
$sql = "SELECT * FROM propositions  WHERE theme='".$theme."' AND
questionId=".$a;
$res = mysqli_query($conn,$sql);
if(!$res){
    header("Location: cardRep.php?error=sqlerror");
    exit();
}
    $tab = mysqli_fetch_assoc($res);
    $prop1 = $tab["proposition1"];
    $prop2 = $tab["proposition2"];
    $prop3 = $tab["proposition3"];
    
   afficherCarteProp($question,$prop1,$prop2,$prop3,$theme,$a,$compteur); 
    
}else{
    afficherCarteTexte($question,$theme,$a,$compteur);
}


?>





