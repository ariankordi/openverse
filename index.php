<?php
require '/home/pfmcom/altorouter.php';
$router = new AltoRouter();

$location = '/home/pfmcom/public_html/openverse-dev/openverse-php/';

$router->addMatchTypes(array('cId' => '[a-zA-Z]{2}[0-9](?:_[0-9]++)?'));

$router->addRoutes(array(
// Pages that require no params
  array('GET', '/', 'community-list.php', 'Communities-view1'),
  array('GET', '/communities', 'community-list.php', 'Communities-view2'),
  array('GET|POST', '/account/login', 'login.php', 'Account-login'),
  array('POST', '/account/logout', 'logout.php', 'Account-logout'),
  array('GET|POST', '/account/forgot', 'forgot_password.php', 'Account-forgot-passwd'),
  array('GET', '/identified_user_posts', 'identified_user_posts.php', 'Identified-user-posts'),
  array('GET', '/check_update.json', 'check_update.php', 'Check-notifications'),
  array('GET', '/activity', 'activity.php', 'Activity-feed'),
  array('GET', '/news/my_news', 'notifications.php', 'Notifications'),
  array('GET', '/communities/favorites', 'favorites.php', 'Communities-favorites'),
  array('GET', '/titles/search', 'title_search.php', 'Title-search'),
  
  // Pages that indeed require params
  array('GET', '/users/@me', 'me.php', 'User-me'),
  array('GET', '/users', 'user_search.php', 'User-search'),
  array('GET', '/users/[*:id]', 'user_profile.php', 'User-profile'),
  array('GET', '/users/[*:id]/posts', 'user_posts.php', 'User-posts'),
  array('GET', '/users/[*:id]/empathies', 'user_empathies.php', 'User-empathies'),
  array('GET', '/users/[*:id]/following', 'user_following.php', 'User-following'),
  array('GET', '/users/[*:id]/favorites', 'user_favorites.php', 'User-favorites'),
  array('GET', '/users/[*:id]/check_can_post.json', 'user_favorites.php', 'Check-can-post'),
  array('POST', '/users/[*:id]/follow', 'follow.php', 'User-follow'),
  array('POST', '/users/[*:id]/unfollow', 'unfollow.php', 'User-unfollow'),
  array('GET', '/titles/[i:id]', 'titles.php', 'Title-view'),
  array('GET', '/titles/[i]/[i:id]', 'communities.php', 'Community-view'),
));

$match = $router->match();
if($match) {
// bind all variables to $_GET
foreach($match['params'] as &$param) {
$_GET['id'] = $param;
}
// and then require the target file
$target = $location . $match['target'];
if(pathinfo($target) != 'php') {
	require $target;
	} else {
	header('Content-Type: ' . mime_content_type($target));
	echo file_get_contents($target);
	}
} else {
// 404
http_response_code(404);
header('Content-Type: text/plain');
echo 'not found';
}
