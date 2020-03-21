<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Post a Status</title>
</head>

<body>
    <?php


    $status_code = $_POST["statusCode"];
    $status = $_POST["status"];
    $share = $_POST["radioAnswers"];
    $date = $_POST["date"];
    $allow_like = $_POST["allowLike"];
    $allow_comment = $_POST["allowComment"];
    $allow_share = $_POST["allowShare"];

    function check_if_status_code_valid($code)
    {
        if (strlen($code) == 5) {
            //Get the first character
            $first_char = substr($code, 0, 1);

            //Check if the first character is 'S'
            if (strcmp($first_char, "S") == 0) {
                //Check if the next four characters are numbers
                for ($i = 1; $i < 5; $i++) {
                    $current_char = substr($code, $i, 1);
                    //If any of the numbers are not a number return false
                    if (!is_numeric($current_char)) {
                        return false;
                    }
                }
                //Checks are complete and code is valid return true
                return true;
            }
            return false;
        }
        //length is not four which means its not a valid code return false
        return false;
    }

    function check_if_input_valid($code, $status, $date)
    {
        $is_code_valid = check_if_status_code_valid($code);

        //Check the date
        //Split the string into seperate parts;
        $date_str = explode("-", $date);
        $year = $date_str[0];
        $month = $date_str[1];
        $day = $date_str[2];

        //check if the date is valid
        $date_valid = checkdate($month, $day, $year);

        //Checks if the status us empty, if it is then it will be false.
        $status_valid = !(strcmp($status, "") == 0);

        // And all the boolean flags to check if the data entered is ready to add to the database
        return $is_code_valid && $date_valid && $status_valid;
    }
    function write_to_database($status_code, $status, $radio_answers, $date, $allow_like, $allow_comment, $allow_share)
    {
        require_once('../../conf/sqlinfo.inc.php');
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

            //format allow boolean flags;
            $is_like = (strcmp($allow_like, "on") == 0) ? true : 0;
            $is_comment = (strcmp($allow_comment, "on") == 0) ? true : 0;
            $is_share = (strcmp($allow_share, "on") == 0) ? true : 0;


            echo $is_like ? "true" : "false";
            echo $is_comment ? "true" : "false";
            echo $is_share ? "true" : "false";
            // Set up the SQL command to add the data into the table
            $query = "INSERT INTO $sql_tble"
                . "(CODE, STATUS, SHARE, STATUS_DATE, ALLOW_LIKE, ALLOW_COMMENT, ALLOW_SHARE)"
                . "values"
                . "('$status_code','$status','$share', '$date', $is_like, $is_comment, $is_share)";
            echo $query;
            // executes the query
            $result = mysqli_query($conn, $query);
            // checks if the execution was successful
            if (!$result) {
                echo "<p>Something is wrong with ",    $query, "</p>";
            } else {
                // display an operation successful message
                echo "<p>Success</p>";
            } // if successful query operation

            // close the database connection
            mysqli_close($conn);
        }  // if successful database connection
    }

    if (check_if_input_valid($status_code, $status, $date)) {
        echo "success";
        write_to_database($status_code, $status, $radio_answers, $date, $allow_like, $allow_comment, $allow_share);
    } else {
        //Display an error message
        echo "<div class\"container\">There was an error. Input was invalid<br />";
        echo "<a href=\"index.html\">Home</a><br /><a href=\"poststatusform.php\">Post status</a></div>";
    }
    ?>
</body>

</html>