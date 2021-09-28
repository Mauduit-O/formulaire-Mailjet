<?php 
    session_start(); // Démarrage de la session
    require_once 'config.php'; // Inclut la connexion à la base de données

    if(!empty($_POST['email']) && !empty($_POST['password'])) // Verifie que les champs email et password ne sont pas vide
    {
        // Patch XSS
        $email = htmlspecialchars($_POST['email']); 
        $password = htmlspecialchars($_POST['password']);
        
        $email = strtolower($email); // transforme l'email en minuscule pour éviter les doublons
        
        // Verifie si l'utilisateur est inscrit dans la table utilisateurs
        $check = $bdd->prepare('SELECT pseudo, email, password, token FROM utilisateurs WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();
        
        

        // Si > à 0 alors l'utilisateur existe
        if($row > 0)
        {
            // Si le mail est au bon format
            if(filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                // Si le mot de passe est correcte
                if(password_verify($password, $data['password']))
                {
                    // On créer la session et on redirige sur user.php
                    $_SESSION['user'] = $data['token'];
                    header('Location: user.php');
                    die();
                }else{ header('Location: index.php?login_err=password'); die(); }
            }else{ header('Location: index.php?login_err=email'); die(); }
        }else{ header('Location: index.php?login_err=already'); die(); }
    }else{ header('Location: index.php'); die();} 