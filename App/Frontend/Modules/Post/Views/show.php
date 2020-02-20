
<div class="front-show-contenu">
  <div class="entete">
    <h2><?= htmlspecialchars($post['title']) ?></h2>
    <p class="show-autor">Par <em><?= htmlspecialchars($post['autor_name']) ?></em>, le <?= htmlspecialchars($post['edition_date']->format('d/m/Y à H\hi'))?></p>

    <?php if($post['edition_date'] != $post['update_date'] && isset($post['update_date'])) { ?>
        <p>, modifié le <?= htmlspecialchars($post['update_date']->format('d/m/Y à H\hi')) ?></p>
    <?php } ?>
  </div>

  <h3 class="show-chapo"><?= htmlspecialchars($post['chapo']) ?></h3>
  
  <p class="show-contenu"><?= nl2br(htmlspecialchars($post['contenu'])) ?></p>

  <div class="commentaires">

    <div class="titreCommentaires">
      <div>
        <p>Commentaires</p>
      </div>
      <div>
        <?php if ($user->isAuthenticated()) {?>
          <a class="btn btn-info btn-xs ajout-commentaire" role="button" href="commenter-<?= $post['id'] ?>.html">Ajouter un commentaire</a>
        <?php } ?>
      </div>
    </div>
    <div>
      <?php if (empty($comments) && $user->isAuthenticated()) { ?>
        <p class="ajout-commentaire">Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
      <?php } ?>
    </div>
    <div class="commentaires">
      <?php foreach ($comments as $comment) { ?>
        <p>Posté par <strong><?= htmlspecialchars($comment['author']) ?></strong> le 
          <?= htmlspecialchars($comment['edition_date']->format('d/m/Y à H\hi')) ?></p>

        <?php if ($user->isAuthenticated() && $comment['users_id'] == $users->id()) { ?>
          <a class="btn btn-info btn-xs" role="button" href="comment-update-<?= $comment['id'] ?>.html">Modifier</a>
        <?php } ?>

        <p><?= nl2br(htmlspecialchars($comment['contenu'])) ?></p>

      <?php } ?>
    </div>
  </div>
</div>

