<?php
/**
 * Created by PhpStorm.
 * User: ANAHEIM
 * Date: 07/12/2017
 * Time: 18:13
 */

require_once(dirname(__FILE__) . "/Bdd.class.php");
require_once(dirname(__FILE__) . "/../controller/Tools.class.php");

class User {
    public $id = 0;
    public $civility="";
    public $lastName = "";
    public $firstName = "";
    public $function="";
    public $email = "";
    public $password="";
    public $company="";
    public $activity="";
    public $address1="";
    public $address2="";
    public $zipCode="";
    public $city="";
    public $country="";
    public $phone="";
    public $mobile = "";
    public $siret="";
    public $tva="";
    public $creationDate= null;
    public $status=0;
    public $profil="";

    public function __construct($paramType, $paramData)
    {

        switch ($paramType) {

            case 'SQL_ROW':
                $this->populateWithSqlRow($paramData);
                break;

            case 'ID':
                $foundUsers = BDD::sqlExecRequestWithTokens("SELECT * FROM users WHERE pid_user=:id;", array(":id"=> $paramData));
                if (!(!$foundUsers || (count($foundUsers)==0))){
                    $this->populateWithSqlRow($foundUsers[0]);
                } else {
                    throw new ErrorException("ID user inconu : ".$paramData);
                }
                break;

            case 'EMAIL':
                $foundUsers = BDD::sqlExecRequestWithTokens("SELECT * FROM users WHERE user_email=:email;", array(":email"=> $paramData));
                if (!(!$foundUsers || (count($foundUsers)==0))){
                    $this->populateWithSqlRow($foundUsers[0]);
                }
                break;

            case 'SIRET':
                $foundUsers = BDD::sqlExecRequestWithTokens("SELECT * FROM users WHERE user_siret=:siret;", array(":siret"=> $paramData));
                if (!(!$foundUsers || (count($foundUsers)==0))){
                    $this->populateWithSqlRow($foundUsers[0]);
                }
                break;

            case 'BLANK':
                break;
        }
        //$this->refreshStatus();

    }

    public static function getUserByLoginAndPassword($_login, $_password, $_isMd5 = false)
    {
        $req = "SELECT * FROM `users` WHERE user_email=:email AND user_password=:password;";

        $foundUsers = BDD::sqlExecRequestWithTokens($req, array(":email"=> $_login, ":password"=> md5($_password)));

        if (!$foundUsers || (count($foundUsers)==0)){
            return null;
        } else {
            return new User('SQL_ROW', $foundUsers[0]);
        }
    }

    public function saveInSession()
    {
        $_SESSION['user'] = $this;
    }

    public static function getAdherent()
    {
        return isset($_SESSION['user']) ? new User('ID', $_SESSION['user']->id) : new User('BLANK', null);
    }

    public function populateWithSqlRow($dbRow){
        $this->id = intval($dbRow->pid_user);
        $this->civility =$dbRow->user_civility;
        $this->lastName = $dbRow->user_lastName;
        $this->firstName = $dbRow->user_firstName;
        $this->function = $dbRow->user_function;
        $this->email = $dbRow->user_email;
        $this->password = $dbRow->user_password;
        $this->company = $dbRow->user_company;
        $this->activity = $dbRow->user_company;
        $this->address1 = $dbRow->user_address1;
        $this->address2 = $dbRow->user_address2;
        $this->zipCode = $dbRow->user_zipCode;
        $this->city = $dbRow->user_city;
        $this->country = $dbRow->user_country;
        $this->phone = $dbRow->user_phone;
        $this->mobile = $dbRow->user_mobile;
        $this->siret = $dbRow->user_siret;
        $this->tva = $dbRow->user_tva;
        $this->creationDate = $dbRow->user_creationDate;
        $this->status = intval($dbRow->user_status);
        $this->profil = $dbRow->user_profil;
    }

    public function save($saveInSessionToo = true)
    {
        $error = false;
        $params = array(
            ':user_civility' => $this->civility,
            ':user_lastName' => $this->lastName,
            ':user_firstName' => $this->firstName,
            ':user_function' => $this->function,
            ':user_email' => $this->email,
            ':user_password' => $this->password,
            ':user_company' => $this->company,
            ':user_activity' => $this->activity,
            ':user_address1' => $this->address1,
            ':user_address2' => $this->address2,
            ':user_zipCode' => $this->zipCode,
            ':user_city' => $this->city,
            ':user_country' => $this->country,
            ':user_phone' => $this->phone,
            ':user_mobile' => $this->mobile,
            ':user_siret' => $this->siret,
            ':user_tva' => $this->tva,
            ':user_creationDate' => $this->creationDate,
            ':user_status' => $this->status,
            ':user_profil' => $this->profil
        );

        if($this->id > 0){
            $params[':pid_user'] = $this->id;
            $sqlRequest = "UPDATE users SET user_civility = :user_civility, user_lastName = :user_lastName, user_firstName = :user_firstName, 
                          user_function = :user_function, user_email = :user_email, user_password = :user_password, 
                          user_company = :user_company, user_activity = :user_activity, user_address1 = :user_address1, 
                          user_address2 = :user_address2, user_zipCode = :user_zipCode, user_city = :user_city, user_country = :user_country, 
                          user_phone = :user_phone, user_mobile = :user_mobile, user_siret = :user_siret, user_tva = :user_tva, user_creationDate = :user_creationDate, 
                          user_status = :user_status, user_profil = :user_profil WHERE pid_user=:pid_user;";
        } else {
            $sqlRequest = "INSERT INTO `users` (`user_civility`, `user_lastName`, `user_firstName`, `user_function`, `user_email`, `user_password`, 
                          `user_company`, `user_activity`, `user_address1`, `user_address2`, `user_zipCode`, 
                          `user_city`, `user_country`, `user_phone`, `user_mobile`, `user_siret`, `user_tva`, `user_creationDate`, 
                          `user_status`, `user_profil`) VALUE (:user_civility,:user_lastName,:user_firstName,:user_function,:user_email,:user_password,
                          :user_company,:user_activity,:user_address1,:user_address2,:user_zipCode,:user_city,:user_country,:user_phone,
                          :user_mobile,:user_siret,:user_tva,:user_creationDate,:user_status,:user_profil);";
        }

        $reslt = BDD::sqlExecRequestWithTokens($sqlRequest, $params);
        if(!array_key_exists(':pid_user', $params)) $this->id = intval(BDD::getLastId());

        if($reslt===false)
        {
            $error = true;
        }

        if($error === true)
        {
            return false;
        }
        else
        {
            return true;
        }

        // si $saveInSessionToo = true, on save en session
        if($saveInSessionToo) $this->saveInSession();

    }

    public static function checkForgottenPasswordPath($param)
    {
        //$params = base64_decode(explode("#", $param));
        $params = explode("#",urldecode(base64_decode($param)));
        if (count($params) === 3)
        {
            $mail = $params[0];
            $token = $params[1];
            $expire = $params[2];
            if (Tools::isEmailCorrect($mail)) {
                $user = new User("EMAIL", $mail);
                if ($user->id > 0) {
                    $newToken = md5($mail . "#" . $user->id . "#" . $expire);
                    if ($token === $newToken) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }

        }
        else
        {
            return false;
        }


    }

}
