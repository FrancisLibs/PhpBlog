
<p>Par <em><?= $post['author_name'] ?></em>, le <?= $post['edition_date']->format('d/m/Y à H\hi') ?></p>
<h2>Titre : <?= $post['title'] ?></h2>
<h3>Chapo : <?= $post['chapo'] ?></h3>
<p>Contenu : <?= nl2br($post['contenu']) ?></p>

<?php if ($post['edition_date'] != $post['updatedate']) { ?>
  <p>Modifié le <?= $post['update_date']->format('d/m/Y à H\hi') ?></p>
<?php }

if ($user->isAuthenticated())
{ ?>
  <p><a href="commenter-<?= $post['id'] ?>.html">Ajouter un commentaire</a></p>
<?php
}

if (empty($comments))
{
?>
<p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
<?php
}

foreach ($comments as $comment)
{ ?>
<fieldset>
  <legend>
    Posté par <strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['edition_date']->format('d/m/Y à H\hi') ?>
    <?php if ($user->isAuthenticated() && $comment['users_id'] == $users->id()) { ?>
      <a href="comment-update-<?= $comment['id'] ?>.html">Modifier</a>
    <?php } ?>
  </legend>
  <p><?= nl2br(htmlspecialchars($comment['contenu'])) ?></p>
</fieldset>
<?php
}


