<div>
    <h1>Hello deer <?php echo $_login; ?> !</h1>
</div>

    <div id="register">
        <form method="post">
            <input type="text" id="identifiant" name="identifiant" class="form-control" placeholder="Identifiant"
                   value="<?php echo $input['identifiant']['value']; ?>"/>
            <br/>
            <input type="password" id="password" name="password" class="form-control" placeholder="Mot de passe"
                   value="<?php echo $input['password']['value']; ?>"/>
            <br/>
            <div id='recaptcha' class="g-recaptcha"
                 data-sitekey="6LcfLT0UAAAAAFoLHl5txJoCW1gFjAIS0y_or2lH"
                 data-callback="onSubmit"
                 data-size="invisible"></div>
            <button id='submit'>submit</button>
            <a href="/inscription" class="btn-global bg-red" style="margin-top: 5px;display: inline-block;">Inscription</a><br/>
            <a id="forgottenPasswordLink" href="#">Mot de passe oublié ?</a>
        </form>
    </div>

<div class="modal fade" id="forgottenPasswordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Mot de passe perdu</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="forgottenPasswordForm">
                    <div class="alert" style="display: none;">
                        <p></p>
                    </div>
                    <div class="row">

                        <div class="col-xs-16 col-sm-16 col-md-16 col-lg-16">
                            <input type="text" id="forgottenPasswordMail" name="forgottenPasswordMail" class="form-control" placeholder="E-mail" />
                        </div>

                        <div class="col-xs-16">
                            <input type="submit" value="> valider" class="btn-global bg-red" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="loginErrorModal" tabindex="-1" role="dialog" aria-labelledby="loginErrorModalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="loginErrorModalTitle">Connexion impossible</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
        </div>
    </div>
</div>