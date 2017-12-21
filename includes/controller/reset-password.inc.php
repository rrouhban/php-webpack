<?php
/**
 * Created by PhpStorm.
 * User: ANAHEIM
 * Date: 18/12/2017
 * Time: 16:22
 */

require_once(dirname(__FILE__) . "/Path.class.php");


$params = explode("#",urldecode(base64_decode(PATH::$currentPathTree[1])));
$mail = $params[0];
$token = $params[1];
$expire = $params[2];
$timeNow = time();
$error="";
if($timeNow <= $expire) // si on est dans les temps on peut faire le traitement
{
    if(count($_POST)>0) //
    {
        if($_POST["password"]==$_POST["password2"]) // si les mots de passe sont identiques on fait la mise à jour du user
        {
            $user = new User("EMAIL", $_POST['login']);
            $user->password = md5($_POST["password"]);
            DEBUG::debug_log("maj pwd",$user->email);
            if($user->save())
            {
                $error="MajOK";
            }
            else
            {
                $error="ErrorSave";
            }
        }
        else
        {
            $error ="password";
        }


    }
    else
    {
        $user = new User("EMAIL", $mail);
        $input['login'] = array(
            'value' => (isset($_POST['login'])) ? htmlspecialchars(stripslashes(trim($_POST['login']))) : $user->email,
            'error' => false
        );
        $input['id'] = array(
            'value' => (isset($_POST['id'])) ? htmlspecialchars(stripslashes(trim($_POST['id']))) : $user->id,
            'error' => false
        );
        $input['password'] = array(
            'value' => (isset($_POST['password'])) ? htmlspecialchars(stripslashes(trim($_POST['password']))) : '',
            'error' => false
        );
    }

}
else
{
    $error = "Expirer";
}