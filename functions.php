<?php

/**
 * Connect to the specified MySQL database
 * @return MySQL database connection
 */
function connect()
{

    // Initialize MySQLi php module
    $con = mysqli_init();

    // If MySQLi initialization failed then print error and return null
    if (!$con) {
        printError("Database error.");

        return null;
    }

    // Check if a connection can be made, if not, print error and return null
    if (!(mysqli_real_connect($con, "koneko.se", "projekt", "tnmk30", "lego"))) {
        printError("Couldn't connect to database.");

        return null;
        //die('Could not connect: ' . mysqli_connect_error());
    }

    return $con;
}

/**
 * Validate search string for security reasons
 * @param  string $data Search string
 * @return string
 */
function validate($data)
{
    if (ctype_space($data) || empty($data) || $data === null) {
        return false;
    } else {
        return true;
    }
}

function validateStart($start)
{
    if (ctype_digit($start)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Clean user input from strange stuff
 * @param  string $data User input
 * @return string $data Return string
 */
function cleanInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

/**
 * Print website title
 * @param  string $title
 * @return void
 */
function printTitle($title)
{
    echo "<title>";
    if ($title) {
        echo $title . " - ";
    }
    echo "Brick Search" . "</title>";

}

/**
 * Main search function.
 * Performs an SQL query and prints the results using other functions
 * @param  MySQL database connection $con
 * @param  string $str Search string
 * @param  int $start Specifies the first result to be shown
 * @return void
 */
function mainSearch($con, $str, $start)
{

    $str = mysqli_real_escape_string($con, $str);

    $sql
        = "SELECT sets.SetID, sets.Setname
        FROM sets
        WHERE SetID LIKE '%$str%'
        OR Setname LIKE '%$str%'
        LIMIT $start , 20"
    ;

    //$calcTime = microtime(true);

    $result = mysqli_query($con, $sql);

    $searchUrl = "index.php?searchterm=" . $str;

    //$calcTime = microtime(true) - $calcTime;

    $nrOfResults = countResults($con, 2, "", "", "", $str);

    if ($nrOfResults != 0) {

        //echo "<div id='resultStats'>" . $nrOfResults . " results. (" . $calcTime . " seconds) </div>";

        while ($row = mysqli_fetch_assoc($result)) {
            mainSearchHtml($con, $row, 2);
        }

        if ($nrOfResults > 20) {
            multiPage($searchUrl, $nrOfResults, $start);
        }

        mysqli_free_result($result);

    } else {
        noResult($str, $opt);
    }

}
/**
 * Function for main and advanced search
 * Performs an SQL query and prints the results using other functions
 * @param  MySQL database connection $con
 * @param  int $start Specifies the first result to be shown
 * @param  int $opt determines which search function that should be used 
 * @param  string $cid colorID/categoryID search string
 * @param  string $cname color/category search string
 * @param  string $id SetID/PartID search string
 * @param  string $name Setname/Partname searchstring
 * @return void
 */
function advSearch($con, $start, $opt, $cid, $cname, $id, $name)
{

    if ($opt == 2) {
        $str = mysqli_real_escape_string($con, $name);
        $sql
            = "SELECT sets.SetID, sets.Setname
            FROM sets
            WHERE SetID LIKE '%$name%'
            OR Setname LIKE '%$name%'
            LIMIT $start , 20";

            $searchUrl = "index.php?searchterm=" . $name;
    } elseif ($opt == 0) {
        $sql
            = "SELECT sets.SetID, sets.Setname
                FROM sets, categories
                WHERE sets.catID = categories.catid
                AND sets.catID LIKE '%$cid%'
                AND categories.categoryname LIKE '%$cname%'
                AND sets.SetID LIKE '%$id%'
                AND sets.Setname LIKE '%$name%'
                LIMIT $start , 20";
                $searchUrl = "advanced.php?cid=" . $cid . "&cname=" . $cname . "&id=" . $id . "&name=" . $name;
    } elseif ($opt == 1) {
        $sql
            = "SELECT parts.PartID, parts.Partname
                FROM parts, inventory, colors
                WHERE inventory.ItemID = parts.PartID
                AND inventory.ColorID = colors.ColorID
                AND inventory.ColorID LIKE '%$cid%'
                AND colors.Colorname LIKE '%$cname%'
                AND parts.PartID LIKE '%$id%'
                AND parts.Partname LIKE '%$name%'
                LIMIT $start , 20";
                $searchUrl = "advanced.php?cid=" . $cid . "&cname=" . $cname . "&id=" . $id . "&name=" . $name;
    }

    $result = mysqli_query($con, $sql);

    $nrOfResults = countResults($con, $opt, $cid, $cname, $id, $name);

    

    if ($nrOfResults != 0) {

        //echo "<div id='resultStats'>" . $nrOfResults . " results. (" . $calcTime . " seconds) </div>";

        while ($row = mysqli_fetch_assoc($result)) {
            mainSearchHtml($con, $row, $opt);
        }

        if ($nrOfResults > 20) {
            multiPage($searchUrl, $nrOfResults, $start);
        }

        mysqli_free_result($result);

    } else {
        noResult($name, $opt);
    }

}

/**
 * Counts the total number of results from the
 * specified search query
 * @param  MySQL database connection $con MySQL connection
 * @param  string $str Search string
 * @return int $nrOfResults
 */
function countResults($con, $opt, $cid, $cname, $id, $name)
{
 /*
    $sql
        = "SELECT COUNT(*) AS results
        FROM sets
        WHERE SetID LIKE '%$str%'
        OR Setname LIKE '%$str%'"
    ;
*/
    if ($opt == 2) {
        $sql
            = "SELECT COUNT(*) AS results
            FROM sets
            WHERE SetID LIKE '%$name%'
            OR Setname LIKE '%$name%'
            ";

    } elseif ($opt == 0) {
        $sql
            = "SELECT COUNT(*) AS results
                FROM sets, categories
                WHERE sets.catID = categories.catid
                AND sets.catID LIKE '%$cid%'
                AND categories.categoryname LIKE '%$cname%'
                AND sets.SetID LIKE '%$id%'
                AND sets.Setname LIKE '%$name%'
                ";
    } elseif ($opt == 1) {
        $sql
            = "SELECT COUNT(*) AS results
                FROM parts, inventory, colors
                WHERE inventory.ItemID = parts.PartID
                AND inventory.ColorID = colors.ColorID
                AND inventory.ColorID LIKE '%$cid%'
                AND colors.Colorname LIKE '%$cname%'
                AND parts.PartID LIKE '%$id%'
                AND parts.Partname LIKE '%$name%'
                ";
    }
    $result = mysqli_query($con, $sql);

    $row = mysqli_fetch_assoc($result);

    $nrOfResults = $row['results'];

    return $nrOfResults;
}

/**
 * Writes out an error message to the user if no results were found
 * when searching.
 * @param  string $str search string
 * @return void
 */
function noResult($name, $opt)
{
    echo "<div class='row'>" . "\n";
    echo    "<div class='text' style='text-align:center'>" . "\n";
    if ($opt == 2) {
        echo "Your search for <strong>" . $name . "</strong> gave no results. Please try again." . "\n";
    } else {
        echo "Your search gave no results. Please try again." . "\n";
    }
    echo    "</div>" . "\n";
    echo "</div>" . "\n";
}

function printError($str)
{
    echo "<div class='row'>" . "\n";
    echo    "<div class='text' style='text-align:center'>" . "\n";
    echo        "Error: <strong>" . $str . "</strong>" . "\n";
    echo    "</div>" . "\n";
    echo "</div>" . "\n";
}

/**
 * Write results.
 *
 * Starts by calling the handleImgUrl function to get the correct
 * image URL.
 * Afterwards, the info from $row, which contains a row of search results,
 * is printed, along with the URL from the called function.
 * @param  MySQL connection $con Connection to the database
 * @param  Associative array $row
 * @return void
 */
function mainSearchHtml($con, $row, $opt)
{
    if ($opt == 1) {
        $imgUrl = handleImgUrl($con, $row['PartID']);
    } else {
        $imgUrl = handleImgUrl($con, $row['SetID']);
    }
    echo "<div class='row' onclick='loadExtended(this)'>" . "\n";
    echo    "<div class='thumb'>" . "\n";
    echo        "<a href='". $imgUrl ."'><img src='" . $imgUrl . "' alt='bild' > </a>" . "\n";
    echo    "</div>" . "\n";
    echo    "<div class='text'>" . "\n";
    if ($opt == 1) {
        echo        "<h3 class='setname'>" . $row['Partname'] . "</h3> \n";
        echo         "<p class='setid'>" . $row['PartID'] . "</p> \n";
    } else {
        echo        "<h3 class='setname'>" . $row['Setname'] . "</h3> \n";
        echo         "<p class='setid'>" . $row['SetID'] . "</p> \n";

    }
    echo    "</div>" . "\n";
    echo "</div>" . "\n";

}

/**
 * Gets the image URL for the specified set
 * @param  MySQL database connection $con
 * @param  string $setID The Set ID
 * @return string
 */
function handleImgUrl($con, $setID)
{

    // SQL query
    $sql
        = "SELECT images.*
        FROM sets, images
        WHERE sets.setID = images.itemID
        AND images.itemID = '$setID'"
    ;

    // Store the SQL query
    $result = mysqli_query($con, $sql);

    // If query not empty
    if ($result) {

        // Store a row in an associative array
        $row = mysqli_fetch_assoc($result);

        // If the row doesn't contain an item ID, then the specified set doesn't
        // have an image. Sets the URL to a placeholder image
        if ($row['itemID'] == null) {
            $imgUrl = "img/noimage.png";
        } else {
            // Puts together the URL according to what $row contains
            $imgDir = "http://webstaff.itn.liu.se/~stegu/img.bricklink.com/";
            $imgUrl = $imgDir . $row['itemTypeID'];

            /*if ($row['has_largejpg'] == "1") {
                $imgUrl .= "L";
            } */

            $imgUrl .= "/";

            // If itemTypeID is P or G it means the object has a colorID.
            // In that case, add the color ID to the URL
            if ($row['itemTypeID'] == "P" || $row['itemTypeID'] == "G") {
                $imgUrl = $imgUrl . $row['colorID'] . "/";
            }

            // Add the itemID to the URL
            $imgUrl = $imgUrl . $row['itemID'];

            // Add appropriate file ending
            if ($row['has_gif'] == 1) {
                $imgUrl = $imgUrl . ".gif";
            } elseif ($row['has_jpg'] == 1) {
                $imgUrl = $imgUrl . ".jpg";
            }

        }
    }

    return $imgUrl;
}

/**
 * multiPage
 * Function for listing pages of results when searching
 * @param  string $str Search string
 * @param  int $nrOfResults The number of results
 * @param  int $start Specifies on which page the user is
 * @return void
 */
function multiPage($searchUrl, $nrOfResults, $start)
{
    echo "<div id='multiPage'>";
    echo "<ul>";

    $totalPages = floor($nrOfResults/20);
    $currentPage = ($start/20);

    // Code for setting which page to start the loop and which
    // page to stop
    if ($currentPage < 5) {
        $i = 0;
        $endPage = 8;
    } elseif ($totalPages - $currentPage < 5) {
        $i = ($totalPages - 8);
        $endPage = $totalPages;
    } else {
        $i = ($currentPage - 4);
        $endPage = ($currentPage + 4);
    }

    if ($totalPages < 9) {
        $endPage = $totalPages;
    }

    // Always print link to first result
    echo "<li> <a href='" . $searchUrl . "'><strong>First result </strong></a> </li>";

    // Print the proper pages

    if ($currentPage <= $totalPages) {
        for (; $i <= $endPage; $i++) {

            if ($i == $currentPage) {
                echo "<li> <strong> " . ($i+1) . " </strong> </li>";
            } else {
                echo "<li> <a href='" . $searchUrl . "&start=" . $i*20 . "'>" . ($i+1) . "</a> </li>";
            }
        }
    }

    // Always print link to last result
    echo "<li> <a href='" . $searchUrl . "&start=" . $totalPages*20 . "'><strong>Last result</strong></a> </li>";

    echo "</ul>";
    echo "</div>";

}
