<?php
if(!(include_once 'settings.php') || !isset($open_db_host)) {
require_once __DIR__ . '/htm.php';
error_log('Either settings.php could not be loaded or the datbase variables are not defined in it.');
openServerErr(503, 'The Openverse server is not configured correctly.');
}

/*
if(!empty($_SESSION['debug'])) {
// Look at tests.php
error_reporting(E_ALL);
ini_set('display_errors', true);
} else {
error_reporting(0);
ini_set('display_errors', false);
}*/


$link = mysqli_connect($open_db_host, $open_db_user, $open_db_pass);

if(!$link || !mysqli_select_db($link, $open_db_name)) {
	require_once __DIR__ . '/htm.php';
	openServerErr(503, 'The database servers appear to be down at the moment, try coming back later.');
}
mysqli_set_charset($link, 'utf8mb4');

session_name('openverse');
/* Nah, fam.
session_set_cookie_params(2592000,'/','openverse-dev.pf2m.com',false,true);*/
if(session_status() == PHP_SESSION_NONE) {
session_start();
}
// It's time for autoauth!
/** If there is no session (i.e, expired) and if the cookie 'openverse-auth' exists, then check if the token in openverse-auth exists.
* If it exists, look for it in the database, and if all of that is good and dandy, then log them in!
*/
if(!isset($_SESSION['user_pid']) && isset($_COOKIE['openverse-auth'])) {
// Look for token. Can't be older than the date defined in settings.php.
if(!isset($settings['max_token_life'])) { $max_token_life = 5; } 
else { $max_token_life = $settings['max_token_life']; }
// Delete old tokens and then look for new ones.
mysqli_query($link, 'DELETE FROM login_tokens WHERE login_tokens.token_created < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL '.($max_token_life).' DAY))');
$search_token = mysqli_query($link, 'SELECT token_for FROM login_tokens WHERE login_tokens.token_id = "'.mysqli_real_escape_string($link, $_COOKIE['openverse-auth']).'" LIMIT 1');
// If we found things..
if($search_token && mysqli_num_rows($search_token) != 0) {
// .. then look for their user_pid and log them the fuck in! We can't get blank stuff since token_for is cascading on user_pid.
$search_user = mysqli_fetch_assoc(mysqli_query($link, 'SELECT user_id, user_pid, user_name, user_rank, user_avatar FROM users WHERE users.user_pid = "'.mysqli_fetch_assoc($search_token)['token_for'].'"'));
$_SESSION['signed_in'] = true;
$_SESSION['user_id'] = $search_user['user_id'];
$_SESSION['user_pid'] = $search_user['user_pid'];
$_SESSION['user_name'] = $search_user['user_name'];
$_SESSION['user_rank'] = $search_user['user_rank'];
$_SESSION['user_avatar'] = $search_user['user_avatar'];
$_SESSION['user_timezone'] = 'America/New_York';
    }
}
// End of autoauth.

// Wrappers for prepared statements.
// Example: prepared('SELECT * FROM posts WHERE posts.post_id = ? AND posts.post_by = ?', array(12, 1));
function prepared($txt, $values = null) {
global $link;
$stmt = $link->prepare($txt);
if($values !== null) {
	$params = '';
		foreach($values as &$param) {
		$params .= is_int($param) ? 'i' : 's';
		}
	$funcparam = array_merge(array($params), $values);
	foreach($funcparam as $key => $value)
	$tmp[$key] = &$funcparam[$key];
	call_user_func_array([$stmt, 'bind_param'], $tmp);
	}
$stmt->execute();
	if(!$stmt || $stmt->errno) {
	return false;
	} else {
	return $stmt->get_result();	
	}
}
/* Example: nice_ins('posts', 
['post_content' => "I would fuck the shit out of an inkling.\n\n-Probably 2015/2016 PF2M"]);
*/
function nice_ins($table, $values) {
global $link;
$stmt = $link->prepare('INSERT INTO '.$table.'('.(implode(', ', array_keys($values))).')
VALUES('.rtrim(str_repeat('?, ', count($values)), ', ').')');
	$params = '';
		foreach($values as &$param) {
		$params .= is_int($param) ? 'i' : 's';
        }
	$funcparam = array_merge(array($params), array_values($values));
	foreach($funcparam as $key => $value) $tmp[$key] = &$funcparam[$key];
	call_user_func_array([$stmt, 'bind_param'], $tmp);
$stmt->execute();
	if(!$stmt || $stmt->errno) {
	return false;
	} else {
	return true;	
	}
}


$classes = [];
$signed_in = (isset($_SESSION['signed_in']) && $_SESSION['signed_in']==true);

/* User variable, set as $user. Null if not logged in. */
if($signed_in) {
$user = mysqli_fetch_assoc(prepared('SELECT * FROM users WHERE users.user_pid = ? LIMIT 1', array($_SESSION['user_pid'])));
} else {
$user = null;
}

date_default_timezone_set('America/New_York');
mysqli_query($link, 'SET time_zone = "-4:00"');
function displayTime($datetime){
$timeSincePost = time() - strtotime($datetime);
if($timeSincePost < 60){
return 'Less than a minute ago';
} elseif($timeSincePost < 120) {
return '1 minute ago';
} elseif($timeSincePost < 3600) {
return strtok($timeSincePost/60, '.') . ' minutes ago';
} elseif($timeSincePost < 7200) {
return '1 hour ago';
} elseif($timeSincePost < 86400) {
return strtok($timeSincePost/3600, '.') . ' hours ago';
} elseif($timeSincePost < 172800) {
return '1 day ago';
} elseif($timeSincePost < 604800) {
return strtok($timeSincePost/86400, '.') . ' days ago';
} else {
return date("m/d/Y g:i A",strtotime($datetime));
}
}

/** Let's put a function here to insert and generate a token, which will be used in login.php.
* That way, if there's something terminally wrong, we just go to this file and either break this or fix it.
*/
function tokenGen($user) {
global $link;
// $user will be a user_pid.
// This is pseudo-random and generates a 32-character string that is very random. Good enough.
$random_thing = substr(preg_replace("/[\/=+]/","",base64_encode(openssl_random_pseudo_bytes(32))),0,32);
// Let's insert it.
$insert = mysqli_query($link, 'INSERT INTO login_tokens (token_id, token_for) VALUES("'.$random_thing.'", "'.mysqli_real_escape_string($link, $user).'")');
// That's it, but now we've got to put it into a cookie.

if(!isset($settings['max_token_life'])) { $max_token_life = 5; } 
else { $max_token_life = $settings['max_token_life']; }

setcookie('openverse-auth', $random_thing, (time() + strtotime($max_token_life . ' days')), '/');
// Done! If we log out, we've got to remove it in logout.php which is what I'll do next.
    }
    
$has_pjax = isset($_SERVER['HTTP_X_PJAX']);

/*
function err_handle($ex) {
  http_response_code(500);
  header('Content-type: text/plain');
  if($_SESSION['user_rank']==5) {
  echo "Message:\n" . $ex->getMessage() . "\nTrace: ";
  var_dump($ex->getTrace());
  } else {
  echo "Oops, there was a server error. Try again later." . ($ex->getCode() ? "\nError code " . $ex->getCode() : "");
  }
}
set_exception_handler('err_handle');
*/