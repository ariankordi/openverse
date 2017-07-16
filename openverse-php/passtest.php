<?php
$title = 'Hash Test';
require_once '../inc/connect.php';
require_once '../inc/htm.php'; openHead();
echo '<div class="main-column"><div class="post-list-outline"><form>Password: <input name="password"><input type="submit"><br>';

if (password_verify($_GET['password'], password_hash("pokemon11", PASSWORD_BCRYPT))) {
    echo 'Password is valid!!';
} else {
    echo 'Invalid password.';
}
echo '</form></div></div>';
openFoot();