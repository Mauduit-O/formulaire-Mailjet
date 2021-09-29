<?php
// Authentification Api mailjet
require_once  './config.php';
require '../vendor/autoload.php';
  use \Mailjet\Resources;
  $mj = new \Mailjet\Client('01bab1985513a65ed340dfa7ca81a392', '1b99eaedd47ba43b6247ec6d967c48fb',true,['version' => 'v3.1']);

    $token = $_GET['token'];  
    $_SESSION['user'] = $data['token']; 

    //  Cette fonction défini le prix en fonction du choix selectioné
    $priceFunction = function ()
    {
        $propertyType = htmlspecialchars($_POST['property-type']);
        $year = htmlspecialchars($_POST['year']);
        $priceTypeAVeryOld = '299';
        $priceTypeBVeryOld = '249';
        $priceTypeAOld = '199';
        $priceTypeBOld = '149';
        $priceTypeARecent = '99';
        $priceTypeBRecent = '49';

        $yearVeryOld = $year=="Avant 1949";
        $yearOld = $year=="1949 - 1997";
        $yearRecent = $year=="Apres 1997";

        $propertyTypeA = $propertyType=="Bien de type A";
        $propertyTypeB = $propertyType=="Bien de type B";


        if ($yearVeryOld & $propertyTypeA)
        {
            return ($priceTypeAVeryOld);
        } 
        elseif ($yearVeryOld & $propertyTypeB)
        {
            return ($priceTypeBVeryOld);
        } 
        elseif ($yearOld & $propertyTypeA)
        {
            return ($priceTypeAOld);
        }  
        elseif ($yearOld & $propertyTypeB)
        {
            return ($priceTypeBOld);
        }
        elseif ($yearRecent & $propertyTypeA)
        {
            return ($priceTypeARecent);
        
        } else
        {
            return ($priceTypeBRecent);
        }
    };
    echo  $price = $priceFunction();


    //  Cette fonction défini le diagnostic à effectuer en fonction du choix selectioné
    $diagnosticFunction = function ()
    {
        $propertyType = htmlspecialchars($_POST['property-type']);
        $year = htmlspecialchars($_POST['year']);

        $yearVeryOld = $year=="Avant 1949";
        $yearOld = $year=="1949 - 1997";
        $yearRecent = $year=="Apres 1997";

        
        $diagnosticVeryOld = 'DPE, AM, TER, PB';
        $diagnosticOld = 'DPE, AM, TER';
        $diagbosticOldRecent = 'DPE, TER';

        if ($yearVeryOld )
        {
            return ($diagnosticVeryOld);
        
        } elseif ($yearOld) {

            return ($diagnosticOld);

        }else {
            return ($diagbosticOldRecent);
        } 
        
    };
    echo $diagnostic = $diagnosticFunction();



    //  Cette fonction défini la durée du diagnostic en fonction du choix selectioné
    $timeFunction = function ()
    {
        $year = htmlspecialchars($_POST['year']);
        $veryOld= $year=="Avant 1949";
        $old= $year=="1949 - 1997";
        $recent = $year=="Apres 1997";

        $timeVeryOld = '1 h 30';
        $timeOld = '1 h 00';
        $timeVeryRecent = '00 h 30';


        if ($veryOld)
        {
            return ($timeVeryOld);
        
        } elseif ($old) {

            return ( $timeOld);
        }else {
            return ($timeVeryRecent);
        } 
        
    };  
    echo $time = $timeFunction();


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
                Offre : $price €", 
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
                'Subject' => "Confirmation devis",
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
                Diag à réaliser : $diagnostic 
                Durée: $time
                Offre : $price €", 
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
                Il vous faudra réaliser : $diagnostic pour une durée de $time
                Notre offre pour cette prestation : $price € TTC
                
                
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
    header("Location: user.php?token=".$data['token']."&reg_err=form");
    die();
?>
