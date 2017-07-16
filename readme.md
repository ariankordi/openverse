# Openverse source release
This is Openverse's source. PF2M never made it with open-sourcing in mind and he definitely did not 100% intend for anyone but himself to understand the code, he also made this completely based on a beginner's PHP forum guide.
# Made by PF2M!
PF2M made this, and I helped a little. I'd say he made 99% and I made 20%, if you get that jok e.
Lots of things were inspired by various people, like I inspired him to use Imgur, but that doesn't really matter.
# Usage
* Make a new MySQL user (actually optional), and then a new MySQL database.
* Run db.sql on the database.
* Copy /inc/settings-sample.php to /inc/settings.php, and then fill out the info it wants.
* Make sure openverse is the server root. Either include nginx-rewrite.conf in nginx (while using php-fpm) or use the htaccess (**I haven't tested it, I don't use Apache**)
* I don't really know how it's mananged in general, but you should be able to just use phpMyAdmin to manage stuff. If there is something wrong such as the emailing being broken (which it is), you can probably fix it.

# Notes
There are tons of things meant for only PF2M's Openverse here, such as reCAPTCHA and Imgur keys. I've tried to cut them out, but it may not have worked.

Also, I have tried to make this good at the end, but just gave up.
The things I have done was made this to make fast page transitions, progress bars, drawing, and lots of other things.

You're probably going to have to look through the source to administrate this.

# This came from the Openverse that ran on my server
It might not work on yours.
This may only work for PHP 7, or not. I was using PHP 7.2.

Don't run this on a public server, please.

Some elements in this definetely belong to Nintendo or Hatena Co, Ltd.

# Where's my grape? This isn't what I asked for :(
This is actually my response to PF2M leaking a very old version of my grape. I don't think it's time to release it yet, however once I can know that various script kiddies won't touch it, I'll release the latest version. It's a bit of the same concept, as in PHP files that are spawned and require some files, but it is a lot better written. The one PF2M has is before I rewrote it.
However, I may just rewrite it again, but in a language that's not PHP, since I'm way past knowing just PHP now.