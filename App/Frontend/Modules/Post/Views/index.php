
<div class="bloc-texte">
  <div class="bloc-perso">
    <div class="nom">
      <h1>Francis Libs</h1>
    </div>
    <div class="titre">
      <h2>Developpeur WEB</h2>
    </div>
  </div>
  <div class="sous-titre">            
    <h2>Le trait d'union entre votre immagination et votre communication Web</h2>
  </div>
</div>

<!-- Zone formulaire  -->
<div class="zone-formulaire">
  <div>
    <?php if ($user->hasFlash()) echo '<p class="ligne-erreur">', $user->getFlash(), '</p>'; ?>
  </div>
  <div class="formulaire">
    <p id="titreFormulaire">Contact</p>
    <form action ="" method="post" class="formulaireMessage">
      <?= $form ?>
      <div class="index-btn-valid">
        <input type="submit" value="Valider" class="btnValid font-weight-bold" />
      </div>
    </form>
  </div>
</div>
