<?php
// Openverse settings
// This is supposed to be at inc/settings.php

// MySQL
$open_db_host = /* DB host */;
$open_db_user = /* DB user */;
$open_db_pass = /* DB pass */;
$open_db_name = 'open';

// reCAPTCHA, leave the secret as null for none.
$open_recaptcha_secret = null;
$open_recaptcha_public = null;
// Imgur?
$open_imgur_clientid = null;

// Misc
$settings["logins_allowed"] = true;
$settings["signups_allowed"] = false;
$settings["featured_communities"] = null;
