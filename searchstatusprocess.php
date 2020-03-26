<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Status</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <br />
    <div class="container-fluid">
        <div class="container border border-dark">
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

                // Get data from the form
                $search_query = $_POST["search"];

                // Set up the SQL command to retrieve the data from the table
                // % symbol represent a wildcard to match any characters
                // like is a compairson operator
                $query = "select * from $sql_tble where CODE like '%$search_query%'";

                // executes the query and store result into the result pointer
                $result = mysqli_query($conn, $query);
                // checks if the execuion was successful
                if (!$result) {
                    echo "<p>Something is wrong with ",  $query, "</p>";
                } else {
                    // Display the retrieved records
                    // retrieve current record pointed by the result pointer
                    // Note the = is used to assign the record value to variable $row, this is not an error
                    // the ($row = mysqli_fetch_assoc($result)) operation results to false if no record was retrieved
                    // _assoc is used instead of _row, so field name can be used
                    while ($row = mysqli_fetch_assoc($result)) {
                        $allow_like = $row["ALLOW_LIKE"];
                        $allow_comment = $row["ALLOW_COMMENT"];
                        $allow_share = $row["ALLOW_SHARE"];

                        echo "<div class=\"container bg-dark text-white border border-white\">";
                        echo "<h1>Status Information</h1>";
                        echo "Status: ", $row["STATUS"], "<br />";
                        echo "Code: ", $row["CODE"], "<br />";
                        echo "Share:", $row["SHARE"], "<br />";
                        echo "Date Posted: ", $row["STATUS_DATE"], "<br />";
                        echo "Permissions: ", $allow_like ? "Like, " : "", $allow_comment ? "Comment, " : "", $allow_share ? "Share, " : "", "</div><br/>";
                    }
                    // Frees up the memory, after using the result pointer
                    mysqli_free_result($result);
                } // if successful query operation

                // close the database connection
                mysqli_close($conn);
            } // if successful database connection
            ?>
            <a href="searchstatusform.php">Search for another Status</a><br />
            <a href="index.html">Back to Home</a><br />
        </div>
    </div>
</body>

</html>