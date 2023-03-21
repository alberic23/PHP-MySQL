<?php 

$servername = "localhost";
$dbusername = "root";
$dbpassword = "root";
$dbname = "quizdb";

//PHP procédural
$conn = mysqli_connect($servername,$dbusername,$dbpassword,$dbname,3308);

if(!$conn){
    die("Connection échouée!" .mysqli_connect_error());
}



?>