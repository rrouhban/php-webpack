<?php
require_once(dirname(__FILE__) . '/Debug.class.php');

class Tools
{
    public static function formatForUrl($texte)
    {
        /* suppression des espaces en début et fin de chaîne*/
        $texte = trim($texte);

        /* remplacement des accents, tréma et cédilles + qlq autres car. spéciaux */
        $texte = utf8_decode($texte);
        $aremplacer = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ';
        $enremplacement = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby';
        $texte = strtr($texte, utf8_decode($aremplacer), $enremplacement);

        /* mise en minuscule */
        $texte = strtolower($texte);

        /* remplacement des espaces par "-" */
        $texte = str_replace(" ",'-',$texte);

        /* suppression des entitées */
        $texte = preg_replace("/&#?[a-z0-9]{2,8};/i","",$texte);

        /* suppression des caractères non-alphanumériques */
        $texte = preg_replace('#([^a-z0-9-])#','',$texte);

        /* suppression des tirets multiples */
        $texte = preg_replace('#([-]+)#','-',$texte);

        /* on drop les tirets de début et fin de chaine */
        $texte = trim( $texte, '-' );

        return $texte;
    }

    public static function isEmpty($text)
    {
        if($text == '') {
            return true;
        } elseif(trim($text) == '') {
            return true;
        } else {
            return false;
        }
    }

    public static function isEmailCorrect($email)
    {
        // Pas top top, rejette des mails que la norme RFC5321 accepte (caractères non latin...)
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function isDateStrCorrect($dateStr)
    {
        $dateSplit = explode("/", $dateStr);

        if(count($dateSplit) == 3){
            return checkdate(intval($dateSplit[1]),intval($dateSplit[0]),intval($dateSplit[2]));
        } else{
            return false;
        }
    }

    public static function checkPasswordFormat($password, $minChar, $maxChar)
    {
        // Entre 6 et 50 caractères
        if((strlen(utf8_decode($password)) < $minChar) || (strlen(utf8_decode($password)) > $maxChar)){
            return false;
        } else {
            // Autorise pas mal de car sauf les vides. Ponctuations usuelles acceptés.
            $pattern = '/^[_a-zA-Z0-9ÀÂÇÈÉÊËÎÔÙÛàâçèéêëîôöùû\.\(\)\[\]\"\'\-,;:\/!\?]+$/';
            return preg_match($pattern, $password);
        }
    }

    public static function isDateTimeString($dateString, $dateFormat = 'd/m/Y H:i:s')
    {

        $date = DateTime::createFromFormat($dateFormat, $dateString);
        $error = DateTime::getLastErrors();

        $_r = ($date && ($error["warning_count"] == 0) && ($error["error_count"] == 0));
        return $_r;
    }

    public static function convertDateFormat($dateString, $currentDateFormat, $targetDateFormat)
    {
        $dateTime = DateTime::createFromFormat($currentDateFormat, $dateString);
        return $dateTime->format($targetDateFormat);
    }

    public static function generatePassword( $length = 6 ) {
        $password = '';
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[rand(0, (strlen($chars)-1))];
        }
        return $password;
    }

    public static function formatSiret($siret)
    {
        $pattern = '/^([0-9]{3}) ?([0-9]{3}) ?([0-9]{3}) ?([0-9]{5})$/';
        if(preg_match($pattern, $siret, $matches)){
            $siret = $matches[1]." ".$matches[2]." ".$matches[3]." ".$matches[4];
        }

        return $siret;
    }

    public static function checkSiret($siret)
    {
        $siret = str_replace(" ", "", $siret);
        if (strlen($siret) != 14) return 1; // le SIRET doit contenir 14 caractères
        if (!is_numeric($siret)) return 2; // le SIRET ne doit contenir que des chiffres

        // on prend chaque chiffre un par un
        // si son index (position dans la chaîne en commence à 0 au premier caractère) est pair
        // on double sa valeur et si cette dernière est supérieure à 9, on lui retranche 9
        // on ajoute cette valeur à la somme totale
        $sum = 0;

        for ($index = 0; $index < 14; $index ++)
        {
            $number = (int) $siret[$index];
            if (($index % 2) == 0) { if (($number *= 2) > 9) $number -= 9; }
            $sum += $number;
        }

        // le numéro est valide si la somme des chiffres est multiple de 10
        if (($sum % 10) != 0) return 3; else return 0;
    }


    public static function getActualDate()
    {
        return new DateTime();
    }



}