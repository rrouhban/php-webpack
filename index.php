<?php
/**
 * Created by PhpStorm.
 * User: ANAHEIM
 * Date: 07/12/2017
 * Time: 16:38
 */
$time_start = microtime(true);
require_once(dirname(__FILE__) . "/includes/controller/Debug.class.php");
require_once(dirname(__FILE__) . "/includes/controller/Path.class.php");
require_once(dirname(__FILE__) . "/includes/model/User.class.php");
session_start();

/* ----------------------------------------------------------------------------------------- */
/* -----------------------          DEBUG MODE HANDLER          ---------------------------- */
/* ----------------------------------------------------------------------------------------- */

DEBUG::$debugMode = true;



/* ----------------------------------------------------------------------------------------- */
/* ------------------------        HANDLE REQUESTED PATH        ---------------------------- */
/* ----------------------------------------------------------------------------------------- */

if(HtmlData::currentHttpStatus() == 200){
    $requestPath = "";
    if(isset($_GET['path'])){
        $requestPath = htmlspecialchars($_GET['path']);
    }
    PATH::handlePath($requestPath);
    if(!PATH::pathIsValid()){
        HtmlData::forceHttpStatus(404);
    }
} else {
    echo "2";
    PATH::handlePath("404");
}

$user = User::getAdherent();

/* ******************************************************************************* */

HtmlData::setPathRoot("/");

// Controller de page (facultatif), défini dans le sitemap. Peux rediriger en fonction du traitement.
if(PATH::$pageController != '') include(dirname(__FILE__) . "/includes/controller/".PATH::$pageController);

// On arrive là ? C'est que le controller ne s'est pas plaint, on continue.
header(HtmlData::getHeader());

include(dirname(__FILE__)."/includes/view/front/_ROOT.inc.php");