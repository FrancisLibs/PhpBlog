<div class="contenu-principal showposts">
  <h2 class="entete">Articles</h2>
  <?php
  foreach ($listePosts as $post)
  {
  ?>
    <div class="post-title">
      <a class="btnLire" href="post-<?= $post['id'] ?>.html">Lire cet article</a>
      <h3><?= $post['title'] ?></h3>

      <?php
      if(isset($post['autor_name']))
      { ?>
        <p class="attributsPost"> de : <?= nl2br($post['autor_name']) ?></p>
      <?php } 

      if(isset($post['update_date']))
      { ?>
        <p class="attributsPost">Modifié le : <?= $post['update_date']->format('d/m/Y à H\hi') ?></p>
      <?php } ?>

    </div>

    <div class="post-chapo">
      <p class="chapo"><?= nl2br($post['chapo']) ?></p>
    </div>
  <?php
  } ?>
</div>
