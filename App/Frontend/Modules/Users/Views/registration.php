<!-- Zone formulaire  -->
<div class="container-fluid">
  <div class="zone-formulaire-registration">
    <div>
      <?php if ($user->hasFlash()) {echo '<p class="ligne-erreur">', $user->getFlash(), '</p>';} ?>
    </div>
    <div class="formulaire-registration">
      <p id="titreFormulaire">Inscription</p>
      <form action ="" method="post" clegistrationass="formulaireMessage">
        <?= $form ?>
        <div class="index-btn-valid">
          <input type="submit" value="Valider" class="btnValid font-weight-bold" />
        </div>
      </form>
    </div>
  </div>
</div>
