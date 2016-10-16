<h2>De 5 populäraste taggarna</h2>
<p>
<?php foreach ($tags as $tag) : ?>
<a class='tag' href='<?= $this->url->create("tag/view/{$tag['name']}") ?>'><?= $tag['name'] ?></a> x <?= $tag['num']?><br>

<?php endforeach; ?>
</p>