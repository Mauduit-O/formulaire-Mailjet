<?php

    // Connexion à la base de donnée
    try {
        $bdd = new PDO ('mysql:host=localhost;dbname=testoum;charset=utf8', "'root'", "root");
    }catch(Exception $e)
    {
        die('Erreur'.$e->getMessage());
    }