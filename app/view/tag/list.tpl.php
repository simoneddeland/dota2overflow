<h2>Frågornas taggar</h2>
<p>
    Här kan du se alla taggar som används eller har använts på sidan. Tryck på en tagg för att se de frågor som är taggade med just den taggen.
</p>
<h4>Taggarna</h4>
<div class='tags'>
    <?php foreach ($tags as $tag) : ?>
    <a class='tag' href='<?= $this->url->create("tag/view/{$tag['name']}") ?>'><?= $tag['name'] ?></a> 
    <?php endforeach; ?>
</div>