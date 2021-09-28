<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/index.css">
            <title>Connexion</title>
        </head>
        <body>
        
        <div class="login-form">
             <?php 
                // Créations des alertes
                if(isset($_GET['login_err']))
                {
                    $err = htmlspecialchars($_GET['login_err']);

                    switch($err)
                    {
                        case 'password':
                        ?>
                            <div class="alert alert-danger">
                                Erreur : le mot de passe est incorrect
                            </div>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <div class="alert alert-danger">
                                Erreur : le email est incorrect
                            </div>
                        <?php
                        break;

                        case 'already':
                        ?>
                            <div class="alert alert-danger">
                                Erreur : le compte n'existe pas
                            </div>
                        <?php
                        break;
                    }
                }
                ?> 

                <img class="logo-dimo" src="../assets/logo/dimo.png" alt="Logo Dimo">

                <section class="container-register">
                    <h1 class="title-register">Se connecter</h1>
                <form action="connexion.php" method="post">
                    <div class="container-input">
                        <p class="container-iconandinput">
                        <label for="email"></label>
                        <img class="icon-login icon-mail" src="../assets/icon/user.svg" alt="icon email">
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
                    <div class="container-btn">
                        <button class="btn-submit" type="submit"></a>Valider</button>
                    </div>
                </form>
                <p class="text-link-register"><a class="link-register" href="inscription.php">Je n'ai pas de compte.</a></p>
                </section>

                <article class="container-img">
                    <img class="register-img" src="../assets/img/diagnostic-immobilier-obligatoire-france-removebg-preview.png" alt="">
                </article>       
        </body>
</html>