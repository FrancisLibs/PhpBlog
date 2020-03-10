
<div class="bloc-index">
  <div class="bloc-perso">
    <div class="nom-index">
      <h1>Francis Libs</h1>
    </div>
    <div class="titre-index">
      <h2>Developpeur WEB</h2>
    </div>
    <div class="logo-index">
      <img class="logo" src="../images/logo.png" alt="logo">
    </div>
    <div class="sous-titre-index">
      <p>Trait d'union entre votre immagination et votre communication Web</p>
    </div>
  </div>

  <!-- Zone formulaire  -->
  <div class="zoneFormulaire formulaireIndex">

    <p class="titreFormulaire">Contact</p>

    <!-- Zone message flash  -->
    <div class="zone-message">
      <?php if ($user->hasFlash())
        {
          echo '<p class="ligne-erreur">', $user->getFlash(), '</p>';
        } ?>
    </div>

    <form action ="" method="post" class="formulaire">
      <?= $form ?>
      <div class="index-btn-valid">
        <input type="submit" value="Valider" class="btnValid font-weight-bold" />
      </div>
    </form>

</div>


