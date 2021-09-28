<?php 
    session_start(); // Demarrage de la session
    session_destroy(); // Destruction de la session la session
    header('Location:index.php'); // Redirige vers index.php
    die();