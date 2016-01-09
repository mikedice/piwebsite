<?php

// Set Variables
$LOCAL_ROOT         = "/home/pi/code/website-autosync";
$LOCAL_REPO_NAME    = "piwebsite";
$LOCAL_REPO         = "{$LOCAL_ROOT}/{$LOCAL_REPO_NAME}";
$REMOTE_REPO        = "git@github.com:mikedice/piwebsite.git";
$BRANCH             = "master";
$PAYLOAD_EXPECT     = "a3f3300594093490welkj";

if ( $_POST['payload']) {
    if( file_exists($LOCAL_ROOT) ) {
      // If there is already a repo, just run a git pull to grab the latest changes
      echo(shell_exec("cd /home/pi/code/website-autosync && git pull"));
    }
    else {
        // If the repo does not exist, then clone it into the parent directory
        echo(shell_exec("/usr/bin/git clone https://github.com/mikedice/piwebsite.git /home/pi/code/website-autosync 2>&1"));
    }
} 
?>


