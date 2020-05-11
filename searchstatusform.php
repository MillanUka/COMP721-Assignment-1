<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Search Status</title>
</head>

<body>
    <br />
    <div class="container-xl bg-dark text-white border border-success">
        <br />
        <form action="searchstatusprocess.php" method="GET">
            <div class="input-group mb-3">
                <label for="searchBar">Status: </label>
                <input id="searchBar" type="text" name="search" value="" placeholder="Enter a search query"/>
                <div class="input-group-append">
                    <button class="btn-primary" id="viewStatusButton">View Status</button>
                </div>
            </div>
            <br />
            <a href="index.html">Back to Home</a>
        </form>
    </div>

</body>

</html>