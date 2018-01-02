<?php

require_once(dirname(__FILE__) . '/../../controller/Debug.class.php');

if(DEBUG::$debugMode){?>
    <debug-panel id="debug">
        <div class="debug__header">
            <button @click="togglePanel()" class="btn btn-primary btn-lg debug__header__button" type="button">
                <span class="glyphicon glyphicon-eye-open"></span>
            </button>
        </div>
        <ul class="debug__console" v-if="debugPanelOpen">
            <?php
            DEBUG::getHtmlList();
            ?>
        </ul>
    </debug-panel>
<?php } ?>