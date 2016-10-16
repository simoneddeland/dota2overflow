<hr>

<h2>Kommentarer</h2>

<?php if (is_array($comments)) : ?>
<div class='comments'>
    <?php for ($i = sizeof($comments) - 1; $i >= 0; $i--) : ?>
    <?php $comment = $comments[$i]; ?>
    <?php $id = $comment->id; ?>
    <div class='comment'>
        <h3 class='commentheading'>
            <?=$comment->name ?><?= !empty($comment->web) ? ", <a href='". $comment->web . "'>" . $comment->web . "</a>" : ""?><?= !empty($comment->email) ? ", <a href='mailto:". $comment->email . "'>" . $comment->email . "</a>" : ""?>
        </h3>
        <p class='commentcontent'><?= $comment->content ?></p>
        <p class='comment-small'>Skriven <?= $comment->created ?> <a href='<?=$this->url->create("comment/edit/$id")?>'>Ändra</a> <a href='<?=$this->url->create("comment/delete/$id")?>'>Ta bort</a></p>
    </div>
    <?php endfor; ?>
</div>
<?php endif; ?>