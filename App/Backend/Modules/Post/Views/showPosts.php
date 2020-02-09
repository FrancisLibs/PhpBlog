<!--<p style="text-align: center">Il y a actuellement <?= $nombrePosts ?> posts. En voici la liste :</p>
<p style="text-align: center">Il y a actuellement <?= $nombreCommentairesInvalides ?> commentaires à valider</p>
-->
<div class="centragePage">
  <div class="entete-admin-showPosts">
    <h2 class="entete-admin-posts"> Liste des posts</h2>
    <a class="btn btn-primary btn-admin-showPosts" href="/admin/post-insert.html" role="button">Ajouter post</a>
  </div>

  <div class="container-fluid">
    <div class="col-lg-8 table-admin-showPosts">
      <div class="table-responsive-sm">
        <table class="table">
        <tr>
          <th>Auteur</th>
          <th>Titre</th>
          <th>Date d'ajout</th>
          <th>Dernière modification</th>
          <th>Action</th>
        </tr>

        <?php
        foreach ($listePosts as $post)
        {
          echo '
          <tr>
            <td>
              <em>', $post['autor_name'], '</em>
            </td>
            <td>
               <a href="post-show-', $post['id'] ,'.html">',$post['title'] ,'</a>
            </td>
            <td>
              le ', $post['edition_date']->format('d/m/Y à H\hi'), '
            </td>
            <td>
              ', ($post['edition_date'] == $post['update_date'] ? '-' : 'le '.$post['update_date']->format('d/m/Y à H\hi')), '
            </td>
            <td>
              <a href="post-update-', $post['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a>
              <a href="post-delete-', $post['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a>
            </td>
          </tr>
          ', "\n";
          } ?>
        </table>
      </div>
    </div>
  </div>
</div>
