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
            <!-- <a href="https://github.com/Dylan-olivro">Github</a> -->
            <?php
            if (isset($_SESSION['user'])) { ?>
                <a href="<?= $href ?>profil.php">Profil</a>
                <a href="<?= $href ?>disconnect.php">Disconnect</a>
                <?php if ($_SESSION['user']->role !== 0) { ?>
                    <a href="<?= $href ?>admin.php">admin</a>
                    <a href="<?= $href ?>addItems.php">add Items</a>
                    <a href="<?= $href ?>detail.php">detail</a>
                <?php
                }
            } else { ?>
                <a href="<?= $href ?>connect.php">connect</a>
                <a href="<?= $href ?>signUp.php">signUp</a>
                <a href="<?= $href ?>add_item.php">ADD</a>
            <?php } ?>
        </nav>
    </div>
<?php
}
