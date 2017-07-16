<?php
$title = 'Create Community';
require_once '../../inc/connect.php';
require_once '../../inc/htm.php'; openHead();

if($signed_in){
if($_SESSION['user_rank']>2){
if($_SERVER['REQUEST_METHOD'] != 'POST') {
    //the form hasn't been posted yet, display it
    echo "<center><form method='post' action=''><br>
        Community title: <input type='text' name='title' /><br>
        Community description: <textarea name='description' /></textarea><br>
        Community banner URL: <input type='text' name='banner' /><br>
        Community icon URL: <input type='text' name='icon' /><br>
        Community type: <select name='type'><option value='Wii U Games'>Wii U Games</option><option value='3DS Games'>3DS Games</option><option value='Wii U Games・3DS Games'>Wii U/3DS Games</option><option value='Virtual Console'>Virtual Console</option><option value='General Community'>General Community</option><option value='Special Community'>Special Community</option></select><br>
        Community platform: <select name='platform'><option value='wiiu'>Wii U</option><option value='3ds'>3DS</option><option value='wiiu-3ds'>Wii U/3DS</option><option>N/A</option></select><br>
        <input type='submit' value='Create Community' />
     </form></center>";
} else {
    //the form has been posted, so save it
    $sql = "INSERT INTO communities(community_title,community_description,community_banner,community_icon, community_type,community_platform) VALUES('" . mysqli_real_escape_string($link,$_POST['title']) . "','" . mysqli_real_escape_string($link,$_POST['description']) . "','" . mysqli_real_escape_string($link,$_POST['banner']) . "','" . mysqli_real_escape_string($link,$_POST['icon']) . "','" . mysqli_real_escape_string($link,$_POST['type']) . "','" .
mysqli_real_escape_string($link,$_POST['platform']) . "')";
    $result = mysqli_query($link, $sql);
    if(!$result)
    {
        //something went wrong, display the error
        echo 'Error: ' . mysqli_errno($link);
    }
    else
    {
        echo 'New community successfully added.';
    }
} else {
http_response_code(403);
echo '<div class="no-content"><p>You\'re not authorized to view this page.</p></div>';
}
} else {
http_response_code(401);
echo '<div class="no-content"><p>You must be signed in to access this page.</p></div>';
}
openFoot();
?>
}
openFoot();