<div class="zone-formulaire">
  <div>
    <?php if ($user->hasFlash()) echo '<p class="ligne-message">', htmlspecialchars($user->getFlash()), '</p>'; ?>
  </div>
  <div class="formulaire">
    <p id="titreFormulaire">Ajouter un commentaire</p>
    <form action ="" method="post" class="formulaireMessage">
      <?= $form ?>
      <div class="index-btn-valid">
        <input type="submit" value="Commenter" class="btnValid font-weight-bold" />
      </div>
    </form>
  </div>
</div>
