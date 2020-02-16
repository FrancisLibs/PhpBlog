<div class="contenu-principal showposts">
  <h2 class="entete">Articles</h2>
    <?php
    foreach ($listePosts as $post)
    {
    ?>
      <tr>
        <td>
          <div class="front-showPosts-title">
            <h3>{{ $post['title'] }}</h3>

            <?php
            if(isset($post['autor_name']))
            { ?>
              <p class="attributsPost"> de : <?= nl2br($post['autor_name']) ?></p>
            <?php } 

            if(isset($post['update_date']))
            { ?>
              <p class="attributsPost">Modifié le : <?= $post['update_date']->format('d/m/Y à H\hi') ?></p>
            <?php } ?>
            <a class="btn-lire btn btn-info btn-xs" role="button" href="post-<?= $post['id'] ?>.html">Lire cet article</a>
          </div>
          <div class="front-showPosts-chapo">
            <p class="chapo"><?= nl2br($post['chapo']) ?></p>
          </div>
        </td>
      </tr>
    <?php
    } ?>
  </div>
</div>
