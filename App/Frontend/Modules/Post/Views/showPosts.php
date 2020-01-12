<?php
foreach ($listePosts as $post)
{
?>
  <div class ="post-title">
    <h4 ><a href="post-<?= $post['id'] ?>.html"><?= $post['title'] ?></a></h4>
  </div>
  <div class="post-chapo">
    <p>Chapo : <?= nl2br($post['chapo']) ?></p>
  </div>
   <div class="post-autheur">
    <p>Auteur : <?= nl2br($post['autor_name']) ?></p>
  </div>
   <div class="post-chapo">
    <p>DateModif. :<?= $post['update_date']->format('d/m/Y à H\hi') ?></p>
  </div>
<?php
} ?>
