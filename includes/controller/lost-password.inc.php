<?php
/**
 * Created by PhpStorm.
 * User: ANAHEIM
 * Date: 14/12/2017
 * Time: 16:36
 */
require_once(dirname(__FILE__) . '/MailingHandler.class.php');
require_once(dirname(__FILE__) . '/../model/User.class.php');
header('Content-Type: text/plain; charset=UTF-8');
$error = false;
if(count($_POST)>0)
{
    if(Tools::isEmailCorrect($_POST["email"])) {
        $user = new User("EMAIL", $_POST["email"]);
        if ($user->id > 0) {
            $error = false;
            //faire l'envoi de mail avec lien de réinitialisation.

        } else {
            $error = true;
        }
    }
}