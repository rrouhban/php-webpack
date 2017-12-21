<?php
/**
 * Created by PhpStorm.
 * User: ANAHEIM
 * Date: 08/12/2017
 * Time: 12:26
 */
require_once(dirname(__FILE__) . '/MailingHandler.class.php');
HtmlData::setTitle("Mon titre de la mort qui déchire !");
$error = false;

$inputs = array();
$input['civility'] = array(
    'value' => (isset($_POST['civility'])) ? htmlspecialchars(stripslashes(trim($_POST['civility']))) : '',
    'error' => false
);
$input['lastName'] = array(
    'value' => (isset($_POST['lastName'])) ? htmlspecialchars(stripslashes(trim($_POST['lastName']))) : '',
    'error' => false
);
$input['firstName'] = array(
    'value' => (isset($_POST['firstName'])) ? htmlspecialchars(stripslashes(trim($_POST['firstName']))) : '',
    'error' => false
);
$input['function'] = array(
    'value' => (isset($_POST['function'])) ? htmlspecialchars(stripslashes(trim($_POST['function']))) : '',
    'error' => false
);
$input['email'] = array(
    'value' => (isset($_POST['email'])) ? htmlspecialchars(stripslashes(trim($_POST['email']))) : '',
    'error' => false
);
$input['password'] = array(
    'value' => (isset($_POST['password'])) ? htmlspecialchars(stripslashes(trim($_POST['password']))) : '',
    'error' => false
);
$input['company'] = array(
    'value' => (isset($_POST['company'])) ? htmlspecialchars(stripslashes(trim($_POST['company']))) : '',
    'error' => false
);
$input['company'] = array(
    'value' => (isset($_POST['company'])) ? htmlspecialchars(stripslashes(trim($_POST['company']))) : '',
    'error' => false
);
$input['activity'] = array(
    'value' => (isset($_POST['activity'])) ? htmlspecialchars(stripslashes(trim($_POST['activity']))) : '',
    'error' => false
);
$input['address1'] = array(
    'value' => (isset($_POST['address1'])) ? htmlspecialchars(stripslashes(trim($_POST['address1']))) : '',
    'error' => false
);
$input['address2'] = array(
    'value' => (isset($_POST['address2'])) ? htmlspecialchars(stripslashes(trim($_POST['address2']))) : '',
    'error' => false
);
$input['zipCode'] = array(
    'value' => (isset($_POST['zipCode'])) ? htmlspecialchars(stripslashes(trim($_POST['zipCode']))) : '',
    'error' => false
);
$input['city'] = array(
    'value' => (isset($_POST['city'])) ? htmlspecialchars(stripslashes(trim($_POST['city']))) : '',
    'error' => false
);
$input['country'] = array(
    'value' => (isset($_POST['country'])) ? htmlspecialchars(stripslashes(trim($_POST['country']))) : '',
    'error' => false
);
$input['phone'] = array(
    'value' => (isset($_POST['phone'])) ? htmlspecialchars(stripslashes(trim($_POST['phone']))) : '',
    'error' => false
);
$input['mobile'] = array(
    'value' => (isset($_POST['mobile'])) ? htmlspecialchars(stripslashes(trim($_POST['mobile']))) : '',
    'error' => false
);
$input['siret'] = array(
    'value' => (isset($_POST['siret'])) ? htmlspecialchars(stripslashes(trim($_POST['siret']))) : '',
    'error' => false
);
$input['tva'] = array(
    'value' => (isset($_POST['tva'])) ? htmlspecialchars(stripslashes(trim($_POST['tva']))) : '',
    'error' => false
);


if(count($_POST)>0)
{
    if(isset($_POST["g-recaptcha-response"]))
    {
        $postData="";
        $post = [
            'secret'=>'6LcfLT0UAAAAAEZd2aug9qViOn6NbPSdkdL4RIa1',
            'response'=>$_POST["g-recaptcha-response"]
        ];

        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify' );
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($c, CURLOPT_POST,sizeof($post));
        curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($post));

// execute!
        $response = curl_exec($c);


// close the connection, release resources used
        $obj = json_decode ($response);

        if($obj->{'success'}===false)
        {
            $error = "rCaptcha";

        }
//Si tout c'est bien pass� on affiche le contenu de la requ�te
        else
        {
            $user = new User("BLANK","");

            $user->civility = $_POST["civility"];
            $user->lastName = $_POST["lastName"];
            $user->firstName = $_POST["firstName"];
            $user->function = $_POST["function"];
            $user->email = $_POST["email"];
            $user->password = md5($_POST["password"]);
            $user->company = $_POST["company"];
            $user->activity = $_POST["activity"];
            $user->address1 = $_POST["address1"];
            $user->address2 = $_POST["address2"];
            $user->zipCode = $_POST["zipCode"];
            $user->city = $_POST["city"];
            $user->country = $_POST["country"];
            $user->phone = $_POST["phone"];
            $user->mobile = $_POST["mobile"];
            $user->siret = $_POST["siret"];
            $user->tva = $_POST["tva"];
            $user->creationDate = date('Y-m-d H:i:s');
            $user->status=0;
            $user->profil=($user->company !="") ? "PRO":"PART";

            $user->save(true);

            if($user->id >0)
            {
                //envoi mail confirmation

                $retour = MailingHandler::sendInscription($user,$user->profil);

                $retourWebmaster = MailingHandler::sendInscriptionToWebMaster($user,$user->profil);

                if($retour["success"]==false)
                    echo $retour["errorInfo"];
                else
                    echo "OK";

                header('Location: /confirmation');
                exit;
            }
            else
            {
                $error = true;
            }
        }

        curl_close($c);


    }
    else
    {
        $error = true;
    }

}