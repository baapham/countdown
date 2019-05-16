<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="custom.css">
        <title>Countdown</title>
    </head>
    <body>
    <div class="content">
        <form action="calculate.php" method="get">
            <h1>Welcome to Countdown</h1>
            <p> Please choose 6 numbers</p><br>
            <input type="number" name="num1" class="numberInput">
            <input type="number" name="num2" class="numberInput">
            <input type="number" name="num3" class="numberInput">
            <input type="number" name="num4" class="numberInput">
            <input type="number" name="num5" class="numberInput">
            <input type="number" name="num6" class="numberInput"><br>
            <p class="buttonNew"> <button type="button" class="btn btn-primary btn-lg">Generate a number!</button></p>
        </form>
    </div>
    </body>
</html>