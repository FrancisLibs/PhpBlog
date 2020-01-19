<h4>Auteur : <?= $post['author_name'] ?></h4>
<h4>Titre : <?= $post['title'] ?></h4>
<h4>Chapô : <?= $post['chapo'] ?></h4>
<h4>Contenu : <?= $post['contenu'] ?></h4>
<h4>Créé le : <?= $post['edition_date']->format('d/m/Y à H\hi') ?></h4>

<table>
  <tr>
    <th>Auteur</th>
    <th>Commentaire</th>
    <th>Date création</th>
    <th>Action</th>
  </tr>

  <?php foreach ($comments as $comment) { ?>
    <tr>
      <td>
        <?= $comment['author_name'] ?>
      </td>
      <td>
        <?= $comment['contenu'] ?>
      </td>
      <td>
        <?= $comment['edition_date']->format('d/m/Y à H\hi') ?>
      </td>
      <td>
        <a href="comment-update-<?= $comment['id'] ?>.html"><img src="/images/update.png" alt="Modifier" /></a>
        <a href="comment-delete-<?= $comment['id'] ?>.html"><img src="/images/delete.png" alt="Supprimer" /></a>
        <?php if($comment->state()==0) {?><a href="comment-moderate-<?= $comment['id'] ?>.html"><img src="/images/select.png" alt="Valider" /></a> <?php } ?>
      </td>
    </tr>
  <?php } ?>
</table>

<p><a href="commenter-<?= $post['id'] ?>.html">Ajouter un commentaire</a></p>

