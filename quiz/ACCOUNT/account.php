<?php
session_start();

require '../extern/dbh.ext.php';
$id = $_SESSION["userId"];

$sql = "SELECT bestScore FROM gamecard WHERE id=".$id;
$res = mysqli_query($conn,$sql);
if(!$res){
    echo $sql;
    exit();
}
$tab = mysqli_fetch_assoc($res);
$bestScore = $tab["bestScore"];

if($bestScore >1200){
    $sql = "UPDATE gamecard SET status='Expert' WHERE id=".$id;
    $res = mysqli_query($conn,$sql);
    if(!$res){
        echo $sql;
        exit();
    }
   
}else{
    $sql = "UPDATE gamecard SET status='beginner' WHERE id=".$id;
    $res = mysqli_query($conn,$sql);
    if(!$res){
        echo $sql;
        exit();
    }
}

$sql = "SELECT status FROM gamecard WHERE id=".$id;
$res = mysqli_query($conn,$sql);
if(!$res){
    echo $sql;
    exit();
}
$tab = mysqli_fetch_assoc($res);
$status = $tab["status"];


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="account.css">
    <title>SIGN UP</title>
</head>

<body>


    <div class="FORM">

        <div class="FORM-text">
            <header><a href="../home.php">Game Card</a></header>
            <?php
              if(isset($_GET['error'])){
                  if($_GET['error'] == "SUCCESS"){
                      echo "Bravo la mise à jour s'est bien passé";
                  }
              }
            
            
            ?>
           
            <img src="../img-site/bo.png" width="150px">
            <p>Best Score</p><br>
            <?php echo $bestScore; ?>
            <p>Status</p><br>
            <?php echo $status; ?>
            <h1>Account</h1>

            <form action="../extern/account.ext.php" method="post">

                <label>update name</label> <br>
                <input type="text" name="prenom" placeholder="Modifier votre prenom"> <br>


                <label>update username</label> <br>
                <input type="text" name="username" placeholder="Modifier votre nom d'utilisateur">

                <br>


                <button type="submit" name="validate-submit">Valider</button>



            </form>
            <form action="../extern/delete.ext.php" method="post">

                <button type="submit" name="delete-submit">Delete Account</button>
              
            </form>


        </div>

    </div>

</body>

</html>
