<?php
// Authentification Api mailjet
require '../vendor/autoload.php';
  use \Mailjet\Resources;
    $mj = new \Mailjet\Client('47992f7c12d5b354d4bd09db0ab6c20e', 'daf383d0bca2b05a8a7d833bf11ae1c7',true,['version' => 'v3.1']);

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


        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $body = [
            'Messages' => [
        [
        'From' => [
            'Email' => "oum-el-khaire.mauduit@hetic.net",
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

                Votre agence nous a sollicité afin vous adresser une offre dans le cadre de votre projet.
                
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

        $body = [
            'Messages' => [
        [
        'From' => [
            'Email' => "oum-el-khaire.mauduit@hetic.net",
            'Name' => "Dimo"
        ],
        'To' => [
            [
                'Email' => "fkulczak@dimo-diagnostic.net",
                'Name' => "Dimo"
            ]
                ],
                'Subject' => "Nouveau lead",
                'TextPart' => 
                "Nouveau lead !

                Source prospect : Agence  
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
            $response->success();
            echo "Email envoyé avec succès !";
        }
        else{
            echo "Email non valide";
        }

    }else {
        heade('Location:index.php');
    }    
    header('Location:user.php?reg_err=form');
    die();
?>



