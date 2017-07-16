<?php
$title = 'Hash Test';
$auth = true;
require_once '../inc/connect.php';
require_once '../inc/htm.php'; openHead();
echo '<div class="main-column"><div class="post-list-outline"><form>Password: <input name="password"><input type="submit"><br>';
$result = mysqli_query($link, "SELECT * FROM users WHERE user_id = 'PF2M'");
$row = mysqli_fetch_assoc($result);
$spa = password_hash($_GET['password'], PASSWORD_BCRYPT);
if (password_verify($_GET['password'], $row['user_pass'])) {
    echo 'Password is valid.<br>$row: '.$row['user_pass'].'<br>$wor: '.password_hash($_GET['password'], PASSWORD_BCRYPT).'<br>Errors: '.mysqli_error($link).'<br>Rows: '.mysqli_num_rows($result).'<br>';
echo $spa;
} else {
    echo 'Invalid password.<br>$row: '.$row['user_pass'].'<br>$wor: '.password_hash($_GET['password'], PASSWORD_BCRYPT).'<br>Errors: '.mysqli_error($link).'<br>Rows: '.mysqli_num_rows($result);
}
echo '</form></div></div>';
openFoot();