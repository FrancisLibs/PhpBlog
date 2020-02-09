<div class="zone-formulaire-accueil">
  <div>
    <?php if ($user->hasFlash()) echo $user->getFlash(), '</p>'; ?>
  </div>
     <div class="formulaire">
      <p id="titreFormulaire">Ajouter un commentaire</p>
      <form action ="" method="post" class="formulaireMessage">
        <?= $form ?>
        <div class="index-btn-valid">
          <input type="submit" value="Ajouter" class="btnValid font-weight-bold" />
        </div>
      </form>
    </div>
  </div>
</div>