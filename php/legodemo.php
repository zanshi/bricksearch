!<doctype html>
<html>
<head>
    <?php
    $con = mysql_connect("koneko.se", "projekt", "tnmk30");
    if (!$con) {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db("lego");
/*   Från formuläret, om man trycker på "submit"-knappen, kommer
   variablen $POST["setnr"] som innehåller texten i fältet "setnr".*/
    $setnr = $_POST["setnr"];
    ?>
    <title>Lego-sats nummer <?php print $setnr ?></title>
</head>

<body>
    <h2>Matchande Lego-satser:</h2>

    <p>
    <?php

    $contents = mysql_query(
        "SELECT SetID, Setname 
        FROM sets 
        WHERE SetID LIKE '$setnr-%'"
    );

    var_dump($contents);


    if (mysql_num_rows($contents) == 0) {
        print("Inga satser funna!");
    } else {
        print("<table border=1>\n<tr>");
    for ($i=0; $i<mysql_num_fields($contents); $i++) {
                $fieldname = mysql_field_name($contents, $i);
                print("<th>$fieldname</th>");
    }
        print "</tr>\n";

    while ($row = mysql_fetch_row($contents)) {
        print("<tr>");
        for ($i=0; $i<mysql_num_fields($contents); $i++) {
            print("<td>$row[$i]</td>");
        }
        print("</tr>\n");
    }
        print("</table>\n");
    }
?>
</p>

<h2>Bitar i dessa satser:</h2>

<p>

    <?php
    $contents = mysql_query(
        "SELECT inventory.SetID, inventory.Quantity, colors.Colorname, parts.Partname
        FROM inventory
        JOIN parts ON inventory.ItemID = parts.PartID
        JOIN colors ON inventory.ColorID = colors.ColorID
        WHERE inventory.SetID LIKE '$setnr-%'
        ORDER BY SetID, Partname"
    );

    if (mysql_num_rows($contents) == 0) {
        print("Ingen detaljerad information funnen!");
    } else {
        print("<table border=1>\n<tr>");
    for ($i=0; $i<mysql_num_fields($contents); $i++) {
            $fieldname = mysql_field_name($contents, $i);
            print("<th>$fieldname</th>");
    }
        print "</tr>\n";

    while ($row = mysql_fetch_row($contents)) {
        print("<tr>");
        for ($i=0; $i<mysql_num_fields($contents); $i++) {
            print("<td>$row[$i]</td>");
        }
        print("</tr>\n");
    }
        print("</table>\n");
    }
?>
</p>
</body>
</html>
