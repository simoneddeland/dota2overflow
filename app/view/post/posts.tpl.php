<div class='posts'>
    <div class='questionwithcomments'>
        <div class='question'>
            <?php
            $gravatarSrc = "https://www.gravatar.com/avatar/" .  md5( strtolower( trim($question['user']['email']) )) . "?d=wavatar&s=40";
            ?>
            <div class='postheading'>
                <img src='<?= $gravatarSrc ?>'>
                <?=$question['title'] ?> av <a href='<?= $this->url->create("users/id/{$question['user']['id']}") ?>'><?= $question['user']['acronym'] ?></a>  
            </div>        
            <div class='postcontent'>
                <div class='simplepostcontent score'>
                    <a href='<?= $this->url->create("vote/up/{$question['id']}")?>'><i class="fa fa-angle-up custom" ></i></a><br>
                        <?= $question['score'] ?><br>
                    <a href='<?= $this->url->create("vote/down/{$question['id']}")?>'><i class="fa fa-angle-down custom" ></i></a><br>
                    rank
                </div>
                <?= $question['content'] ?>
            </div>
            <p class='post-small'>Skriven <?= $question['created'] ?></p>
            <p class='tags'>
            <?php if (sizeof($question['tags']) > 0) : ?>
                Taggar: 
                <?php foreach ($question['tags'] as $tag) : ?>
                    <a class='tag' href='<?= $this->url->create("tag/view/{$tag['name']}") ?>'><?= $tag['name'] ?></a> 
                <?php endforeach; ?>
            <?php endif; ?>
            </p>
            <div class="postbuttoncontainer">
                <a class="postbutton" href="<?= $this->url->create("answer/addanswer/{$question['id']}") ?>">Svara på frågan</a>
                <a class="postbutton" href="<?= $this->url->create("comment/add/{$question['id']}") ?>">Lägg till kommentar</a>
                <?php if ($loggeduser != null && $loggeduser == $question['user']['id']) : ?>
                    <a class="postbutton" href='<?=$this->url->create("post/edit/{$question['id']}")?>'>Ändra frågan</a>
                <?php endif; ?>
            </div>
        </div>
        <div class='comments'>
            <?php if (is_array($question['comments'])) : ?>
                <?php foreach ($question['comments'] as $comment) : ?>
                    <div class='comment'>
                        <a href="<?= $this->url->create("users/id/{$comment['user']['id']}") ?>"><?=$comment['user']['acronym']?></a>: 
                        <?= $comment['content'] ?>
                        <?php if ($loggeduser != null && $loggeduser == $comment['uid']) : ?>
                            <a href="<?= $this->url->create("comment/edit/{$comment['id']}") ?>">Ändra</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php
    // Print out all answers
    if (isset($question['answers'])) : 
    for ($i = 0; $i < sizeof($question['answers']); $i++) :
        $answer = $question['answers'][$i];
        $gravatarSrc = "https://www.gravatar.com/avatar/" .  md5( strtolower( trim($answer['user']['email']) )) . "?d=wavatar&s=40";
        ?>

        <div class='answerwithcomments'>
            <div class='answer'>
                <div class='postheading'>
                    <img src='<?= $gravatarSrc ?>'>
                    <?=$answer['title'] ?> av <a href='<?= $this->url->create("users/id/{$answer['user']['id']}") ?>'><?= $answer['user']['acronym'] ?></a>  
                </div>        
                <div class='postcontent'>
                    <div class='simplepostcontent score'>
                        <a href='<?= $this->url->create("vote/up/{$answer['id']}")?>'><i class="fa fa-angle-up custom" ></i></a><br>
                            <?= $answer['score'] ?><br>
                        <a href='<?= $this->url->create("vote/down/{$answer['id']}")?>'><i class="fa fa-angle-down custom" ></i></a><br>
                        rank
                    </div>                
                    <?= $answer['content'] ?>
                </div>
                <p class='post-small'>Skriven <?= $answer['created'] ?></p>
                <div class='addcomment'>
                    <a class="postbutton" href="<?= $this->url->create("comment/add/{$answer['id']}") ?>">Lägg till kommentar</a>
                    <?php if ($loggeduser != null && $loggeduser == $answer['user']['id']) : ?>
                        <a class="postbutton" href='<?=$this->url->create("answer/edit/{$answer['id']}")?>'>Ändra svaret</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class='comments'>
                <?php if (is_array($answer['comments'])) : ?>
                <?php foreach ($answer['comments'] as $comment) : ?>
                    <div class='comment'>
                        <a href="<?= $this->url->create("users/id/{$comment['user']['id']}") ?>"><?=$comment['user']['acronym']?></a>: 
                        <?= $comment['content'] ?> 
                        <?php if ($loggeduser != null && $loggeduser == $comment['uid']) : ?>
                            <a href="<?= $this->url->create("comment/edit/{$comment['id']}") ?>">Ändra</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php 
    endfor;
    endif;
    ?>
</div>