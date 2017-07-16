<?php
$title = 'Administrative Tools';
require_once '../inc/connect.php';
require_once '../inc/htm.php'; openHead();
if(!$signed_in || $_SESSION['user_rank'] < 3) {
echo '<div class="no-content"><p>You do not have access to this resource.</p></div>';
} else {
$sql = 'SELECT * FROM users WHERE user_pid = ' . mysqli_real_escape_string($link, $_SESSION['user_pid']);
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
include 'user_sidebar.php';
echo '<div class="main-column"><div class="post-list-outline"><h2 class="label">Administrative Tools</h2><ul class="setting-form settings-list">';
if($_SESSION['user_rank'] >= 5) {
echo '<h2 class="label">Developer</h2>
<li><p class="settings-label"><b>cPanel</b><br>Edit the website. You know what this is, right?</p><div class="select-content"><button>goto here</button></div></li>
<li><p class="settings-label"><b>Session Administrator</b><br>Edit other users\' sessions.</p><div class="select-content"><button id="admin-1">goto here</button></div></li>';
}
if($_SESSION['user_rank'] >= 4) {
echo '<h2 class="label">Administrator</h2>
<li><p class="settings-label">Edit Post</p><div class="select-content"><button>goto here</button></div></li>
<li><p class="settings-label">Session Editor</p><div class="select-content"><button>goto here</button></div></li>';
}
if($_SESSION['user_rank'] >= 3) {
echo '<h2 class="label">Moderator</h2>
<li><p class="settings-label">Delete Post</p><div class="select-content"><button>goto here</button></div></li>
<li><p class="settings-label">Create Community</p><div class="select-content"><button>goto here</button></div></li>
<li><p class="settings-label">Edit Community</p><div class="select-content"><button>goto here</button></div></li>
<li><p class="settings-label">Change Password</p><div class="select-content"><button>goto here</button></div></li>';
}
echo '</ul></div>
<script>
$("#admin-1").on("click", function() {
var a = prompt("Steal whose account?");
if(a!=null||a!=""){ go("/session/" + a); }
});
</script></div>';
}
openFoot();