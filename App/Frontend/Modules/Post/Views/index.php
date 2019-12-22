<?php
foreach ($listePosts as $post)
{
?>
  <div class ="post-title">
    <h2 ><a href="post-<?= $post['id'] ?>.html"><?= $post['title'] ?></a></h2>
  </div>
  <div class="contents">
    <p><?= nl2br($post['chapo']) ?></p>
  </div>
<?php
}
