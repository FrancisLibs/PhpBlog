
<div class="front-show-contenu">
  <div class="entete">
    <h2><?= $post['title'] ?></h2>
    <p class="show-autor">Par <em><?= $post['autor_name'] ?></em>, le <?= $post['edition_date']->format('d/m/Y à H\hi') ?></p>
    <?php 
      if($post['edition_date'] != $post['update_date'] && isset($post['update_date'])) 
        { ?>
        <p>, modifié le <?= $post['update_date']->format('d/m/Y à H\hi') ?></p>
        <?php 
        } ?>
  </div>

  <h3 class="show-chapo"><?= $post['chapo'] ?></h3>
  
  <p class="show-contenu"><?= nl2br($post['contenu']) ?></p>

  <div class="commenatires">
    <div class="titreCommentaires">
      <p>Commentaires</p>
      <?php
      if (empty($comments) && $user->isAuthenticated())
      { ?>
        <p class="ajout-commentaire">Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
      <?php
      }
      if ($user->isAuthenticated())
      { ?>
        <a class="btn btn-info btn-xs ajout-commentaire" role="button" href="commenter-<?= $post['id'] ?>.html">Ajouter un commentaire</a>
      <?php
      } ?>
    </div>
    <div class="commentaires">
      <?php
      foreach ($comments as $comment)
      { ?>
        Posté par <strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['edition_date']->format('d/m/Y à H\hi') ?>
        <?php if ($user->isAuthenticated() && $comment['users_id'] == $users->id()) { ?>
          <a class="btn btn-info btn-xs" role="button" href="comment-update-<?= $comment['id'] ?>.html">Modifier</a>
        <?php } ?>
      </legend>
      <p><?= nl2br(htmlspecialchars($comment['contenu'])) ?></p>
      <?php
      } ?>
    </div>
  </div>
</div>

