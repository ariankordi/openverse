<?php
$title = 'Profile Settings';
require_once '../inc/connect.php';
$sql = 'SELECT * FROM users WHERE users.user_pid = ' . mysqli_real_escape_string($link, $_SESSION['user_pid']);
$result = mysqli_query($link, $sql);
if(mysqli_error($link)){
echo '<div class="no-content"><p>There was an error while searching for that user.<br>Error: ' . mysqli_error($link) . '</p></div>';
} else {
$row = mysqli_fetch_assoc($result);
        if(mysqli_num_rows($result)==0) {
            http_response_code(404);
            echo '<div class="no-content"><p>That user could not be found.</p></div>';
        }
        else
        {
            if($_SERVER['REQUEST_METHOD']=='GET'){
require_once '../inc/htm.php'; openHead();
include 'user_sidebar.php';
echo '<div class="main-column"><div class="post-list-outline"><h2 class="label">Openverse Settings</h2>
<form class="setting-form" action="/settings/profile" method="post">

<ul class="settings-list">
      <li class="setting-nickname">
        <p class="settings-label">Nickname</p>
        <center><input name="screen_name" maxlength="32" placeholder="Nickname" value="' . htmlspecialchars($row['user_name']) . '"></center>
        <p class="note">The Mii name of your account. Max length of 32 characters.</p>
      </li>
      <li class="setting-profile-comment">
        <p class="settings-label">Profile Comment</p>
        <textarea class="textarea" name="profile_comment" maxlength="1000" placeholder="Write a short description of yourself here.">'.htmlspecialchars($row['user_profile_comment']).'</textarea>
        <p class="note">A short description of yourself. Remember to follow the <a href="/guide/">Openverse Code of Conduct</a>.</p>
      </li>
      <li class="setting-user-id">
        <p class="settings-label">User ID</p>
        <center><input name="user_id" maxlength="255" placeholder="User ID" value="' . htmlspecialchars($row['user_id']) . '"></center>
        <p class="note">You can edit your User ID here. This will break previous profile URLs, and I\'ll be restricting this to certain users once the full version is out.</p>
      </li>
      <li>
        <p class="settings-label"><label for="select_game_skill">How would you describe your experience with games?</label></p>
        <div class="select-content">
          <div class="select-button">
            <select name="game_skill" id="select_game_skill">
              <option value="0">Not Set</option>
              <option value="1"';
if($row['user_skill']==1){
echo ' selected';
}
echo '>Beginner</option>
              <option value="2"';
if($row['user_skill']==2){
echo ' selected';
}
echo '>Intermediate</option>
              <option value="3"';
if($row['user_skill']==3){
echo ' selected';
}
echo '>Expert</option>
            </select>
          </div>
        </div>
      </li>
      <li>
        <p class="settings-label"><label for="select_birthday_visibility">Who should be able to see your age?</label></p>
        <div class="select-content">
          <div class="select-button">
            <select name="birthday_visibility" id="select_birthday_visibility">
              <option value="1">Everyone</option>
              <option value="2"';
if($row['user_birthday_visibility']==2){
echo ' selected';
}
echo '>Friends Only</option>
              <option value="3"';
if($row['user_birthday_visibility']==3){
echo ' selected';
}
echo '>Nobody</option>
           </select>
          </div>
        </div>
      </li>
      <li>
        <p class="settings-label"><label for="select_relationship_visibility">Who should be able to see your friend list, followers, and followed users?</label></p>
        <div class="select-content">
          <div class="select-button">
            <select name="relationship_visibility" id="select_relationship_visibility">
              <option value="1">Everyone</option>
              <option value="2"';
if($row['user_relationship_visibility']==2){
echo ' selected';
}
echo '>Friends Only</option>
              <option value="3"';
if($row['user_relationship_visibility']==3){
echo ' selected';
}
echo '>Nobody</option>
            </select>
          </div>
        </div>
      </li>
      <li class="setting-country">
        <p class="settings-label">Region</p>
        <center><input name="country" maxlength="64" placeholder="Region" value="' . htmlspecialchars($row['user_country']) . '"></center>
        <p class="note">This value will be displayed on your profile.</p>
      </li>
      <li class="setting-website">
        <p class="settings-label">Website</p>
        <center><input name="website" maxlength="255" placeholder="URL" value="' . htmlspecialchars($row['user_website']) . '"></center>
        <p class="note">If you have a website that you want to link to on your profile, type the URL here.</p>
      </li>
      <li class="setting-avatar">
        <p class="settings-label">Avatar</p>
        <center><input name="avatar" maxlength="255" placeholder="Avatar" value="' . htmlspecialchars($row['user_avatar']) . '"></center>
        <p class="note">This should be either a URL link to your avatar or the letters and numbers of a Mii URL (like "3oyie3zp1pdev"). This field will be replaced with a better one in the very near future.</p>
      </li>
<div class="form-buttons"><input type="submit" class="black-button apply-button" value="Save Settings"></div>
</form>
</div></div>';
openFoot();
} else {
$user_id = $_POST['user_id'];
$name = str_replace('‮','',$_POST['screen_name']);
$avatar = $_POST['avatar'];
$profile_comment = $_POST['profile_comment'];
$country = $_POST['country'];
$website = $_POST['website'];
$skill = $_POST['game_skill'];
$systems = $row['user_systems'];
if(!preg_match('/^[A-Za-z0-9-._]{4,32}$/',$user_id)){
http_response_code(400);
exit('{"success":0,"errors":[{"message":"Your User ID is invalid.","error_code":1031101}],"code":400}');
}
$results = mysqli_query($link, "UPDATE users SET
user_id = '".mysqli_real_escape_string($link,$user_id)."',
user_name = '".mysqli_real_escape_string($link,$name)."',
user_avatar = '".mysqli_real_escape_string($link,$avatar)."',
user_profile_comment = '".mysqli_real_escape_string($link,$profile_comment)."',
user_country = '".mysqli_real_escape_string($link,$country)."',
user_website = '".mysqli_real_escape_string($link,$website)."',
user_skill = '".mysqli_real_escape_string($link,$skill)."',
user_systems = '".mysqli_real_escape_string($link,$systems)."'
WHERE user_id = '".mysqli_real_escape_string($link,$_SESSION['user_id'])."'");
if(mysqli_error($link)){
http_response_code(400);
echo '<div class="no-content"><p>There was an error handling that request.</p></div>';
} else {
$_SESSION['user_id'] = $_POST['user_id'];
$_SESSION['user_name'] = $_POST['screen_name'];
$_SESSION['user_avatar'] = $_POST['avatar'];
echo '<script>window.location.replace("/settings/profile");</script>';
}}}}