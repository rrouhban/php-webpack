<div class="container">
    <div class="row">
        Hello Deer <?php $user->lastName; ?>, Welcome!!!!
        <br/>
        <form method="post">
            <input type="hidden" name="logout" id="logout" value="1" />
            <input type="submit" value="Déconnexion" class="btn-global bg-red" style="margin-top: 5px;">
        </form>
    </div>
</div>
