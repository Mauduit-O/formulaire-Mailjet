   <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/index.css">
            <title>Inscription</title>
        </head>
        <body>
        
            <?php 
                // Creation des alertes
                if(isset($_GET['reg_err']))
                {
                    $err = htmlspecialchars($_GET['reg_err']);

                    switch($err)
                    {
                        case 'success':
                        ?>
                            <div class="alert alert-success">
                                Inscription réussie !
                            </div>
                        <?php
                        break;

                        case 'password':
                        ?>
                            <div class="alert alert-danger">
                                Erreur : le mot de passe n'est pas identique
                            </div>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <div class="alert alert-danger">
                                Erreur : le mail n'est pas valide
                            </div>
                        <?php
                        break;

                        case 'email_length':
                        ?>
                            <div class="alert alert-danger">
                                Erreur : le mail est trop long
                            </div>
                        <?php 
                        break;

                        case 'pseudo_length':
                        ?>
                            <div class="alert alert-danger">
                                Erreur : le pseudo est trop long
                            </div>
                        <?php 
                        case 'already':
                        ?>
                            <div class="alert alert-danger">
                                Erreur : le compte existe deja 
                            </div>
                        <?php 

                    }
                }
            ?>
            

            <div class="login-form">
                <img class="logo-dimo" src="../assets/logo/dimo.png" alt="Logo Dimo">

                <section class="container-register">
                    <h1 class="title-register">S'inscrire</h1>
                    <form action="inscription-traitement.php" method="post">
                        <div class="container-input">
                            <p class="container-iconandinput">
                            <label for="user"></label>
                            <img class="icon-login icon-user" src="../assets/icon/user.svg" alt="icon user">
                            <input class="input inputUser" name="pseudo" type="text" placeholder="Nom" required="required" autocomplete="off"/>
                            </p>
                        </div>
                        <div class="container-input">
                            <p class="container-iconandinput">
                            <label for="email"></label>
                            <img class="icon-login icon-mail" src="../assets/icon/mail.svg" alt="icon email">
                            <input class="input input-mail" name="email" type="email" placeholder="Email" required="required" autocomplete="off"/>
                            </p>
                        </div>
                        <div class="container-input">
                            <p class="container-iconandinput">
                                <label for="password"></label>
                                <img class="icon-login icon-password" src="../assets/icon/password.svg" alt="icon user">
                                <input class="input input-password" name="password" type="password" placeholder="Mot de passe" required="required" autocomplete="off"/>    
                            </p>
                        </div>
                        <div class="container-input">
                            <p class="container-iconandinput">
                                <label for="password"></label>
                                <img class="icon-login icon-password" src="../assets/icon/password.svg" alt="icon user">
                                <input class="input input-password" name="password_retype" type="password" placeholder="Retaper le mot de passe" required="required" autocomplete="off"/>    
                            </p>
                        </div>
                        <div class="container-btn">
                            <button class="btn-submit" type="submit">Valider</button>
                        </div>
                    </form>
                    <p class="text-link-register"><a class="link-register" href="connexion.php">Déja un compte, se connecter.</a></p>
                </section>

                <article class="container-img">
                        <img class="register-img" src="../assets/img/diagnostic-immobilier-obligatoire-france-removebg-preview.png" alt="">
                </article>      
            </div>
        </body>
    </html>