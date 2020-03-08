<!-- Zone formulaire  -->
<div class="zone-formulaire-connexion">
  <div class="flash-connexion">
    <?php if ($user->hasFlash()) {echo '<p class="ligne-erreur">', $user->getFlash(), '</p>';} ?>
  </div>
  <div class="formulaire-connexion">
    <p id="titreFormulaire">Connexion</p>
    <form action ="" method="post" class="formulaireMessage">
      <?= $form ?>
      <div class="index-btn-valid">
        <input type="submit" value="Valider" class="btnValid font-weight-bold" />
      </div>
    </form>
  </div>
</div>
