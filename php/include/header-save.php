<?php
if (getURL()[0][1] === '/index.php' || getURL()[0][1] === '/') {
    includeHeaderSave('./', './php/');
} else {
    if (getURL()[1][2] === 'user') {
        includeHeaderSave('../../', "../");
    } else {
        includeHeaderSave('../', './');
    }
}

function includeHeaderSave($index, $href)
{ ?>
    <div>
        <nav>
            <a href="<?= $index ?>index.php">Index</a>
            <?php
            if (isset($_SESSION['user'])) { ?>
                <a href="<?= $href ?>profil.php">Profil</a>
                <a href="<?= $href ?>itemFilter.php">Filter</a>
                <a href="<?= $href ?>cartPage.php">Cart</a>
                <?php if ($_SESSION['user']->user_role !== 0) { ?>
                    <a href="<?= $href ?>admin.php">Admin</a>
                <?php } ?>
                <a href="<?= $href ?>disconnect.php">Disconnect</a>
            <?php } else { ?>
                <a href="<?= $href ?>connect.php">Connect</a>
                <a href="<?= $href ?>signUp.php">SignUp</a>
            <?php } ?>
        </nav>
    </div>
<?php
}
