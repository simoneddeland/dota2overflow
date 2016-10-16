<h2><?= $title ?></h2>
<?php if (sizeof($posts) > 0) : ?>
<div class='posts'>
    <?php for ($i = 0; $i < sizeof($posts); $i++) : ?>
    <?php $post = $posts[$i]; ?>
    <?php $id = $post['id']; ?>
    <div class='postsimple'>
        <div class='simplepostcontent score'>
            <a href='<?= $this->url->create("vote/up/{$post['id']}")?>'><i class="fa fa-angle-up custom" ></i></a><br>
            <?= $post['score'] ?><br>
            <a href='<?= $this->url->create("vote/down/{$post['id']}")?>'><i class="fa fa-angle-down custom" ></i></a><br>
            rank
        </div>
        <div class='simplepostcontent answers'>            
            <?= $post['numAnswers'] ?><br>            
            svar
        </div>
        <div class='simplepostcontent main'>
            <a class='questionlink' href='<?=$this->url->create("post/view/$id")?>'><?=htmlspecialchars($post['title']) ?></a><br>
            <?php if (sizeof($post['tags']) > 0) : ?>
                <?php foreach ($post['tags'] as $tag) : ?>
                    <a class='tag' href='<?= $this->url->create("tag/view/{$tag['name']}") ?>'><?= htmlspecialchars($tag['name']) ?></a> 
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class='simplepostcontent by'>
            Frågat av <a href='<?= $this->url->create("users/id/{$post['user']['id']}") ?>'><?= $post['user']['acronym'] ?></a><br>
            <span class="small-text"><?= $post['created'] ?></span>
        </div>              
    </div>
    <?php endfor; ?>
</div>
<?php endif; ?>
<?php if (sizeof($posts) == 0): ?>
Det finns inga frågor att visa.
<?php endif; ?>