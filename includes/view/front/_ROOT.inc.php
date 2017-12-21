<?php
require_once(dirname(__FILE__) . '/../../controller/Debug.class.php');
require_once(dirname(__FILE__).'/../../model/HtmlData.class.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- TITLE -->
    <?php
    $title = "Materio";
    if(HtmlData::Title() != "") $title .= " - ".HtmlData::Title();
    echo "<title>$title</title>";
    ?>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <base href="<?php echo HtmlData::PathRoot(); ?>" />

    <!-- CSS -->
    <?php foreach(HtmlData::CssList() as $cssFile){ ?> <link href='<?php echo $cssFile;?>' rel='stylesheet' type='text/css' /><?php echo "\r\n\t"; } ?>

</head>
<body>

    <?php
    DEBUG::debug_log( HtmlData::TemplateFilePath(), "HtmlData::TemplateFilePath()");
    include(dirname(__FILE__)."/".HtmlData::TemplateFilePath());
    ?>

<!-- JS -->
<?php
foreach(HtmlData::ScriptList() as $jsFile){ ?><script src='<?php echo $jsFile;?>'></script><?php echo "\r\n\t"; }

// On recup le temps d'execution :
if(DEBUG::$debugMode === true){
    $time_end = microtime(true);
    $time = $time_end - $time_start;
    DEBUG::debug_log($time, "Process Time");
}
include("_DEBUG.inc.php");
?>
</body>
</html>