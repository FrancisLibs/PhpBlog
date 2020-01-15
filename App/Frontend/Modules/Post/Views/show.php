<p>Par <em><?= $post['author_name'] ?></em>, le <?= $post['edition_date']->format('d/m/Y à H\hi') ?></p>
<h2>Titre : <?= $post['title'] ?></h2>
<h3>Chapo : <?= $post['chapo'] ?></h3>
<p>Contenu : <?= nl2br($post['contenu']) ?></p>

<?php if ($post['edition_date'] != $post['updatedate']) { ?>
  <p style="text-align: right;"><small><em>Modifiée le <?= $post['update_date']->format('d/m/Y à H\hi') ?></em></small></p>
<?php } ?>

<p><a href="commenter-<?= $post['id'] ?>.html">Ajouter un commentaire</a></p>

<?php
if (empty($comments))
{
?>
<p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
<?php
}

foreach ($comments as $comment)
{
?>
<fieldset>
  <legend>
    Posté par <strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['edition_date']->format('d/m/Y à H\hi') ?>
    <?php if ($user->isAuthenticated()) { ?> -
      <a href="admin/comment-update-<?= $comment['id'] ?>.html">Modifier</a> |
      <a href="admin/comment-delete-<?= $comment['id'] ?>.html">Supprimer</a>
    <?php } ?>
  </legend>
  <p><?= nl2br(htmlspecialchars($comment['contenu'])) ?></p>
</fieldset>
<?php
}
?>

<p><a href="commenter-<?= $post['id'] ?>.html">Ajouter un commentaire</a></p>
