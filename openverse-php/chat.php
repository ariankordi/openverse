<?php
if($_SERVER['REQUEST_METHOD']=='GET'){
require_once '../inc/connect.php';
$sql = "SELECT * FROM (communities) WHERE community_id = " . mysqli_real_escape_string($link, $_GET['id']);
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
$title = $row['community_title'];

require_once '../inc/htm.php'; openHead();

if(!$result)
{
    echo '<div class="no-content"><p>The page could not be found.</p></div>';
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo '<div class="no-content"><p>The page could not be found.</p></div>';
    }
    else
    {
echo '<div id="sidebar"><section class="sidebar-container" id="sidebar-community"><span id="sidebar-cover"> <a href="/communities/' . $row['community_id'] . '"><img src="' . $row['community_banner'] . '"></a></span><header id="sidebar-community-body"><span id="sidebar-community-img"><span class="icon-container"><a href="/communities/' . $row['community_id'] . '"><img src="' . $row['community_icon'] . '" class="icon"></a></span>';
echo '<span class="platform-tag"></span>';
echo '</span><h1 class="community-name"><a href="/communities/' . $row['community_id'] . '">' . $row['community_title'] . '</a></h1></header><div class="community-description"><p class="text">' . $row['community_description'] . '</p></div>';
//remember to insert favorite button code here at some point
echo '</section></div><div class="main-column"><div class="post-list-outline">';
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
$sql = "SELECT * FROM messages LEFT JOIN users ON messages.msg_by = users.user_id WHERE messages.msg_room = " . $_GET['id'];
$result = mysqli_query($link, $sql);
if(!$result){
echo '<div class="no-content"><p>An error occurred while grabbing the chat messages.</p></div>';
} else {
echo '<input><button onclick="send();">Send</button>';
if(mysqli_num_rows($result)==0){
echo '<div class="no-content"><p>No messages have been made yet.</p></div>';
} else {
echo 'messages';
}}} else {
echo '<div class="no-content"><p>You must be signed in to chat.</p></div>';
}}}
echo '</div></div></div></div>';
}
if($_SERVER['REQUEST_METHOD']=='POST'){
if(!isset($_POST['msg'])){
http_response_code(400);
echo 'You didn\'t include a message.';
} else {
$query  = "BEGIN WORK;";
        $result = mysqli_query($link, $query);
$sql = "INSERT INTO messages(msg_by, msg_content, msg_date, msg_room) VALUES('" . $_SESSION['user_id'] . "', '" . $_POST['msg'] . "', NOW(), '" . $_GET['id'] . "')";
$result = mysqli_query($link, $sql);
if(mysqli_error($link)){
http_response_code(400);
echo 'It didn\'t work. ' . mysqli_error($link);
                $sql = "ROLLBACK;";
                $result = mysqli_query($link, $sql);
            } else {
                    $sql = "COMMIT;";
                    $result = mysqli_query($link, $sql);
                    if(mysqli_error($link)){
                    echo 'It failed. ' . mysqli_error($link);
                    } else {
                    echo 'It worked!';
                    }
}}}