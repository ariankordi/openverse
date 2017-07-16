<?php
$title = 'Main Page';
$selected = 'communities';
$admins = array('pf2m', 'arian');
require_once '../inc/connect.php';
	if($signed_in) {
	$classes[] = 'guest-top';
	} else {
	$classes[] = 'community-top';
	}
require_once '../inc/htm.php'; openHead();
require_once '../inc/libqueries.php';

echo '<div class="body-content" id="community-top">
<div id="header-news" class="news-label info-content info-ticker">
    <a href="#" class="close-button"></a>
    <a href="/titles/8/10" class="header-news-button">There is a new Openverse announcement. Click here for more details.</a>
  </div><br>

<div class="community-main"><div id="community-eyecatch"><div id="community-eyecatch-main">
';
if(isset($settings['featured_communities'])) {
$eyecatch_posts = communityGetEyecatchPosts();
	// If it didn't return a true value, don't do anything because it failed.
	if($eyecatch_posts) {
	$i = 0;
	foreach($eyecatch_posts as &$row) {
	$i++;
		echo '<div class="eyecatch-diary-post js-eyecatch-diary-post' . ($i > 1 ? ' invisible' : '')
		. '" data-index="' . $i . '"><a href="/posts/' . htmlspecialchars($row['post_id']) . '" class="community-eyecatch-image" style="background-image: url(&quot;';
		if($_COOKIE['proxy']=='1'){
		echo 'https://pf2m.000webhostapp.com/mini.php?';
		}
		echo htmlspecialchars($row['post_screenshot']) . '&quot;)"><span class="icon-container';
		if($row['user_rank'] == 1) {
		echo ' donator';
		}
		if($row['user_rank'] == 2) {
		echo ' tester';
		}
		if($row['user_rank'] == 3) {
		echo ' moderator';
		}
		if($row['user_rank'] == 4) {
		echo ' administrator';
		}
		if($row['user_rank'] == 5) {
		echo ' developer';
		}
		echo '"><img src="';
		$avatar = $row['user_avatar'];
		$feeling_id = $row['post_feeling_id'];
		include 'openverse-php/avatar.php';
		echo $avatar . '" class="icon community-eyecatch-usericon"></span><p class="community-eyecatch-balloon"><span>' . htmlspecialchars($row['post_content']) . '</span></p></a><a href="/titles/' . htmlspecialchars($row['community_title']) . '/' . htmlspecialchars($row['community_id']) . '" class="community-eyecatch-info"><img src="' . htmlspecialchars($row['community_icon']) . '" width="40" height="40" class="community-eyecatch-infoicon"><h4 class="community-game-title" data-index="1"> ' . htmlspecialchars($row['community_name']) . '</h4><p class="community-game-device">';
		if($row['title_platform']<3) {
		echo '<span class="platform-tag"><img src="/assets/img/platform-tag-'; 
		if($row['title_platform']==0) {
		echo '3ds';
		} elseif($row['title_platform']==1){
		echo 'wiiu';
		} elseif($row['title_platform']==2){
		echo 'wiiu-3ds';
		}
		echo '.png"></span>';
		}
		echo '<span class="text">';
		if($row['title_type']==0){
		if($row['title_platform']==0){
		echo '3DS Games';
		} elseif($row['title_platform']==1){
		echo 'Wii U Games';
		} elseif($row['title_platform']==2){
		echo 'Wii U Games・3DS Games';
		} else {
		echo 'General Community';
		}
		} elseif($row['title_type']==2){
		echo 'Special Community';
		} else {
		echo 'General Community';
		}
		echo '</span></p></a></div>';
		}
	}
}

echo '</div></div></div>';

echo '<div class="community-top-sidebar"><form class="search" action="/titles/search"><input type="text" name="query" placeholder="Search Communities" minlength="2" maxlength="32"><input type="submit" value="q" title="Search"></form><div id="identified-user-banner"><a href="/identified_user_posts" class="list-button ' . $admins[mt_rand(0,1)] . '-icon"><span class="title">Get the latest news here!</span><span class="text">Posts from Verified Users</span></a></div><br><div class="post-list-outline" style="text-align: center"><h2 class="label">Welcome to Openverse!</h2><p style="width: 90%; display: inline-block; padding-top: 10px; padding-bottom: 10px;">This is a closed beta prerelease of a social network made by PF2M that will allow you to create posts and comments about various topics with other users, with no posting limits or strict admins to worry about. This version of the website is currently closed to the public for testing purposes; if you need me for anything, email me at <a href=\'m&#97;i&#108;t&#111;&#58;nicon&#105;c%6Fni&#105;&#64;pf2&#37;6D&#46;c&#111;&#109;\'>ni&#99;&#111;&#110;i&#99;&#111;&#110;&#105;&#105;&#64;pf2m&#46;com</a> and I\'ll get back to you eventually. The full version will be coming out at <a href="https://openverse.pf2m.com/">openverse.pf2m.com</a> in like a month, updates will be posted to <a href="/titles/3/4">the Openverse Changelog</a> and publically in <a href="https://plus.google.com/communities/110494064646658861137">the Openverse Google+ Community</a>. Make sure you don\'t miss the full version when it comes out!</p></div></div>';
echo '<div class="community-main">';

if($signed_in){
echo '<h3 class="community-title community-favorite-title symbol">Favorite Communities</h3>';
$cresult = mysqli_query($link, 'SELECT * FROM favorites LEFT JOIN communities ON community_id = favorite_to WHERE favorite_by = ' . mysqli_real_escape_string($link, $_SESSION['user_pid']) . ' ORDER BY favorite_id DESC LIMIT 0,8');
$rows = mysqli_num_rows($cresult);
if($rows>0){
echo '<div class="card" id="community-favorite"><ul>';
while($crow = mysqli_fetch_assoc($cresult)){
echo '<li><a class="icon-container" href="/titles/' . htmlspecialchars($crow['community_title']) . '/' . htmlspecialchars($crow['community_id']) . '"><img class="icon" src="' . htmlspecialchars($crow['community_icon']) . '"></a></li>';
}
for($x=$rows; $x<8; $x++){
echo '<li><span class="empty-icon"><img src="/assets/img/empty.png"></span></li>';
}
echo '<li class="read-more"><a href="/communities/favorites" class="favorite-community-link symbol"><span class="symbol-label">Show More</span></a></li></ul></div>';
} else {
echo '<div class="no-content no-content-favorites" id="community-favorite"><p>Tap the ☆ button on a community\'s page to have it show up as a favorite community here.</p><a class="favorite-community-link symbol" href="/communities/favorites"><span class="symbol-label">Show More</span></a></div>';
}}
if(isset($settings['featured_communities'])) {
echo '<h3 class="community-title">Featured Communities</h3><ul class="list community-list community-card-list">';
foreach ($settings['featured_communities'] as $id) {
$sql = "SELECT * FROM communities LEFT JOIN titles ON title_id = community_title WHERE community_id = " . mysqli_real_escape_string($link, $id);
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
echo '<li class="trigger" data-href="/titles/' . htmlspecialchars($row['community_title']) . '/' . htmlspecialchars($row['community_id']) . '"><img src="' . $row['community_banner'] . '" class="community-list-cover"><div class="community-list-body"><span class="icon-container"><img class="icon" src="' . htmlspecialchars($row['community_icon']) . '"></span><div class="body"><a class="title" href="/titles/' . htmlspecialchars($row['title_id']) . '/' . htmlspecialchars($row['community_id']) . '">' . htmlspecialchars($row['community_name']) . '</a>';
if($row['title_platform']<3) {
echo '<span class="platform-tag"><img src="/assets/img/platform-tag-'; 
if($row['title_platform']==0) {
echo '3ds';
} elseif($row['title_platform']==1){
echo 'wiiu';
} elseif($row['title_platform']==2){
echo 'wiiu-3ds';
}
echo '.png"></span>';
}
echo '<span class="text">';
if($row['title_type']==0){
if($row['title_platform']==0){
echo '3DS Games';
} elseif($row['title_platform']==1){
echo 'Wii U Games';
} elseif($row['title_platform']==2){
echo 'Wii U Games・3DS Games';
} else {
echo 'General Community';
}
} elseif($row['title_type']==2){
echo 'Special Community';
} else {
echo 'General Community';
}
echo '</span></div></div></li>';
}

echo '</ul>';
}

echo '<h3 class="community-title">General Communities</h3><ul class="list community-list community-card-list device-new-community-list">';
$sql = "SELECT * FROM titles LEFT JOIN communities ON community_title = title_id WHERE title_type = 1 GROUP BY title_id ORDER BY title_id DESC, community_type LIMIT 0,7";
$result = mysqli_query($link, $sql);
if(mysqli_error($link)) {
echo '<div class="post-list-outline"><div class="no-content"><p>The database server is giving errors right now, try again in a moment.</p></div></div>';
} else {
if(mysqli_num_rows($result) == 0) {
echo '<div class="post-list-outline"><div class="no-content"><p>No communities of this type have been created yet.</p></div></div>';
} else {
while($row = mysqli_fetch_assoc($result)) {
echo '<li class="trigger" data-href="/titles/' . htmlspecialchars($row['title_id']) . '/' . htmlspecialchars($row['community_id']) . '"><div class="community-list-body"><span class="icon-container"><img class="icon" src="' . htmlspecialchars($row['title_icon']) . '"></span><div class="body"><a class="title" href="/titles/' . htmlspecialchars($row['title_id']) . '/' . htmlspecialchars($row['community_id']) . '">' . htmlspecialchars($row['title_name']) . '</a>';
if($row['title_platform']<3) {
echo '<span class="platform-tag"><img src="/assets/img/platform-tag-'; 
if($row['title_platform']==0) {
echo '3ds';
} elseif($row['title_platform']==1){
echo 'wiiu';
} elseif($row['title_platform']==2){
echo 'wiiu-3ds';
}
echo '.png"></span>';
}
echo '<span class="text">';
if($row['title_type']==0){
if($row['title_platform']==0){
echo '3DS Games';
} elseif($row['title_platform']==1){
echo 'Wii U Games';
} elseif($row['title_platform']==2){
echo 'Wii U Games・3DS Games';
} else {
echo 'General Community';
}
} elseif($row['title_type']==2){
echo 'Special Community';
} else {
echo 'General Community';
}
echo '</span></div></div></li>';
}}}
echo '</ul>';

echo '<h3 class="community-title">Game Communities</h3><ul class="list community-list community-card-list device-new-community-list">';
$sql = "SELECT * FROM titles LEFT JOIN communities ON community_title = title_id WHERE title_type = 0 GROUP BY title_id ORDER BY title_id DESC, community_type LIMIT 0,7";
$result = mysqli_query($link, $sql);
if(mysqli_error($link)) {
echo '<div class="post-list-outline"><div class="no-content"><p>The database server seems to be down at the moment, try again in a moment.</p></div></div>';
} else {
if(mysqli_num_rows($result) == 0) {
echo '<div class="post-list-outline"><div class="no-content"><p>No communities of this type have been created yet.</p></div></div>';
} else {
while($row = mysqli_fetch_assoc($result)) {
echo '<li class="trigger" data-href="/titles/' . htmlspecialchars($row['title_id']) . '/' . htmlspecialchars($row['community_id']) . '"><div class="community-list-body"><span class="icon-container"><img class="icon" src="' . htmlspecialchars($row['title_icon']) . '"></span><div class="body"><a class="title" href="/titles/' . htmlspecialchars($row['title_id']) . '/' . htmlspecialchars($row['community_id']) . '">' . htmlspecialchars($row['title_name']) . '</a>';
if($row['title_platform']<3) {
echo '<span class="platform-tag"><img src="/assets/img/platform-tag-'; 
if($row['title_platform']==0) {
echo '3ds';
} elseif($row['title_platform']==1){
echo 'wiiu';
} elseif($row['title_platform']==2){
echo 'wiiu-3ds';
}
echo '.png"></span>';
}
echo '<span class="text">';
if($row['title_type']==0){
if($row['title_platform']==0){
echo '3DS Games';
} elseif($row['title_platform']==1){
echo 'Wii U Games';
} elseif($row['title_platform']==2){
echo 'Wii U Games・3DS Games';
} else {
echo 'General Community';
}
} elseif($row['title_type']==2){
echo 'Special Community';
} else {
echo 'General Community';
}
echo '</span></div></div></li>';
}}}
echo '</ul>';

echo '<h3 class="community-title">Special Communities</h3><ul class="list community-list community-card-list device-new-community-list">';
$sql = "SELECT * FROM titles LEFT JOIN communities ON community_title = title_id WHERE title_type = 2 GROUP BY title_id ORDER BY title_id DESC, community_type LIMIT 0,7";
$result = mysqli_query($link, $sql);
if(mysqli_error($link)) {
echo '<div class="post-list-outline"><div class="no-content"><p>The database server seems to be down at the moment, try again in a moment.</p></div></div>';
} else {
if(mysqli_num_rows($result) == 0) {
echo '<div class="post-list-outline"><div class="no-content"><p>No communities of this type have been created yet.</p></div></div>';
} else {
while($row = mysqli_fetch_assoc($result)) {
echo '<li class="trigger" data-href="/titles/' . htmlspecialchars($row['title_id']) . '/' . htmlspecialchars($row['community_id']) . '"><div class="community-list-body"><span class="icon-container"><img class="icon" src="' . htmlspecialchars($row['title_icon']) . '"></span><div class="body"><a class="title" href="/titles/' . htmlspecialchars($row['title_id']) . '/' . htmlspecialchars($row['community_id']) . '">' . htmlspecialchars($row['title_name']) . '</a>';
if($row['title_platform']<3) {
echo '<span class="platform-tag"><img src="/assets/img/platform-tag-'; 
if($row['title_platform']==0) {
echo '3ds';
} elseif($row['title_platform']==1){
echo 'wiiu';
} elseif($row['title_platform']==2){
echo 'wiiu-3ds';
}
echo '.png"></span>';
}
echo '<span class="text">';
if($row['title_type']==0){
if($row['title_platform']==0){
echo '3DS Games';
} elseif($row['title_platform']==1){
echo 'Wii U Games';
} elseif($row['title_platform']==2){
echo 'Wii U Games・3DS Games';
} else {
echo 'General Community';
}
} elseif($row['title_type']==2){
echo 'Special Community';
} else {
echo 'General Community';
}
echo '</span></div></div></li>';
}}}
echo '</ul>';

echo '</div><div id="community-guide-footer"><div id="guide-menu"><a href="/guide/" class="arrow-button"><span>Openverse Code of Conduct</span></a><a href="/guide/faq" class="arrow-button"><span>Frequently Asked Questions (FAQ)</span></a><a href="/guide/legal" class="arrow-button"><span>Legal Information</span></a><a href="https://www.pf2m.com/openverse/" class="arrow-button"><span>About Openverse</span></a></div></div></div>';

openFoot();