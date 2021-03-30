<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

// Login time, when user don't doing any actions. This option must be specified in seconds.
$config['login_time'] = 900;
// Checking users on every page load, if you want you can track with cronjob. If you tracking with cronjob you need to run checkOnlineList function in your controller without login, and point your cronjob to your controller method, where you ran this method: true or false
$config['check_users_on_page_load'] = false;
// Enabling track max online function: true or false
$config['track_max_online'] = true;
