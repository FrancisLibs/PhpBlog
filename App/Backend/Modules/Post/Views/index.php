<p style="text-align: center">Il y a actuellement <?= $nombrepost ?> posts. En voici la liste :</p>

<table>
  <tr><th>Auteur</th><th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr>
<?php
foreach ($listePosts as $post)
{
  echo '<tr><td>', $post['author'], '</td><td>', $post['title'], '</td><td>le ', $post['edition_date']->format('d/m/Y à H\hi'), '</td><td>', ($post['edition_date'] == $post['modify_date'] ? '-' : 'le '.$post['modify_date']->format('d/m/Y à H\hi')), '</td><td><a href="post-update-', $post['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> <a href="post-delete-', $post['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td></tr>', "\n";
}
?>
</table>