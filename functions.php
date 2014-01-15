<?php

/**
 * Connect to the specified MySQL database
 * @return MySQL database connection
 */
function connect()
{
    $con = mysqli_connect("koneko.se", "projekt", "tnmk30", "lego");
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
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
    if (ctype_space($data) || empty($data) || $data == null) {
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
    /*$sql
        = "SELECT images.*, sets.SetID, sets.Setname
        FROM sets, images
        WHERE sets.SetID = images.itemID
        AND images.itemTypeID = 'S'
        AND (sets.SetID LIKE '%$str%' OR sets.Setname LIKE '%$str%')
        LIMIT $start , 20"
    ;*/

/*    $sql
        = "SELECT images.*, sets.setID, sets.Setname
        FROM sets
        LEFT JOIN images
        ON sets.SetID=images.itemID
        WHERE (SetID LIKE '%$str%' OR Setname LIKE '%$str%')
        LIMIT $start , 20"
    ;*/

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

    //$calcTime = microtime(true) - $calcTime;

    $nrOfResults = countResults($con, $str);

    if ($nrOfResults != 0) {

        //echo "<div id='resultStats'>" . $nrOfResults . " results. (" . $calcTime . " seconds) </div>";

        while ($row = mysqli_fetch_assoc($result)) {
            mainSearchHtml($con, $row);
        }

        if ($nrOfResults > 20) {
            multiPage($str, $nrOfResults, $start);
        }

        mysqli_free_result($result);

    } else {
        noResult($str);
    }

}

function constructQuery($optArray)
{
    //foreach($optArray)

    return $sqlString;
}


function advSearch($con, $str, $start, $opt)
{

    if ($opt) {
        $sql
            = "";
    } else {
        $sql
            = "";
    }

    $result = mysqli_query($con, $sql);

    $nrOfResults = countResults($con, $str);

    if ($nrOfResults != 0) {

        echo "<div id='resultStats'>" . $nrOfResults . " results. (" . $calcTime . " seconds) </div>";

        while ($row = mysqli_fetch_assoc($result)) {
            mainSearchHtml($con, $row);
        }

        if ($nrOfResults > 20) {
            multiPage($str, $nrOfResults, $start);
        }

        mysqli_free_result($result);

    } else {
        noResult($str);
    }

}

/**
 * Counts the total number of results from the
 * specified search query
 * @param  MySQL database connection $con MySQL connection
 * @param  string $str Search string
 * @return int $nrOfResults
 */
function countResults($con, $str)
{
    
    $sql
        = "SELECT COUNT(*) AS results
        FROM sets
        WHERE SetID LIKE '%$str%'
        OR Setname LIKE '%$str%'"
    ;

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
function noResult($str)
{
    echo "<div class='row'>" . "\n";
    echo    "<div class='text' style='text-align:center'>" . "\n";
    echo        "Your search for <strong>" . $str . "</strong> gave no results. Please try again." . "\n";
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
function mainSearchHtml($con, $row)
{

    $imgUrl = handleImgUrl($con, $row['SetID']);

    echo "<div class='row' onclick='loadExtended(this)'>" . "\n";
    echo    "<div class='thumb'>" . "\n";
    echo        "<a href='". $imgUrl ."'><img src='" . $imgUrl . "' alt='bild' > </a>" . "\n";
    echo    "</div>" . "\n";
    echo    "<div class='text'>" . "\n";
    echo        "<h3 class='setname'>" . $row['Setname'] . "</h3> \n";
    echo         "<p class='setid'>" . $row['SetID'] . "</p> \n";
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
function multiPage($str, $nrOfResults, $start)
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
    echo "<li> <a href='index.php?searchterm=" . $str . "'><strong>First result </strong></a> </li>";

    // Print the proper pages
    
    if ($currentPage <= $totalPages) {
        for (; $i <= $endPage; $i++) {

            if ($i == $currentPage) {
                echo "<li> <strong> " . ($i+1) . " </strong> </li>";
            } else {
                echo "<li> <a href='index.php?searchterm=" . $str . "&start=" . $i*20 . "'>" . ($i+1) . "</a> </li>";
            }
        }
    }

    // Always print link to last result
    echo "<li> <a href='index.php?searchterm=" . $str . "&start=" . $totalPages*20 . "'><strong>Last result</strong></a> </li>";

    echo "</ul>";
    echo "</div>";

}
