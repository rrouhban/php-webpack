<?php
/**
 * Created by PhpStorm.
 * User: NewYork
 * Date: 26/05/15
 * Time: 15:25
 */
require_once(dirname(__FILE__).'/../../libs/PHPMailer/class.phpmailer.php');
require_once(dirname(__FILE__).'/../model/User.class.php');


class MailingHandler {

    private static $urlSite = "materio:8080/";
    private static $urlRenew = "materio:8080/";
    private static $expeditor = "materiopro@gmail.com";
    private static $mktEmail = "jea@passerelle.com";
    private static $debEmail = "jea@passerelle.com";
    private static $cadhocEmail = "jea@passerelle.com";
    private static $cciCadhocEmail = "jea@passerelle.com";
    private static $cciEmail = "jea@passerelle.com";

/*
    private static function getComEmails($dept){
        $_r = array(
            "jea@passerelle.com",
            "marvin@passerelle.com"
        );
        return $_r;
    }
*/




    private static function replaceTokens($htmlStr, $tokens)
    {
        $htmlStr = str_replace("logo-materio.jpg", "cid:logo_materio", $htmlStr);

        foreach($tokens as $key=>$token){
            $htmlStr = str_replace($key, $token, $htmlStr);
        }

        return $htmlStr;
    }



    public static function sendForgottenPassword($user)
    {
        $messageBRUT = file_get_contents(dirname(__FILE__)."/../view/mailing/pswforget_user.html");
        $timestampDemande = time();
        $timeStampExpire =time()+900;

        $link = "http://".self::$urlSite."/password-reset/".urlencode(base64_encode($user->email."#".md5($user->email."#".$user->id."#".$timeStampExpire)."#".$timeStampExpire));

        $tokenLink = md5($user->email."#".$user->id."#".$timeStampExpire);
        $tokens = array(
            '[@user_firstName@]' => $user->firstName,
            '[@user_Name@]' => $user->lastName,
            '[@user_email@]' => $user->email,
            '[@url_site@]' => self::$urlSite,
            '[@linkReset@]' => $link
        );

        $messageBRUT = self::replaceTokens($messageBRUT, $tokens);

        $mail = new PHPMailer();

        $mail->CharSet = 'UTF-8';


        $mail->SetFrom(self::$expeditor, "L'équipe MaterioPro");
        $fullName = $user->firstName." ".$user->lastName;
        $mail->AddAddress($user->email);
        $mail->Subject = "MaterioPro - Mot de passe";
        $mail->MsgHTML($messageBRUT);
        $mail->IsHTML(true);
        //$mail->AddEmbeddedImage(dirname(__FILE__)."/../view/mailing/logo-materio.jpg", 'logo_materio');

        if(!$mail->Send()) {
            return array('success'=> false, "errorInfo"=> $mail->ErrorInfo."//".$user->email);
        } else {
            return array('success'=> true);
        }
    }

    public static function sendInscription($user,$type="Part")
    {
        if($user->id >0 &&($user->profil == $type))
        {
            switch ($type)
            {
                case 'PRO':
                    $messageBRUT = file_get_contents(dirname(__FILE__)."/../view/mailing/inscription_pro.html");
                    break;
                case 'PART':
                    $messageBRUT = file_get_contents(dirname(__FILE__)."/../view/mailing/inscription_part.html");
                    break;
            }
        }
        else
        {
            return array('success'=> false, "errorInfo"=> "pas de type d'utilisateur détecté");
        }



        $timestampDemande = time();
        $timeStampExpire =time()+900;

        $link = "http://".self::$urlSite."/confirme-inscription/".urlencode(base64_encode($user->email."#".md5($user->email."#".$user->id)));

        $tokens = array(
            '[@user_firstName@]' => $user->firstName,
            '[@user_Name@]' => $user->lastName,
            '[@user_email@]' => $user->email,
            '[@url_site@]' => self::$urlSite,
            '[@linkValider@]' => $link
        );

        $messageBRUT = self::replaceTokens($messageBRUT, $tokens);

        $mail = new PHPMailer();

        $mail->CharSet = 'UTF-8';


        $mail->SetFrom(self::$expeditor, "L'équipe MaterioPro");
        $fullName = $user->firstName." ".$user->lastName;
        $mail->AddAddress($user->email);
        $mail->Subject = "MaterioPro - Votre inscription sur materiopro.com";
        $mail->MsgHTML($messageBRUT);
        $mail->IsHTML(true);
        //$mail->AddEmbeddedImage(dirname(__FILE__)."/../view/mailing/logo-materio.jpg", 'logo_materio');

        if(!$mail->Send()) {
            return array('success'=> false, "errorInfo"=> $mail->ErrorInfo."//".$user->email);
        } else {
            return array('success'=> true);
        }
    }

    public static function sendInscriptionToWebmaster($user,$type="Part")
    {
        if($user->id >0 &&($user->profil == $type))
        {
            switch ($type)
            {
                case 'PRO':
                    $messageBRUT = file_get_contents(dirname(__FILE__)."/../view/mailing/inscription_pro.html");
                    break;
                case 'PART':
                    $messageBRUT = file_get_contents(dirname(__FILE__)."/../view/mailing/inscription_part.html");
                    break;
            }
        }
        else
        {
            return array('success'=> false, "errorInfo"=> "pas de type d'utilisateur détecté");
        }



        $timestampDemande = time();
        $timeStampExpire =time()+900;

        $link = "http://".self::$urlSite."/confirme-inscription/".urlencode(base64_encode($user->email."#".md5($user->email."#".$user->id)));

        $tokens = array(
            '[@user_firstName@]' => $user->firstName,
            '[@user_Name@]' => $user->lastName,
            '[@user_email@]' => $user->email,
            '[@url_site@]' => self::$urlSite,
            '[@linkValider@]' => $link
        );

        $messageBRUT = self::replaceTokens($messageBRUT, $tokens);

        $mail = new PHPMailer();

        $mail->CharSet = 'UTF-8';


        $mail->SetFrom(self::$expeditor, "L'équipe MaterioPro");
        $fullName = $user->firstName." ".$user->lastName;
        $mail->AddAddress($user->email);
        $mail->Subject = "MaterioPro - Votre inscription sur materiopro.com";
        $mail->MsgHTML($messageBRUT);
        $mail->IsHTML(true);
        //$mail->AddEmbeddedImage(dirname(__FILE__)."/../view/mailing/logo-materio.jpg", 'logo_materio');

        if(!$mail->Send()) {
            return array('success'=> false, "errorInfo"=> $mail->ErrorInfo."//".$user->email);
        } else {
            return array('success'=> true);
        }
    }
} 