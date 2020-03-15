<!-- Zone formulaire  -->
<div class="zoneFormulaire">

  <div class="flash-connexion">
    <?php if ($user->hasFlash()) {echo '<p class="ligne-erreur">', $user->getFlash(), '</p>';} ?>
  </div>

  <p class="titreFormulaire">Connexion</p>

  <form action ="" method="post" class="formulaire">
    <?= $form ?>
    <div class="index-btn-valid">
      <input type="submit" value="Valider" class="btnValid font-weight-bold" />
    </div>
  </form>

</div>
