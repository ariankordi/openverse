<?php
$title = 'Hash Generator';
require_once '../inc/connect.php';
require_once '../inc/htm.php'; openHead();
echo '<div class="main-column"><div class="post-list-outline"><form>Password: <input name="password"><input type="submit"><br>';
if(isset($_GET['password'])) {
echo password_hash($_GET['password'],PASSWORD_BCRYPT);
}
echo '</form></div></div>';
openFoot();