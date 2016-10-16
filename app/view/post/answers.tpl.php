<?php if (is_array($answers)): ?>    
<div class='answers'>
    <?php foreach ($answers as $answer) :?>
    <?php
    $currentUser = $userInfo[$answer->uid];
    $gravatarSrc = "https://www.gravatar.com/avatar/" .  md5( strtolower( trim($currentUser['email']) )) . "?d=mm&s=40";
    ?>
        <p><h4><img src='<?= $gravatarSrc ?>'><?= htmlspecialchars($answer->title) ?> av <?= $currentUser['acronym'] ?></h4><?= htmlspecialchars($answer->content) ?> </p>
    <?php endforeach; ?>
</div>
<?php endif; ?>
