<div class="contenu-principal showposts">
  <h2 class="entete">Articles</h2>
    <?php
    if(isset($listePosts)){
      foreach ($listePosts as $post)
      { ?>
        <tr>
          <td>
            <div class="front-showPosts-title">
              <h3><?= htmlspecialchars($post['title']) ?></h3>
<<<<<<< HEAD
              <p class="attributsPost"> de : <?= nl2br(htmlspecialchars($post['autor_name'])) ?></p>
=======
              <p class="attributsPost"> de <?= nl2br(htmlspecialchars($post['autor_name'])) ?></p>
>>>>>>> security
              <?php if(isset($post['update_date']))
              { ?>
                <p class="attributsPost">Modifié le : <?= htmlspecialchars($post['update_date']->format('d/m/Y à H\hi')) ?></p>
              <?php } ?>
              <a class="btn-lire btn btn-info btn-xs" role="button" href="post-<?= $post['id'] ?>.html">Lire cet article</a>
            </div>
            <div class="front-showPosts-chapo">
              <p class="chapo"><?= nl2br(htmlspecialchars($post['chapo'])) ?></p>
            </div>
          </td>
        </tr>
      <?php
      } 
    }
    else
      { ?>
        <p>Il n'y a aucun articles à afficher</p>
      <?php } ?>
  </div>
</div>
