<div class="back-commentInsert-contenu">
  <div class="zone-formulaire">
    <?php if ($user->hasFlash()) echo '<p class="ligneErreur">',$user->getFlash(), '</p>'; ?>
     <div class="formulaire">
      <p id="titreFormulaire">Ajouter un commentaire</p>
      <form action ="" method="post" class="formulaireMessage">
        <?= $form ?>
        <div id="btnValid">
          <input type="submit" value="Ajouter" class="btnValid" />
        </div>
      </form>
    </div>
  </div>
</div>
