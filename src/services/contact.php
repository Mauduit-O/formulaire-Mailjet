<?php
// Authentification Api mailjet
require_once  './config.php';
require '../vendor/autoload.php';
  use \Mailjet\Resources;
  $mj = new \Mailjet\Client('', '',true,['version' => 'v3.1']);
    $token = $_GET['token'];  
    $_SESSION['user'] = $data['token']; 


    // Si les variables existent et qu'elles ne sont pas vides
    if(!empty($_POST['surname']) && !empty($_POST['firstname']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['address']) && !empty($_POST['code']) && !empty($_POST['city']) && !empty($_POST['property-type']) && !empty($_POST['year']) ){
        $surname = htmlspecialchars($_POST['surname']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $email = htmlspecialchars($_POST['email']); 
        $phone = htmlspecialchars($_POST['phone']);
        $address = htmlspecialchars($_POST['address']);
        $code = htmlspecialchars($_POST['code']);
        $city = htmlspecialchars($_POST['city']);
        $propertyType = htmlspecialchars($_POST['property-type']);
        $year = htmlspecialchars($_POST['year']);
        
        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token ="' . $token.'"');
        $req->execute();
        $data = $req->fetch();
        $dataEmail = $data['email'];
        $pseudo = $data['pseudo'];


        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $body = [
            'Messages' => [
        [
        'From' => [
            'Email' => "melproject310@gmail.com",
            'Name' => "Dimo"
        ],
        'To' => [
            [
                'Email' => "oum-el-khaire.mauduit@hetic.net",
                'Name' => "Dimo"
            ]
                ],
                'Subject' => "Nouveau lead",
                'TextPart' => 
                "Nouveau lead ! 

                Source prospect : $pseudo   

                Son client 
                Nom : $surname    
                Prénom : $firstname    
                Adresse : $address, $code, $city    
                Téléphone : $phone    
                Email : $email    
                Type de bien : $propertyType    
                Année de construction : $year    
                Offre : 299 €", 
            ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);

        $body = [
            'Messages' => [
        [
        'From' => [
            'Email' => "melproject310@gmail.com",
            'Name' => "Dimo"
        ],
        'To' => [
            [
                'Email' => "$dataEmail",
                'Name' => "Dimo"
            ]
                ],
                'Subject' => "Nouveau lead",
                'TextPart' => 
                "Nous avons bien reçu votre demande. Veuillez trouver le récapitulatif ci dessous : 
                
                Source prospect : $pseudo   

                Votre client
                Nom : $surname    
                Prénom : $firstname    
                Adresse : $address, $code, $city    
                Téléphone : $phone    
                Email : $email    
                Type de bien : $propertyType    
                Année de construction : $year
                Diag à réaliser : DPE, AM, TER, PB  
                Offre : 299 €", 
            ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);

        $body = [
            'Messages' => [
        [
        'From' => [
            'Email' => "melproject310@gmail.com",
            'Name' => "Dimo"
        ],
        'To' => [
            [
                'Email' => "$email",
                'Name' => "Dimo"
            ]
                ],
                'Subject' => "Demande de diagnostic",
                'TextPart' => 
                "Bonjour $surname $firstname,

                $pseudo nous a sollicité afin vous adresser une offre dans le cadre de votre projet.
                
                Pour votre projet immobilier pour le bien situé à cette adresse : $address, $code, $city
                Il vous faudra réaliser : DPE, AM, TER, PB 
                Notre offre pour cette prestation : 299 € TTC
                
                Nous restons à votre disposition pour des informations complémentaires. 
                
                Cordialement. 
                DIMO Diagnostic", 
            ]
            ]
        ];

            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success();
            echo "Email envoyé avec succès !";
        }
        else{
            echo "Email non valide";
        }

    }else {
        header('Location:index.php');
    }    
    // $chemin = "user.php?token=".$data['token']."?reg_err=form";
    header("Location: user.php?token=".$data['token']."&reg_err=form");
    die();
?>
