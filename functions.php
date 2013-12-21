<?php


function connect()
{
    $con = mysqli_connect("koneko.se", "projekt", "tnmk30", "lego");
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    return $con;
}

function validate($data)
{
    // Do something more here?
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

function printTitle($title)
{
    echo "<title>";
    if ($title) {
        echo $title . " - ";
    }
    echo "Brick Search" . "</title>";

}

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

    $sql
        = "SELECT sets.SetID, sets.Setname
        FROM sets
        WHERE SetID LIKE '%$str%'
        OR Setname LIKE '%$str%'
        LIMIT $start , 20"
    ;

    $calcTime = microtime(true);

    $result = mysqli_query($con, $sql);

    $calcTime = microtime(true) - $calcTime;

    $nrOfResults = countResults($con, $str);

    if ($nrOfResults != 0) {

        echo "<div id='resultStats'>" . $nrOfResults . " results. (" . $calcTime . " seconds) </div>";

        while($row = mysqli_fetch_assoc($result)) {
            mainSearchHtml($con, $row);
        }

        if($nrOfResults > 20) {
            multiPage($str, $nrOfResults, $start);
        }

        mysqli_free_result($result);

    } else {
        noResult($str);
    }

}

function countResults($con, $str) {
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


function noResult($str) {
    echo "<div class='row'>" . "\n";
    echo    "<div class='text' style='text-align:center'>" . "\n";
    echo        "Your search for <strong>" . $str . "</strong> gave no results. Please try again." . "\n";
    echo    "</div>" . "\n";
    echo "</div>" . "\n";
}


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

function handleImgUrl($con, $setID)
{

    $sql
        = "SELECT images.*
        FROM sets, images
        WHERE sets.setID = images.itemID
        AND images.itemID = '$setID'"
    ;

    $result = mysqli_query($con, $sql);
    
    if($result) {

        $row = mysqli_fetch_assoc($result);


        if($row['itemID'] == NULL) {
            $imgUrl = "img/noimage.png";
        } else {
            // Sätter ihop URL:en efter vad som $row innehåller.
            $imgDir = "http://webstaff.itn.liu.se/~stegu/img.bricklink.com/";
            $imgUrl = $imgDir . $row['itemTypeID'];

            /*if ($row['has_largejpg'] == "1") {
                $imgUrl .= "L";
            } */

            $imgUrl .= "/";

            // Om itemTypeID är P eller G så betyder det att objektet har ett colorID
            if ($row['itemTypeID'] == "P" || $row['itemTypeID'] == "G") {
                $imgUrl = $imgUrl . $row['colorID'] . "/";
            }

            // Lägger till itemID till URL:en
            $imgUrl = $imgUrl . $row['itemID'];

            // Lägger till lämpliga filändelser
            if ($row['has_gif'] == 1) {
                $imgUrl = $imgUrl . ".gif";
            } elseif ($row['has_jpg'] == 1) {
                $imgUrl = $imgUrl . ".jpg";
            }

        }
    }

    return $imgUrl;
}

function multiPage($str, $nrOfResults, $start) {

    echo "<div id='multiPage'>";
        echo "<ul>";

        $totalPages = ceil($nrOfResults/20);
        $currentPage = ($start/20);

        echo "total pages: " . $totalPages . '<br>';
        echo "current page: " . $currentPage . '<br>';

        if($currentPage <= 5) {
            $i = 0;
        } else {
            $i = ($currentPage-5);
        }

        if($totalPages < 10) {
            $endPage = $totalPages;
        } else if ($currentPage < 5 ) {
            $endPage = 10;
        } else {
            $endPage = ($currentPage + 5);
        }

        echo 'start page: ' . $i;
        echo '<br> end page: ' . $endPage . "</br>";

        for(; $i < $endPage; $i++) {
            echo 'i: ' . $i;

            if($i == $currentPage) {
                echo "<li> <strong> " . ($i+1) . " </strong> </li>";
            } else if($i == 0 || $i == $totalPages-1) {
                echo "<li> <a href='index.php?searchterm=" . $str . "&start=" . $i*20 . "'><strong>" . ($i+1) . "</strong></a> </li>";
            }
            else  {
                echo "<li> <a href='index.php?searchterm=" . $str . "&start=" . $i*20 . "'>" . ($i+1) . "</a> </li>";
            }
        }
        echo "</ul>";
    echo "</div>";

    // enter page -> results show -> 'multiPage' function is run -> displays 10 entries.
    // if current entry is 1 and totalt pages is more than 10, then show 1->10
    // else if current entry is less than 10, but more than 1, show 1->currentpage->10
    // else if current entry is more than 10 and total pages is less than currentpage+5, show (currentpage-5)->currentpage->total pages
    // else show (currentpage-5)->currentpage->(currentpage+4)


    // if currentpage is less than 5 show 1->currentpage->total pages
    // else if currentpage is more than 5, show currentpage-5->currentpage->total pages
    // 


}