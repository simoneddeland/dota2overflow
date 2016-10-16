<?php
$gravatarSrc = "https://www.gravatar.com/avatar/" .  md5( strtolower( trim($user['email']) )) . "?d=wavatar";
?>
<img src='<?= $gravatarSrc?>' alt='gravatar'>
<h2><?= $user['acronym'] ?></h2>
<p>
Email: <?= $user['email'] ?><br>
Senast aktiv: <?= $user['active'] ?>
</p>
<h4>Beskrivning</h4>
<p>
<?= $user['profilecontent'] ?>
</p>
<h4>Frågor av användaren</h4>
<p>
<?php
if (sizeof($posts) > 0) :
foreach ($posts as $post): ?>
<a href="<?= $this->url->create("post/view/{$post['id']}") ?>"><?= $post['title'] ?></a><br>  

<?php endforeach; 
endif;
if (sizeof($posts) == 0) :?>
    Användaren har inte skrivit några frågor än.
<?php
endif;
?>
</p>
<h4>Svar av användaren</h4>
<p>
<?php
if (sizeof($answers) > 0) :
foreach ($answers as $answer): ?>
<a href="<?= $this->url->create("post/view/{$answer['rootnode']}") ?>"><?= $answer['title'] ?></a><br>  

<?php endforeach;
endif;
if (sizeof($answers) == 0) :
?>
    Användaren har inte skrivit några svar än.
<?php
endif;
?>
</p>