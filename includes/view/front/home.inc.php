<?php
require_once(dirname(__FILE__).'/../../model/User.class.php');
DEBUG::debug_log($user->status,"status user");
if(($user->status === 1) )
{
    include(dirname(__FILE__).'/home.logged.inc.php');
}
else
{
    include(dirname(__FILE__).'/home.unlogged.inc.php'); // On ne devrait jamais tombé là...
}
?>
<div id="app"></div>
