<div class="back-show-contenu">
  <div class="entete">
    <div class="titre">
        <h2><?= htmlentities($post['title']); ?></h2>
        <a class="btn btn-info btn-xs modif-article" role="button" href="post-update-<?= $post->id(); ?>.html">Modifier</a>
        <a class="btn btn-info btn-xs show-ajout-commentaire"href="posts.html">Retour à la liste des posts</a>
    </div>
    <p class="show-autor">Par <em><?= htmlentities($post['autor_name']); ?></em> le <?= $post['edition_date']->format('d/m/Y à H\hi'); ?>
    <?php
    if($post['edition_date'] != $post['updatedate'] && isset($post['update_date']))
    { ?>
       , modifié le <?= $post['update_date']->format('d/m/Y à H\hi'); ?></p>
    <?php } ?>
  </div>

  <h3 class="show-chapo"><?= htmlentities($post['chapo']); ?></h3>
  <p class="show-contenu"><?= htmlentities($post['contenu']); ?></p>

  <?php
  if (empty($comments))
  { ?>
    <p class="show-btn-ajout-commentaire">Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
  <?php }
  else
  {
    foreach ($comments as $comment)
    { ?>
      <div class="back-show-entete">
        <span>Commentaire laissé par <?= htmlentities($comment->author_name()); ?></span>
        <span>, le &nbsp;<?= $comment->edition_date()->format('d/m/Y à H\hi'); ?> &nbsp;</span>
        <div>
          <a class="btn btn-info btn-xs" role="button" href="comment-update-<?= $comment->id() ?>.html">Modifier</a>
          <a class="btn btn-info btn-xs" role="button" href="comment-refuse-<?= $comment->id() ?>.html">Refuser</a>
          <?php
            if($comment->state()==0)
            { ?>
              <a class="btn btn-info btn-xs" role="button" href="comment-validate-<?= $comment->id() ?>.html">Valider</a>
          <?php } ?>
        </div>
      </div>
      <div>
        <?= htmlentities($comment->contenu()); ?>
      </div>
    <?php }
  }?>

  <a class="btn btn-info btn-xs ajout-commentaire" role="button" href="commenter-<?= $post['id'] ?>.html">Ajouter un commentaire</a>
  <br /><br />

</div>
