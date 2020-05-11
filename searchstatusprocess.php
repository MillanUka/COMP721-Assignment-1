<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Search Results</title>
</head>

<body>
    <br />
    <div class="container-fluid">
        <div class="container bg-dark border border-dark">
            <br>
            <?php
            // sql info or use include 'file.inc'
            require_once('../../conf/sqlinfo.inc.php');

            // The @ operator suppresses the display of any error messages
            // mysqli_connect returns false if connection failed, otherwise a connection value
            $conn = @mysqli_connect(
                $sql_host,
                $sql_user,
                $sql_pass,
                $sql_db
            );

            // Checks if connection is successful
            if (!$conn) {
                // Displays an error message
                echo "<p>Database connection failure</p>";
            } else {
                // Upon successful connection

                //Check if the table exists
                $checktable = mysqli_query($conn, "SHOW TABLES LIKE '$sql_tble'");
                $is_table_exists = mysqli_num_rows($checktable) > 0;
                if (!$is_table_exists) {
                    // If it doesnt exist display an error message and the the links back to home
                    echo "<div class=\"text-white\">";
                    echo "The table does not exists and there is no entries. Post a status before trying to search for a status<br />";
                    echo "<a href=\"searchstatusform.php\">Search for another Status</a><br />";
                    echo "<a href=\"index.html\">Back to Home</a><br />";
                    echo "</div>";
                    return;
                }
                // Get data from the form
                // Sanitise the data with a should removes special characters and prevent SQL injections
                $search_query = mysqli_real_escape_string($conn, $_GET["search"]);

                // Create the query
                $query = "SELECT * FROM $sql_tble WHERE CODE LIKE '%$search_query%'";

                // executes the query and store results into the result pointer
                $result = mysqli_query($conn, $query);


                // checks if the execuion was successful
                if (!$result) {
                    echo "<p>Something is wrong with ",  $query, "</p>";
                } else {
                    //CHeck if there is any search results by getting the number of rows
                    $numRows = mysqli_num_rows($result);
                    if ($numRows == 0) {
                        //Display no results found error message
                        echo "<h3 class=\"text-white\">No results</h3>";
                    } else {

                        echo "<h1 class=\"text-white\">Search Results</h1>";

                        echo "<table class=\"table-light table-striped table-bordered table-hover\">";
                        echo "<thead class=\"thead-dark\">";
                        echo "<th>CODE</th>";
                        echo "<th>STATUS</th>";
                        echo "<th>SHARE</th>";
                        echo "<th>DATE</th>";
                        echo "<th>PERMISSION</th>";
                        echo "</thead>";

                        // Go through all the results of the statuses and display them
                        while ($row = mysqli_fetch_assoc($result)) {
                            $allow_like = $row["ALLOW_LIKE"];
                            $allow_comment = $row["ALLOW_COMMENT"];
                            $allow_share = $row["ALLOW_SHARE"];
                            echo "<tr>";
                            echo "<td>", $row["CODE"];
                            echo "<td>", $row["STATUS"];
                            echo "<td>", $row["SHARE"];
                            echo "<td>", $row["STATUS_DATE"];
                            echo "<td>", $allow_like ? "Like, " : "", $allow_comment ? "Comment, " : "", $allow_share ? "Share, " : "";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                    // Frees up the memory, after using the result pointer
                    mysqli_free_result($result);
                } // if successful query operation

                // close the database connection
                mysqli_close($conn);
            }
            ?>
            <a href="searchstatusform.php">Search for another Status</a><br />
            <a href="index.html">Back to Home</a><br />
        </div>
    </div>
</body>

</html>