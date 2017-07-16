<?php
$title = 'Main Page';
$selected = 'communities';
require_once '../inc/connect.php';
require_once '../inc/htm.php'; openHead();
echo '<div class="guest"><div id="about"><div id="about-inner"><div id="about-text"><h2 class="welcome-message">Welcome to Openverse!</h2><p>Openverse is a social network written by PF2M that allows you to chat about various games and topics with other users! There\'s no over-protective admins or post limits here, so feel free to have fun.</p><div class="guest-terms-content"><a class="symbol guest-terms-link" href="/guide/">this isnt finished btw</a></div></div><img src="https://d13ph7xrk1ee39.cloudfront.net/img/welcome-image.png"></div></div></div><h3 class="community-title">All Communities</h3><ul class="list community-list community-card-list device-new-community-list">';
$sql = "SELECT * FROM communities ORDER BY communities.community_id DESC";
$result = mysqli_query($link, $sql);
if(!$result)
{
    echo 'The server seems to be messing up at the moment, try again later. :/';
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'No communities have been made yet.';
    }
    else
    {
        while($row = mysqli_fetch_assoc($result))
        {
            echo '<li class="trigger" data-href="/titles/1/' . htmlspecialchars($row['community_id']) . '"><div class="community-list-body"><span class="icon-container"><img class="icon" src="' . htmlspecialchars($row['community_icon']) . '"></span><div class="body"><a class="title" href="/titles/1/' . htmlspecialchars($row['community_id']) . '">' . htmlspecialchars($row['community_name']) . '</a>';
if($row['community_platform']) {
echo '<span class="platform-tag"><img src="/assets/img/platform-tag-'; 
if($row['community_platform']==1) {
echo 'wiiu';
} elseif($row['community_platform']==2){
echo '3ds';
} elseif($row['community_platform']==3){
echo 'wiiu-3ds';
}
echo '.png"></span>';
}
echo '<span class="text">' . htmlspecialchars($row['community_genre']) . '</span></div></div></li>';
        }
    }
}
echo '</ul>';
openFoot();