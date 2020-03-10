<!-- Zone formulaire  -->
<div class="zoneFormulaire">

  <div>
    <?php if ($user->hasFlash()) {echo '<p class="ligne-erreur">', $user->getFlash(), '</p>';} ?>
  </div>

  <p class="titreFormulaire">Inscription</p>

  <form action ="" method="post" clegistrationass="formulaire">
    <?= $form ?>
    <div class="index-btn-valid">
      <input type="submit" value="Valider" class="btnValid font-weight-bold" />
    </div>
  </form>

</div>
