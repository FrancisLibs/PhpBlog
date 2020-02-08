<div class="back-show-contenu">
  <div class="entete">
    <h2><?= $post['title'] ?></h2>
    <p class="show-autor">Par <em><?= $post['autor_name'] ?></em>, le <?= $post['edition_date']->format('d/m/Y à H\hi') ?></p>
    <?php 
    if($post['edition_date'] != $post['updatedate'] && isset($post['update_date'])) 
    { ?>
      <p>, modifié le <?= $post['update_date']->format('d/m/Y à H\hi') ?></p>
    <?php } ?>
  </div>

  <h3 class="show-chapo"><?= $post['chapo'] ?></h3>
  <p class="show-contenu"><?= nl2br($post['contenu']) ?></p>

  <?php
  if (empty($comments))
  { ?>
    <p class="show-ajout-commentaire">Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
  <?php }
  else
  { 
    foreach ($comments as $comment) 
    { ?>
      <div class="back-show-entete">
        <span>Commentaire laissé par <?= htmlspecialchars($comment->author_name()) ?></span>
        <span>, le &nbsp;<?= htmlspecialchars($comment->edition_date()->format('d/m/Y à H\hi')) ?></span>
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
        <?= htmlspecialchars($comment->contenu()) ?>
      </div>
    <?php } 
  }?> 

  <a class="show-ajout-commentaire" href="commenter-<?= $post['id'] ?>.html">Ajouter un commentaire</a>
  <br /><br />
  <a class="show-ajout-commentaire"href="posts.html">Retour à la liste des posts</a>
</div>