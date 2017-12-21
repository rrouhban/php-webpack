<?php
if($error==="Expirer")
{
?>
<div>
    Votre lien a expiré, vous dezvez refaire une demande de mot de passe perdu.
</div>
<?php
}
else if($error==="password")
{
    ?>
    <div>
        Les mots de passe ne sont pas identiques.
    </div>
    <?php
}
else if($error ==="ErrorSave")
{
    ?>
    <div>
        Erreur lors de la sauvegarde de vos informations.
    </div>
    <?php
}
else if($error ==="MajOK")
{
    ?>
    <div>
        Votre mot de passe a bien été mis à jour.
    </div>
    <?php
}
else
{
    ?>

    <div id="register">
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $input['id']['value']; ?>">
            <input type="hidden" id="login" name="login" class="form-control" value="<?php echo $input['login']['value']; ?>"/>
            <br/>
            <input type="password" id="password" name="password" class="form-control" placeholder="Mot de passe"
                   value="<?php echo $input['password']['value']; ?>"/>
            <br/>
            <input type="password" id="password2" name="password2" class="form-control" placeholder="Mot de passe"
                   value="<?php echo $input['password']['value']; ?>"/>
            <br/>
            <button id='submit'>Mettre à jour</button>
        </form>
    </div>


    <?php
}
 ?>