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

function mainSearch($con, $str)
{
    $sql
        = "SELECT images.*, sets.SetID, sets.Setname
        FROM sets, images
        WHERE sets.SetID = images.itemID
        AND images.itemTypeID = 'S'
        AND sets.Setname LIKE '%$str%'"
    ;

    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) != 0) {

        while($row = mysqli_fetch_assoc($result)) {
            mainSearchHtml($row);
        }

        mysqli_free_result($result);

    } else {
        noResult($str);
    }

}


/**
 * List year made, category name, parts names, id for parts
 * Will probably add more stuff
 * 
 */
function extendedSearch($setID) {

    $setQuery
        = "SELECT sets.Year, categories.Categoryname
        FROM sets, categories
        WHERE sets.CatID = categories.CatID
        AND sets.SetID LIKE '$setID'"
    ;

    $partsQuery 
        = "SELECT parts.Partname, inventory.ItemID
            FROM sets, parts, inventory
            WHERE sets.SetID = inventory.SetID
            AND inventory.ItemID = parts.PartID
            AND sets.SetID LIKE '$setID'"
    ;

}

function noResult($str) {
    echo "<div class='row'>" . "\n";
    echo    "<div class='text' style='text-align:center'>" . "\n";
    echo        "<p> Your search for <strong>" . $str . "</strong> gave no results. Please try again. </p>" . "\n";
    echo    "</div>" . "\n";
    echo "</div>" . "\n";
}


function mainSearchHtml($row)
{

    $imgUrl = handleImgUrl($row);

    echo "<div class='row'>" . "\n";
    echo    "<div class='thumb'>" . "\n";
    echo        "<img class='thumb' src='" . $imgUrl . "' alt='bild' >" . "\n";
    echo    "</div>" . "\n";
    echo    "<div class='text'>" . "\n";
    echo        "<h2 class='setname'>" . $row['Setname'] . "</h2> \n";
    echo         "<p class='setid'>" . $row['SetID'] . "</p> \n";
    echo    "</div>" . "\n";
    echo "</div>" . "\n";

}

function handleImgUrl($row)
{

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
    } else {
        $imgUrl = "img/noimage.png";
    }

    return $imgUrl;

}
