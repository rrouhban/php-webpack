<?php
if($error===true)
{
    ?>
    <div class="alert alert-danger alert-dismissible show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Holy guacamole!</strong> Error lors de l'inscription.
    </div>
<?php
}
else if($error ==="rCaptcha")
{
    ?>
    <div class="alert alert-danger alert-dismissible show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Holy guacamole!</strong> Vous devez validez le captcha.
    </div>
    <?php
}

?>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div style="width:500px;margin-left: auto;margin-right: auto;padding-top:35px;">

    Renseignez les champs suivants pour vous inscrire.

    <form method="post">
        <select name="civility" class="form-control">
            <option>Choose civility</option>
            <option value="M.">M.</option>
            <option value="Mme">Mme</option>
        </select>
<br/><br>
        <input required="required" type="text" id="lastName" name="lastName" class="form-control" placeholder="Nom" value="<?php echo $input['lastName']['value']; ?>"/><br/>
        <input required="required" type="text" id="firstName" name="firstName" class="form-control" placeholder="Prénom" value="<?php echo $input['firstName']['value']; ?>"/><br/>
        <select name="function" class="form-control">
            <option>Choose function</option>
            <option value="Gérant">Gérant</option>
        </select>
        <br/><br>
        <input required="required" type="text" id="email" name="email" class="form-control" placeholder="e-mail" value="<?php echo $input['email']['value']; ?>"/><br/>
        <input required="required" type="password" name="password" class="form-control" placeholder="password" value="<?php echo $input['password']['value']; ?>" /><br/>
        <input type="text" id="company" name="company" class="form-control" placeholder="Entreprise" value="<?php echo $input['company']['value']; ?>" /><br>
        <input required="required" type="text" id="activity" name="activity" class="form-control" placeholder="Activité" value="<?php echo $input['activity']['value']; ?>" /><br/>
        <input required="required" type="text" id="address1" name="address1" class="form-control" placeholder="Adresse 1" value="<?php echo $input['address1']['value']; ?>" /><br/>
        <input type="text" id="address2" name="address2" class="form-control" placeholder="Adresse 2" value="<?php echo $input['address2']['value']; ?>" /><br/>
        <input required="required" type="text" id="zipCode" required pattern="[0-9]{5}" name="zipCode" class="form-control" placeholder="Code postal" value="<?php echo $input['zipCode']['value']; ?>"><br>
        <select name="country" id="country" class="form-control">
            <option value="">Choose your country</option>
            <option value="FRA">France</option>
        </select><br/><br/>
        <input required="required" type="text" name="city" id="city" class="form-control" placeholder="City" value="<?php echo $input['city']['value']; ?>"/><br/>
        <input required="required" type="phone" name="phone" id="phone" class="form-control" placeholder="Phone" value="<?php echo $input['phone']['value']; ?>" /><br/>
        <input type="text" name="mobile"  id="mobile" class="form-control" placeholder="Mobile" value="<?php echo $input['mobile']['value']; ?>" /><br />
        <input type="text" name="siret" id="siret" class="form-control" placeholder="siret" value="<?php echo $input['siret']['value']; ?>" /><br/>
        <input type="text" name="tva" id="tva" class="form-control" placeholder="TVA" value="<?php echo $input['tva']['value']; ?>" /><br />
        <br/>
        <div id='recaptcha' class="g-recaptcha"
             data-sitekey="6LcfLT0UAAAAAFoLHl5txJoCW1gFjAIS0y_or2lH"></div>
        <button id='submit'>submit</button>
    </form>
</div>

