<!DOCTYPE php>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Post a Status</title>
</head>

<body>
    <div class="container border border-dark">
        <form>
            Status Code (Required)<input id="statusCodeBox" type="text">
            <br />
            Status (Required)<input id="statusBox" type="text">
            <br />
            Share:
            <div class="container" id="radioButtons">
                <input id="public" type="radio">
                <label for="public">Public</label>
                <input id="friends" type="radio">
                <label for="friends">Friends</label>
                <input id="onlyMe" type="radio">
                <label for="onlyMe">Only Me</label>
            </div>
            Date: <input type="date">
            <br />
            Permission Type:
            <div class="container">
                <input id="allowLike" type="checkbox">
                <label for="allowLike">Allow Like</label>
                <input id="allowComment" type="checkbox">
                <label for="allowComment">Allow Comment</label>
                <input id="allowShare" type="checkbox">
                <label for="allowShare">Allow Share</label>
            </div>
            <button class="btn bg-primary text-white"id="postButton">Post </button>
            <button class="btn bg-primary text-white"id="resetButton">Rest </button>
            <br/>
            <a href="index.html">Back to Home </a>
            <?php
            ?>
        </form>
    </div>
</body>

</html>