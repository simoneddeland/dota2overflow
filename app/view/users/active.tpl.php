<h3>Aktiva användare</h3>
<?php if (count($users) != 0) : ?>
    <?php foreach ($users as $user) : ?>
        <?php
        $gravatarSrc = "https://www.gravatar.com/avatar/" .  md5( strtolower( trim($user['email']) )) . "?d=wavatar";
        ?>
        <a class='usercard' href="<?= $this->url->create("users/id/{$user['id']}") ?>">
            
            <img src='<?= $gravatarSrc?>' alt='gravatar'><br>
            <?= $user['acronym']?>
        </a>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (count($users) == 0) : ?>
<p>Det finns inga användare att visa.</p>
<?php endif; ?>