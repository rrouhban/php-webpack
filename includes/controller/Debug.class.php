<?php
class DEBUG
{
    private static $debug_list = array();
    public static $debugMode = false;

    public static function getHtmlList()
	{
		foreach (self::$debug_list as $value) {
			echo("<li><h3>".$value[0]."</h3><div class='debug__console__value-box'>".$value[1]."</div></li>");
		}
	}

    public static function debug_log($arg, $debugLegend='[ no legend ]')
	{
        if(!self::$debugMode) return;
		ob_start();
		print_r($arg);
		$a=ob_get_contents();
		ob_end_clean();
        self::$debug_list[] = array($debugLegend,$a);
	}

}
	
?>