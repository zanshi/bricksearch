<?php

include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET["searchterm"])) {
        $searchterm = validate($_GET["searchterm"]);
        printTitle($searchterm);
    } else {
        printTitle(null);
    }
}
