<?php 
    require_once 'config.php'; // Connexion à la base de données
    // si la session n'existe pas , redirection vers l'index
    
    if(!isset($_GET['token'])){
        header('Location:index.php');
        die();
    }

    // Récupération du nom de l'utilisateur
    // $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
    // $req->execute($_GET['token']);
    // $data = $req->fetch();  
    $token = $_GET['token'];  
    $_SESSION['user'] = $data['token'];   
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token ="' . $token.'"');
    $req->execute();
    $data = $req->fetch();
    $pseudo = $data['pseudo'];
    
    // Création des alertes
    if(isset($_GET['reg_err']))
    {
        $err = htmlspecialchars($_GET['reg_err']);
        
        switch($err)
        {
            case 'form':
                ?>
                    <div class="alert-form">
                        Nous avons bien reçu votre demande, vérifiez vos mails !
                    </div>
                <?php
            break;

            case 'email':
            ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> email non valide
                </div>
            <?php
            break;
        }
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/user.css">
    <title>Espace client</title>
  </head>

  <body>
        <div class="header-user">
            <div>
                <img class="logo-dimo" src="../assets/logo/dimo.png" alt="Logo Dimo">   
            </div>   
            <div class="container-disconnected">
                <div class="content-disconnected">
                        <a href="deconnexion.php" class="btn-disconnected">Deconnexion</a>
                </div>
            </div>
        </div>    

        <div class="container-page-diagnostic">
            <section class="container-diagnostic">    
                <div class="container-title">
                    <h1 class="title-diagnostic">Bonjour <?php echo $pseudo['pseudo']; ?> , </br> Votre diagnostic en un clic</h1>
                    <p class="text-ino-diagnostic">Les équipes d'experts de Dimo sont spécialisées et certifiées pour réaliser vos diagnostics immobiliers.</p>
                </div>

                <div class="container-more-info-diagnostic">
                    <div class="content-more-info-diagnostic">
                        <img class="icon-info-diagnostic" src="../assets/icon/country.svg" alt="Icon France">
                        <p>Partout en france</p>
                    </div>
                    <div class="content-more-info-diagnostic">
                        <img class="icon-info-diagnostic"  src="../assets/icon/euro.svg" alt="Icon Euro">
                        <p>Plus de 150 € d’economie </p>
                    </div>
                    <div class="content-more-info-diagnostic">
                        <img class="icon-info-diagnostic" src="../assets/icon/24h.svg" alt="Icon 24 heures">
                        <p>Intervention sous 24h </p>
                    </div>
                    <div class="content-more-info-diagnostic">
                        <img class="icon-info-diagnostic" src="../assets/icon/satisfaction.svg" alt="Icon satisfaction">
                        <p>97 % de taux de satisfaction</p>
                    </div>
                </div>

                <div>
                    <h1  class="title-client">Ils nous ont fait confiance</h1>
                    <div class="img-client">
                        <div><img class="logo-client" src="../assets/logo/nexity.png" alt="Logo Nexity"></div>
                        <div> <img class="logo-client" src="../assets/logo/orpi.png" alt="Logo Orpi"></div>
                        <div><img class="logo-client" src="../assets/logo/iad.png" alt="Logo Iad"></div>
                        <div><img class="logo-client" src="../assets/logo/stephanePlaza.png" alt="Logo Stephane Plaza"></div>
                        <div> <img class="logo-client" src="../assets/logo/Century21.png" alt="Logo Century 21"></div>
                    </div>
                </div>
            </section>

            <section class="container-form-diagnostic">    
                <div class="header-form-diagnostic">
                    
                    <h1 class="title-header-form ">Faites nous confiance, gagnez du temps !</h1>
                
                </div>
                <form class="form-diagnostic" action="contact.php?token=<?= $_GET['token']?>" method="POST">
                    <div class="container-form-input-diagnostic">
                        <div class="container-input-form">
                            <p class="content-input-form">
                            <label class="label-form" for="surname">Nom <span class="label-form-required">*</span></label>
                            <input class="input-form-diagnostic" name="surname" type="text" placeholder="" required/>
                            </p>
                        </div>
                        <div class="container-input-form">
                            <p class="content-input-form">
                            <label class="label-form" for="firstname">Prénom <span class="label-form-required">*</span></label>
                            <input class="input-form-diagnostic" name="firstname" type="text" placeholder="" required/>
                            </p>
                        </div>
                    </div>

                    <div class="container-input-form">
                        <p class="content-input-form">
                        <label class="label-form" for="email">Email <span class="label-form-required">*</span></label>
                        <input class="input-form-diagnostic input-form-diagnostic--email" name="email" type="text" placeholder="" required/>
                        </p>
                    </div>

                    <div class="container-form-input-diagnostic">
                        <div class="container-input-form">
                            <p class="content-input-form">
                            <label class="label-form" for="phone">Téléphone <span class="label-form-required">*</span></label>
                            <input class="input-form-diagnostic" name="phone" type="tel" placeholder="" required/>
                            </p>
                        </div>
                        <div class="container-input-form">
                            <p class="content-input-form"> 
                            <label class="label-form" for="address">Adresse <span class="label-form-required">*</span></label>
                            <input class="input-form-diagnostic" name="address" type="text" placeholder="" required/>
                            </p>
                        </div>
                    </div>

                    <div class="container-form-input-diagnostic">
                        <div class="container-input-form">
                            <p class="content-input-form">
                            <label class="label-form" class="label-form" for="code">Code Postale <span class="label-form-required">*</span></label>
                            <input class="input-form-diagnostic" name="code" type="tel" placeholder="" required/>
                            </p>
                        </div>
                        <div class="container-input-form">
                            <p class="content-input-form">
                            <label class="label-form" for="city">Ville <span class="label-form-required">*</span></label>
                            <input class="input-form-diagnostic" name="city" type="text" placeholder="" required/>
                            </p>
                        </div>
                    </div>

                    <div class="container-form-input-choice">
                        <div>
                            <label class="label-form" for="property-type">Type de bien <span class="label-form-required">*</span></label>
                            <select style="font-family: Helvetica; color: #D7D3FF; padding-left: 10px" class="input-form-diagnostic" name="property-type">
                                <option value="">Veuillez selectioner</option>
                                <option value="Bien de type A">Choix 1 : Bien de type A</option>
                                <option value="Bien de type B">Choix 2 : Bien de type B</option>
                            </select>
                        </div>

                        <div>
                            <label class="label-form" for="year">Année de construction <span class="label-form-required">*</span></label>
                            <select style="font-family: Helvetica; color: #D7D3FF; padding-left: 10px" class="input-form-diagnostic" name="year">
                                <option class="titi" value="">Veuillez selectioner</option>
                                <option value="Avant 1949">Avant 1949</option>
                                <option value="1949 - 1997">1949 - 1997</option>
                                <option value="Apres 1997">Apres 1997</option>
                            </select>
                        </div>
                    </div>

                    <div class="container-btn-form">
                        <button class="btn-form-submit" type="submit">Demander votre devis</button>
                    </div>

                </form>   
            </section>    
        </div>
  </body>
</html>