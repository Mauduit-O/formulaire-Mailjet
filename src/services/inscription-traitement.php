
<?php 
    require_once 'config.php'; // Connexion à la base de donnée

    // Si les variables existent et qu'elles ne sont pas vides
    if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_retype']))
    {
        // Patch XSS
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $password_retype = htmlspecialchars($_POST['password_retype']);

        // L'utilisateur existe ?
        $check = $bdd->prepare('SELECT pseudo, email, password FROM utilisateurs WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();

        $email = strtolower($email); // Lettres majuscule en minuscule
        
        // Si la requete renvoie un 0 alors l'utilisateur n'existe pas 
        if($row == 0){ 
            if(strlen($pseudo) <= 100){ // Verifie que la longueur du pseudo <= 100
                if(strlen($email) <= 100){ // Verifie que la longueur du mail <= 100
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){ // Si l'email est de la bonne forme
                        if($password === $password_retype){ // Si les deux mdp saisis sont identiques

                            // Hash le mot de passe avec Bcrypt
                            $cost = ['cost' => 12];
                            $password = password_hash($password, PASSWORD_BCRYPT, $cost);
                            
                            // Stock l'adresse IP
                            $ip = $_SERVER['REMOTE_ADDR']; 
                            $token = bin2hex(openssl_random_pseudo_bytes(64));

                            // Insère dans la base de données
                            $insert = $bdd->prepare('INSERT INTO utilisateurs(pseudo, email, password, ip, token) VALUES(:pseudo, :email, :password, :ip, :token)');
                            $insert->execute(array(
                                'pseudo' => $pseudo,
                                'email' => $email,
                                'password' => $password,
                                'ip' => $ip,
                                'token' => $token
                            ));
                            // Redirige avec le message de succès
                            header('Location:inscription.php?reg_err=success');
                            die();
                        }else{ header('Location: inscription.php?reg_err=password'); die();}
                    }else{ header('Location: inscription.php?reg_err=email'); die();}
                }else{ header('Location: inscription.php?reg_err=email_length'); die();}
            }else{ header('Location: inscription.php?reg_err=pseudo_length'); die();}
        }else{ header('Location: inscription.php?reg_err=already'); die();}
    }
