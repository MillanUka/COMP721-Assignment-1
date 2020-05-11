<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Post a Status</title>
</head>

<body>
    <br />
    <div class="container bg-dark text-white">
        <?php
        //This function checks if a status code is valid in the format of SXXXX where X is integer
        function check_if_status_code_valid($code)
        {
            if (strlen($code) == 5) {
                //Get the first character
                $first_char = substr($code, 0, 1);

                //Check if the first character is 'S'
                if (strcmp($first_char, "S") == 0) {
                    //Check if the next four characters are numbers
                    if (is_numeric(substr($code, 1)) == 0) {
                        return false;
                    }

                    //Checks are complete and code is valid return true
                    return true;
                }
                //First char is not S return false
                return false;
            }
            //length is not five which means its not a valid code return false
            return false;
        }

        //This function check that the new status entered is valid and does not meets the requirements
        function check_if_input_valid($code, $status, $date)
        {
            //Check if the code is value
            $is_code_valid = check_if_status_code_valid($code);

            //Check the date
            //Split the string into seperate parts using the explode function
            $date_str = explode("-", $date);
            $year = $date_str[0];
            $month = $date_str[1];
            $day = $date_str[2];

            //check if the date is valid
            $date_valid = checkdate($month, $day, $year);

            //Checks if the status is empty, if it is then it will be false as the status cannot be null.
            $status_valid = !empty($status);

            //DIsplay the custom error messages for the incorrect input if it applies
            echo (!$is_code_valid) ? "Status Code was invalid. Please enter an 'S' with four other numbers.<br />" : "";
            echo (!$date_valid) ? "Date was invalid. Please enter a valid date.<br /> " : "";
            echo (!$status_valid) ? "Status was invalid. Please enter a status <br />" : "";

            // And all the boolean flags to check if the data entered is ready to add to the database
            return $is_code_valid && $date_valid && $status_valid;
        }

        // Writes the user's status into the database 
        function write_to_database($status_code, $status, $share, $date, $allow_like, $allow_comment, $allow_share)
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
                //Check if the table exists
                $checktable = mysqli_query($conn, "SHOW TABLES LIKE '$sql_tble'");
                $is_table_exists = mysqli_num_rows($checktable) > 0;
                if (!$is_table_exists) {
                    // If the table doesnt exist
                    //Create the table
                    $create_table = "CREATE TABLE $sql_tble (
                        CODE varchar(5) PRIMARY KEY,
                        STATUS varchar(1000) NOT NULL,
                        SHARE varchar(40),
                        STATUS_DATE date NOT NULL,
                        ALLOW_LIKE boolean,
                        ALLOW_COMMENT boolean,
                        ALLOW_SHARE boolean
                    )";
                    $results = mysqli_query($conn, $create_table);
                    if ($results) {
                        echo "Created Table";
                    }
                }
                // Upon successful connection
                //format allow boolean flags
                $is_like = (strcmp($allow_like, "on") == 0) ? true : 0;
                $is_comment = (strcmp($allow_comment, "on") == 0) ? true : 0;
                $is_share = (strcmp($allow_share, "on") == 0) ? true : 0;

                // Set up the SQL command to add the data into the status table
                $query = "INSERT INTO $sql_tble"
                    . "(CODE, STATUS, SHARE, STATUS_DATE, ALLOW_LIKE, ALLOW_COMMENT, ALLOW_SHARE)"
                    . "values"
                    . "('$status_code','$status','$share', '$date', $is_like, $is_comment, $is_share)";
                // executes the query.
                //Use htmlspecialchars to remove any html tags to prevent XSS attacks 
                $result = mysqli_query($conn, htmlspecialchars($query));
                // checks if the execution was successful
                if (!$result) {
                    //Display errors message if the status code was incorrect
                    echo "<p>There was an error with the query! Please check that your status code is unique.</p>";
                } else { 
                    // display an operation successful message
                    echo "<p>Success! Status added to the database</p>";
                }
                // close the database connection
                mysqli_close($conn);
            }
        }

        $status_code = $_POST["statusCode"];
        $status = $_POST["status"];
        $share = $_POST["radioAnswers"];
        $date = $_POST["date"];
        $allow_like = $_POST["allowLike"];
        $allow_comment = $_POST["allowComment"];
        $allow_share = $_POST["allowShare"];

        if (check_if_input_valid($status_code, $status, $date)) {
            write_to_database($status_code, $status, $share, $date, $allow_like, $allow_comment, $allow_share);
        } else {
            //Display an error message
            echo "Please try again.<br/>";
        }
        echo "<a href=\"poststatusform.php\">Post status</a><br /><a href=\"index.html\">Back to Home</a></div>";
        ?>
    </div>
</body>

</html>