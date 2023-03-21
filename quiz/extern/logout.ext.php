<?php

session_start();
//cela déselectionne toutes nos sessions, elle devienne libre
session_unset();
//déconnecter totalement notre utilisateur en cours
session_destroy();

header("Location: ../home.php");
exit();



