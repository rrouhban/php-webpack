<?php
/**
 * Created by PhpStorm.
 * User: DENVER
 * Date: 10/03/14
 * Time: 15:17
 */

require_once(dirname(__FILE__) . '/Debug.class.php');
require_once(dirname(__FILE__).'/../model/HtmlData.class.php');
require_once(dirname(__FILE__).'/../model/User.class.php');


class PATH
{
    private static $_siteMapPath = '';
    private static $_pathIsValid = true;
    public static $currentPathTree;
    public static $pageController = '';

    /**
     * @return boolean
     */
    public static function pathIsValid()
    {
        if(self::$_siteMapPath == ""){
            throw new ErrorException("PATH::pathIsValid() can't be call before PATH::handlePath()");
        }
        return self::$_pathIsValid;
    }


    public static function getCurrentPath()
    {
        $_r = "/".LANG::getLang()."/".join("/",self::$currentPathTree);
        return $_r;
    }

    public static function getOtherLangPath($langCode)
    {
        $_r = "/".$langCode."/".join("/",self::$currentPathTree);
        return $_r;
    }


    public static function handlePath($path)
    {
        if(self::$_siteMapPath != ""){
            throw new ErrorException("PATH::handlePath() can be called only once !");
        }

        self::$_siteMapPath =  dirname(__FILE__).'/../model/sitemap.xml';
        $domXml = simplexml_load_file(self::$_siteMapPath);

        $requestPath = trim($path, "/");
        $pathLevels = explode("/", $requestPath);
        DEBUG::debug_log($pathLevels, 'PATH::pathLevels');

        $lastLevelNode = $domXml->xpath('/sitemap/page[@path=""]');
        $lastLevelNode = $lastLevelNode[0]; // Je ne garde que le 1er (et unique) élmt de l'array retourné...

        if($requestPath != ""){
            foreach($pathLevels as $level){
                if(count($lastLevelNode->xpath('page[@path="'.$level.'"]')) == 1){
                    $lastLevelNode = $lastLevelNode->xpath('page[@path="'.$level.'"]');
                    $xmlNodeAttr = $lastLevelNode[0]->attributes();
                    $controllerClassFunction = '';
                    $fullPathControl = false;
                    $fallBackPageStr = '';
                    foreach($xmlNodeAttr as $key=>$attr){
                        if($key == 'pathControllerFunction') {
                            $controllerClassFunction = $attr->__toString();
                        } else if($key == 'fullPathControl') {
                            $fullPathControl = ($attr->__toString() == "true");
                        } else if($key == 'pathFallBackPage') {
                            $fallBackPageStr = $attr->__toString();
                        }
                    }

                    if($controllerClassFunction){
                        DEBUG::debug_log("PEUT-ETRE (existe mais controller)", 'TEST : '.$level);
                        if(is_callable($controllerClassFunction)){
                            if($fullPathControl){
                                self::$_pathIsValid = call_user_func($controllerClassFunction, $pathLevels);
                            } else {
                                self::$_pathIsValid = call_user_func($controllerClassFunction, $level);
                            }
                            DEBUG::debug_log("Controller trouvé. Result= ".(self::$_pathIsValid ? "true":"false"), 'TEST levelName : '.$level);
                        } else {
                            self::$_pathIsValid = false;
                            DEBUG::debug_log("Controller introuvable !!! ", 'TEST levelName : '.$level);
                        }

                        if(self::$_pathIsValid){
                            $lastLevelNode = $lastLevelNode[0];
                        } else {
                            if(count($domXml->xpath('/sitemap/page[@path=""]/page[@path="'.$fallBackPageStr.'"]')) == 1){
                                $lastLevelNode = $domXml->xpath('/sitemap/page[@path=""]/page[@path="'.$fallBackPageStr.'"]');
                                $lastLevelNode = $lastLevelNode[0];
                            } else {
                                $lastLevelNode = $domXml->xpath('/sitemap/page[@path=""]/page[@path="404"]');
                                $lastLevelNode = $lastLevelNode[0];
                            }
                            break;
                        }
                    } else {
                        DEBUG::debug_log("OUI", 'TEST : '.$level);
                        $lastLevelNode = $lastLevelNode[0];
                    }




                } else if(count($lastLevelNode->xpath('page[@path="@"]')) == 1) {
                    DEBUG::debug_log("PEUT-ETRE (path dynamique)", 'TEST : '.$level);
                    $pageXmlNodes = $lastLevelNode->xpath('page[@path="@"]');
                    $xmlNodeAttr = $pageXmlNodes[0]->attributes();
                    $controllerClassFunction = '';
                    $fullPathControl = false;
                    $fallBackPageStr = '';
                    foreach($xmlNodeAttr as $key=>$attr){
                        if($key == 'pathControllerFunction') {
                            $controllerClassFunction = $attr->__toString();
                        } else if($key == 'fullPathControl') {
                            $fullPathControl = ($attr->__toString() == "true");
                        } else if($key == 'pathFallBackPage') {
                            $fallBackPageStr = $attr->__toString();
                        }
                    }

                    DEBUG::debug_log($fullPathControl, '$fullPathControl');
                    DEBUG::debug_log($controllerClassFunction, '$controllerClassFunction');

                    if(is_callable($controllerClassFunction)){
                        if($fullPathControl){
                            self::$_pathIsValid = call_user_func($controllerClassFunction, $pathLevels);
                        } else {
                            self::$_pathIsValid = call_user_func($controllerClassFunction, $level);
                        }
                        DEBUG::debug_log("Controller trouvé. Result= ".(self::$_pathIsValid ? "true":"false"), 'TEST levelName : '.$level);
                    } else {
                        self::$_pathIsValid = false;
                        DEBUG::debug_log("Controller introuvable !!! ", 'TEST levelName : '.$level);
                    }

                    if(self::$_pathIsValid){
                        $lastLevelNode = $pageXmlNodes[0];
                    } else {
                        if(count($domXml->xpath('/sitemap/page[@path=""]/page[@path="'.$fallBackPageStr.'"]')) == 1){
                            $lastLevelNode = $domXml->xpath('/sitemap/page[@path=""]/page[@path="'.$fallBackPageStr.'"]');
                            $lastLevelNode = $lastLevelNode[0];
                        } else {
                            $lastLevelNode = $domXml->xpath('/sitemap/page[@path=""]/page[@path="404"]');
                            $lastLevelNode = $lastLevelNode[0];
                        }
                        break;
                    }
                } else {
                    DEBUG::debug_log("NON", 'TEST : '.$level);
                    self::$_pathIsValid = false;
                    $lastLevelNode = $domXml->xpath('/sitemap/page[@path=""]/page[@path="404"]');
                    $lastLevelNode = $lastLevelNode[0];
                    break;
                }
            }
        }


        if (self::$_pathIsValid){
            self::$currentPathTree = $pathLevels;
        }else{
            self::$currentPathTree = array();
        }

        HtmlData::setTitle($lastLevelNode->titre->__toString());
        HtmlData::setTemplateFilePath($lastLevelNode->template->__toString());

        if($lastLevelNode->controller) self::$pageController  = $lastLevelNode->controller->__toString();
        if($lastLevelNode->scripts){
            foreach(explode("|", $lastLevelNode->scripts->__toString()) as $path)
                HtmlData::addScript($path);
        }
        if($lastLevelNode->styles){
            foreach(explode("|", $lastLevelNode->styles->__toString()) as $path)
                HtmlData::addCss($path);
        }

    }

}
