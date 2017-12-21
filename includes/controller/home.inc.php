<?php
/**
 * Created by PhpStorm.
 * User: ANAHEIM
 * Date: 07/12/2017
 * Time: 17:22
 */

HtmlData::setTitle("Mon titre de la mort qui déchire !");
$inputs = array();
$input['identifiant'] = array(
    'value' => (isset($_POST['identifiant'])) ? htmlspecialchars(stripslashes(trim($_POST['identifiant']))) : '',
    'error' => false
);
$input['password'] = array(
    'value' => (isset($_POST['password'])) ? htmlspecialchars(stripslashes(trim($_POST['password']))) : '',
    'error' => false
);
$_login = (isset($_POST["identifiant"]))?$_POST["identifiant"]:"";

// Si le formulaire a été soumis, on vérifie.
if(isset($_POST['password']) && isset($_POST['identifiant'])){
    $testUser = User::getUserByLoginAndPassword($input['identifiant']['value'], $input['password']['value']);
    DEBUG::debug_log($testUser,"im a legend!");
    if($testUser != null){
        // Formulaire OK, on log !
        $testUser->saveInSession();
        //$user = User::getAdherent(); // On update notre $var global
    }
}

if(isset($_POST['logout'])){
    unset($_SESSION['user']);
    header('Location: /');
    exit;
}