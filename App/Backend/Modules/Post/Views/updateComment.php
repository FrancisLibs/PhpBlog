<div class="zone-formulaire">
  <div>
    <?php if ($user->hasFlash()) echo '<p>', $user->getFlash(), '</p>'; ?>
  </div>
 <div class="formulaire">
  <p id="titreFormulaire">Modifier un commentaire</p>
  <form action ="" method="post" class="formulaireMessage">
    <?= $form ?>
    <div class="index-btn-valid">
      <input type="submit" value="Modifier" class="btnValid font-weight-bold" />
    </div>
  </form>
</div>