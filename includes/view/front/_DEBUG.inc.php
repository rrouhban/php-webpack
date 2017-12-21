<?php

require_once(dirname(__FILE__) . '/../../controller/Debug.class.php');

if(DEBUG::$debugMode){?>
    <div id="debug" v-if="debugPanelShow">
        <div class="debug__header">
            <button class="btn btn-primary btn-lg debug__header__button" type="button">
                <span class="glyphicon glyphicon-eye-open"></span> Debug PANEL
            </button>
        </div>
        <ul class="debug__console">
            <?php
            DEBUG::getHtmlList();
            ?>
        </ul>
    </div>
<?php } ?>

<script>
    new Vue({
        el: '#app',
        data: {
            debugPanelShow: false;
        }
    })
</script>
