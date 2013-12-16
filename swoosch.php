<?php

// Init vars
$LOCAL_ROOT         = "/srv/http/projekt";
$LOCAL_REPO_NAME    = "bricksearch";
$LOCAL_REPO         = "{$LOCAL_ROOT}/{$LOCAL_REPO_NAME}";
$REMOTE_REPO        = "git@github.com:jonathanstark/my_new_site.git";


// Clone fresh repo from github using desired local repo name and checkout the desired branch
echo getcwd();
echo shell_exec("cd /srv/http/projekt/bricksearch && git pull");
