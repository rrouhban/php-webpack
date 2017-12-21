<?php
require_once(dirname(__FILE__) . '../../dist/includes/controller/Tools.class.php');
require_once(dirname(__FILE__) . '/../dist/includes/controller/MailingHandler.class.php');
require_once(dirname(__FILE__) . '../../dist/includes/model/User.class.php');

header('Content-Type: text/plain; charset=UTF-8');

if (isset($_GET['email']))
{
    if(Tools::isEmailCorrect($_GET['email'])){

        $foundUser = new User("EMAIL", $_GET['email']);
        if($foundUser->id > 0){
            $retour = MailingHandler::sendForgottenPassword($foundUser);
            if($retour["success"]==false)
                echo $retour["errorInfo"];
            else
                echo "OK";
        } else {
            echo "UNKNOWN";
        }

    } else {
        echo "NO-EMAIL";
    }
} else {
    echo "ERROR";
}