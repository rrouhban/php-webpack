<?php
    if($error ===true)
    {
        ?>
        <div class="alert alert-danger alert-dismissible show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Holy guacamole!</strong> Aucun compte associé à cet e-mail.
        </div>
        <?php
    }
    else
    {
        ?>
        <div class="alert alert-success alert-dismissible show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Holy guacamole!</strong> Un e-mail vous a été envoyé avec un lien ré initialisation.
        </div>
        <?php
    }

?>


<div style="width:500px;margin-left: auto;margin-right: auto;padding-top:35px;">

    Vous avez oublié votre mot de passe ?<br/>
    Renseignez l'email avec lequel vous vous êtes inscris.<br>

    <form method="post">
        <input required="required" type="text" id="email" name="email" class="form-control" placeholder="e-mail" value=""/><br/>
        <input type="submit" value="Valider" />
    </form>
</div>