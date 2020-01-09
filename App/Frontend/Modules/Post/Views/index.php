<div class="page-accueil">
  <div class="container-fluid">
    <div class="row">
      <!-- Zone titre / Sous titre -->
      <div class="col-xl-12  ligne-titre">
        <div class="titre-page">
          <h1>La Webuzine</h1>
          <div class="sous-titre">
            Le trait d'union entre votre immagination et votre communication Web
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-around">
      <!-- Zone Posts  -->
      <div class="col-lg-6 col-lg-offset-1 posts-box">
        <?php
        foreach ($listePosts as $post)
        { ?>
          <div>
            <h4><a class ="post-title" href="post-<?= $post['id'] ?>.html"><?= $post['title'] ?></a></h4>
          </div>
          <div class="post-chapo">
            <p><?= nl2br($post['chapo']) ?></p>
          </div>
        <?php
        } ?>
      </div>
       <div class="col-lg-3">
            <div class="formulaireMessageBox">
              <p id="titreFormulaire">Contact</p>
              <form action ="" method="post" class="formulaireMessage form-inline">
                <?= $form ?>
                <input type="submit" value="Valider" class="btnValid" />
              </form>
            </div>
          </div>
    </div>
  </div>
</div>
