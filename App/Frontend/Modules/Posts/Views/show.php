<p>Par <em><?= $post['auteur'] ?></em>, le <?= $post['dateAjout']->format('d/m/Y à H\hi') ?></p>
<h2><?= $post['titre'] ?></h2>
<p><?= nl2br($post['contenu']) ?></p>

<?php if ($post['dateAjout'] != $post['dateModif']) { ?>
  <p style="text-align: right;"><small><em>Modifiée le <?= $post['dateModif']->format('d/m/Y à H\hi') ?></em></small></p>
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
    Posté par <strong><?= htmlspecialchars($comment['auteur']) ?></strong> le <?= $comment['date']->format('d/m/Y à H\hi') ?>
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
