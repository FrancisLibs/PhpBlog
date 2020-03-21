
<div class="front-show-contenu">
  <div class="entete">
    <h2><?= htmlentities($post['title']); ?></h2>
    <p class="show-autor">Par <em><?= htmlentities($post['autor_name']); ?></em>, le <?= $post['edition_date']->format('d/m/Y à H\hi'); ?></p>

    <?php if($post['edition_date'] != $post['update_date'] && isset($post['update_date'])) { ?>
        <p>, modifié le <?= $post['update_date']->format('d/m/Y à H\hi'); ?></p>
    <?php } ?>
  </div>

  <h3 class="show-chapo"><?= htmlentities($post['chapo']); ?></h3>

  <p class="show-contenu"><?= nl2br(htmlentities($post['contenu'])); ?></p>

  <div class="commentaires">

    <div class="titreCommentaires">
      <div>
        <p>Commentaires &nbsp;</p>
      </div>
      <div>
        <?php if ($user->isAuthenticated()) {?>
          <a class="btn btn-info btn-xs btn-ajout-commentaire" role="button" href="commenter-<?= $post['id'] ?>.html">Ajouter un commentaire</a>
        <?php } ?>
      </div>
    </div>
    <div>
      <?php if (empty($comments)) { ?>
        <p class="ajout-commentaire">Aucun commentaire n'a encore été posté.</p>
      <?php } ?>
    </div>
    <div class="commentaires">
      <?php foreach ($comments as $comment) { ?>
        <p>Posté par <strong><?= htmlentities($comment['author_name']); ?></strong> le
          <?= $comment['edition_date']->format('d/m/Y à H\hi'); ?></p>

        <?php if ($user->isAuthenticated() && $comment['users_id'] == $users->id()) { ?>
          <a class="btn btn-info btn-xs" role="button" href="comment-update-<?= $comment['id'] ?>.html">Modifier</a>
        <?php } ?>

        <p><?= nl2br(htmlentities($comment['contenu'])); ?></p>

      <?php } ?>
    </div>
  </div>
</div>
