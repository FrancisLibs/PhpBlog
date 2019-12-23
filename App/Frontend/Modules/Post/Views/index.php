<?php
foreach ($listePosts as $post)
{
?>
  <div class ="post-title">
    <h4 ><a href="post-<?= $post['id'] ?>.html"><?= $post['title'] ?></a></h4>
  </div>
  <div class="post-chapo">
    <p><?= nl2br($post['chapo']) ?></p>
  </div>
<?php
}
