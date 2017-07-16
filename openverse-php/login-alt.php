<?php
$title = 'Log In';
$auth = true;
require_once '../inc/connect.php';
require_once '../inc/htm.php'; openHead();
if($_SESSION['signed_in'] == true) {
echo '<script>window.location.replace("/");</script>';
} else {
    if($_SERVER['REQUEST_METHOD'] == 'GET' || isset($_POST['x'])) {
include 'login-form.php';
echo '<br><input type="submit" value="Sign In"><br><br></form></div></div>';
    } else if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(!isset($_POST['username']))
        {
include 'login-form.php';
echo '<p style="color:red">The username field cannot be empty.</p><br><input type="submit" value="Sign In"><br><br></form></div></div>';
        } else if(!isset($_POST['password'])) {
include 'login-form.php';
echo '<p style="color:red">The password field cannot be empty.</p><br><input type="submit" value="Sign In"><br><br></form></div></div>';
        } else {
            $sql = "SELECT * FROM users WHERE user_id = '" . mysqli_real_escape_string($link, $_POST['username']) . "'";
            $result = mysqli_query($link, $sql);
            if(mysqli_error($link)) {
include 'login-form.php';
echo '<p style="color:red">Something went wrong while signing in. Error code: ' . htmlspecialchars(mysqli_errno($link)) . '</p><br><input type="submit" value="Sign In"><br><br></form></div></div>';
            } else {
                $row = mysqli_fetch_assoc($result);
                if(!password_verify($_POST['password'], $row['user_pass'])) {
include 'login-form.php';
echo '<p style="color:red">You have entered an invalid username/password combination.</p><br><input type="submit" value="Sign In"><br><br></form></div></div>';
if($_COOKIE['debug']=='true'){
print_r($row);
echo '<br>$row: ' . $row['user_pass'] . '<br>password_hash: ' . password_hash($_POST['password'], PASSWORD_DEFAULT);
}
                } else {
session_start();
$_SESSION['signed_in'] = true;
$_SESSION['user_id'] = $row['user_id'];
$_SESSION['user_pid'] = $row['user_pid'];
$_SESSION['user_name'] = $row['user_name'];
$_SESSION['user_rank'] = $row['user_rank'];
$_SESSION['user_avatar'] = $row['user_avatar'];
$_SESSION['user_timezone'] = 'America/New_York';
                     
echo '<script>window.location.replace("/");</script>';
                }
            }
        }
    } else {
    http_response_code(405);
    echo '<div class="no-content"><p>That page could not be found.</p></div>';
}}
 
openFoot();