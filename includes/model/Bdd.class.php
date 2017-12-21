<?php

require_once(dirname(__FILE__).'/../controller/Debug.class.php');

class BDD {
 
    private static $_pdo;

    private function __construct() {
    }

    private static function getPDO()
    {
       if(is_null(self::$_pdo)){
            self::$_pdo = new PDO('mysql:host=127.0.0.1;dbname=db_materio', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			//self::$_pdo = new PDO('mysql:host=localhost;dbname=efficioprod', 'efficioprod', '1Vds2koG', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
       }

       return self::$_pdo;
    }



  public static function selectRequest($request, $returnType="OBJECT")
  {
    $results = array();
	
	$reponse = self::getPDO()->query($request);
	if(is_object($reponse)){
		switch( $returnType){
			case "ARRAY" :
				$reponse->setFetchMode(PDO::FETCH_ASSOC);
			break;
			
			case "OBJECT" :
				$reponse->setFetchMode(PDO::FETCH_OBJ);
			break;
			
			default : 
				$reponse->setFetchMode(PDO::FETCH_ASSOC);
			break;
		}
		
		$donnees = $reponse->fetchAll();

		foreach ($donnees as $row){
		  $results[] = $row;
		}

		return $results;
	}else
		return false;
  }
  
  public static function sqlExecRequest($request)
  {
	if( self::getPDO()->exec($request)) return true;
    return false;
  }

    public static function sqlRequestWithReturnWithTokens($requestStr, $option)
    {
        $request = self::getPDO()->prepare($requestStr);
        if($request->execute($option)){
            debug::debug_log("PDO SUCCESS");
            return true;
        } else {
            debug::debug_log(self::getPDO()->errorInfo(), "PDO ERROR");
            return false;
        }
    }


    public static function sqlExecRequestWithTokens($request, $option=null, $returnType="OBJECT")
    {
        
        $results = array();
        
        $reponse = self::getPDO()->prepare($request);
        
        if(is_object($reponse)){
            switch( $returnType){
                case "ARRAY" :
                    $reponse->setFetchMode(PDO::FETCH_ASSOC);
                break;

                case "OBJECT" :
                    $reponse->setFetchMode(PDO::FETCH_OBJ);
                break;

                default : 
                    $reponse->setFetchMode(PDO::FETCH_ASSOC);
                break;
            }

            if($option){
                $reponse->execute($option);
            } else {
                $reponse->execute();
            }
            
            $donnees = $reponse->fetchAll();

            foreach ($donnees as $row){
              $results[] = $row;
            }

            return $results;
        }
        
        return false;
    }
  
    public static function getLastId(){
        return  self::getPDO()->lastInsertId();
    }
  
    public static function getQuote($string){
        return  self::getPDO()->quote($string, PDO::PARAM_STR);
    }
}
 
?>
