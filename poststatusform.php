<!DOCTYPE php>
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
    <div class="container">
        <br />
        <div class="container-xl bg-dark text-white border border-success">
            <form action="poststatusprocess.php" method="POST">
                Status Code (Required): <input id="statusCodeBox" type="text" name="statusCode" placeholder="e.g. S1000" maxlength="5">
                Status (Required): <input id="statusBox" type="text" name="status" value="" placeholder="Please enter a status">
                Share:
                <div class="container" id="radioButtons">
                    <input id="public" type="radio" value="Public" name="radioAnswers" checked>
                    <label for="public">Public</label>
                    <input id="friends" type="radio" value="Friends" name="radioAnswers">
                    <label for="friends">Friends</label>
                    <input id="onlyMe" type="radio" value="Only Me" name="radioAnswers">
                    <label for="onlyMe">Only Me</label>
                </div>
                <!-- Date input form initalised with the current date using the php date function -->
                Date: <input type="date" , value="<?php echo date('Y-m-d'); ?>" name="date">
                <br />
                Permission Type:
                <div class="container">
                    <input id="allowLike" type="checkbox" name="allowLike">
                    <label for="allowLike">Allow Like</label>
                    <input id="allowComment" type="checkbox" name="allowComment">
                    <label for="allowComment">Allow Comment</label>
                    <input id="allowShare" type="checkbox" name="allowShare">
                    <label for="allowShare">Allow Share</label>
                </div>
                <button class="btn bg-primary text-white" id="postButton" type="submit">Post</button>
                <button class="btn bg-primary text-white" id="resetButton" type='reset' value='Reset' name='reset'>Reset</button>
                <br />
                <a href="index.html">Back to Home</a>
                <?php
                ?>
            </form>
        </div>
    </div>
</body>

</html>