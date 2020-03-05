<!-- Zone formulaire  -->
<div class="container-fluid">
  <div class="zone-formulaire">
    <div>
      <?php if ($user->hasFlash()) {echo '<p class="ligne-erreur">', $user->getFlash(), '</p>';} ?>
    </div>
    <div class="formulaire-inscription">
      <p id="titreFormulaire">Inscription</p>
      <form action ="" method="post" class="formulaireMessage">
        <?= $form ?>
        <div class="index-btn-valid">
          <input type="submit" value="Valider" class="btnValid font-weight-bold" />
        </div>
      </form>
    </div>
  </div>
</div>
