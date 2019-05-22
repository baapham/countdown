<!-- Given array elements, reverses the array -->
<?php 
function reverseArray($num1, $num2, $num3, $num4, $num5, $num6) {
    return array($num6, $num5, $num4, $num3, $num2, $num1); 
}
function chooseOperator($randomNumber) {
    if ($randomNumber >= 0 && $randomNumber < 50) {
        return " + ";
    }
    else if ($randomNumber >= 50 && $randomNumber < 100) {
        return " - ";
    }
    else if ($randomNumber >= 100 && $randomNumber < 150) {
        return " * ";
    }
    else if ($randomNumber >= 150 && $randomNumber < 200) {
        return " / ";
    }
    return 0;
}
function evaluateEquation($equation){
    $matches = preg_split("/ /", $equation, -1, PREG_SPLIT_NO_EMPTY);
    $operator = $matches[1];
    switch($operator){
        case '+':
            return $matches[0] + $matches[2];
        case '-':
            if (($matches[0] - $matches[2]) < 0) {
                $operator = chooseOperator(mt_rand(0, 199));
                return evaluateEquation(formEquation($matches[0], $operator, $matches[2]));
            }
            return $matches[0] - $matches[2];
        case '*':
            return $matches[0] * $matches[2];
        case '/':
            if (is_float($matches[0] / $matches[2])) {
                $operator = chooseOperator(mt_rand(0, 199));
                return evaluateEquation(formEquation($matches[0], $operator, $matches[2]));
            }
            return $matches[0] / $matches[2];
    }
}
function formEquation($firstNumber, $operator, $secondNumber) {
    return (string)$firstNumber . $operator . (string)$secondNumber;
}


?>


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
        <form action="index.php" method="get">
            <a href="index.php"><h1>Welcome to Countdown</h1></a>
            <p> Please choose 6 numbers</p><br>
            <!-- User inputs the numbers, after submitting, the value remains in the box -->
            <input type="number" name="num1" class="numberInput" value="<?php if(isset($_GET['num1'])) echo $_GET['num1']; ?>">
            <input type="number" name="num2" class="numberInput" value="<?php if(isset($_GET['num2'])) echo $_GET['num2']; ?>">
            <input type="number" name="num3" class="numberInput" value="<?php if(isset($_GET['num3'])) echo $_GET['num3']; ?>">
            <input type="number" name="num4" class="numberInput" value="<?php if(isset($_GET['num4'])) echo $_GET['num4']; ?>">
            <input type="number" name="num5" class="numberInput" value="<?php if(isset($_GET['num5'])) echo $_GET['num5']; ?>">
            <input type="number" name="num6" class="numberInput" value="<?php if(isset($_GET['num6'])) echo $_GET['num6']; ?>"><br>
            <p class="buttonNew"> <button type="submit" class="btn btn-primary btn-lg">Generate a number!</button></p>
        </form>
        <form action="index.php" method="get">
            <p>Input your equation:</p>
            <input type="text" name="equation" class="fullEquation">
            <p class="buttonNew"> <button type="button" class="btn btn-primary btn-lg">Submit</button></p>
        </form>
        <?php
            // if there aren't enough numbers, it prompts the user to enter 6 numbers
            if (empty($_GET["num1"]) || empty($_GET["num2"]) || empty($_GET["num3"]) || empty($_GET["num4"]) || empty($_GET["num5"]) || empty($_GET["num6"])) {
                echo "Please input 6 numbers!";
            }
            else {
                $firstArray = reverseArray($_GET["num1"], $_GET["num2"], $_GET["num3"], $_GET["num4"], $_GET["num5"], $_GET["num6"]);
                shuffle($firstArray);
                $output = 0;
                $stringEquation;
                $operator;
                for ($i = 0; $i < 5; $i++) {
                    $operator = chooseOperator(mt_rand(0, 199));
                    if ($i == 0) {
                        $stringEquation = formEquation($firstArray[$i], $operator, (string)$firstArray[$i+1]);
                       // $keywords = preg_split("//", $stringEquation, -1, PREG_SPLIT_NO_EMPTY);
                       // print_r($keywords);
                        $output = evaluateEquation($stringEquation);
                       // echo $stringEquation;
                    }
                    else {
                        $stringEquation = formEquation($output, $operator, $firstArray[$i+1]);
                        $output = evaluateEquation($stringEquation);
                      //  echo $stringEquation;
                    }
                   // echo $stringEquation;
                }
                echo $output;
                if (isset($_GET["equation"])){
                    $userEquation = $_GET["equation"];
                   echo $userEquation;
                }
                
               /* foreach ($firstArray as $item) {
                    echo (string) $item . $operator . "\n";
                }*/
            }
        ?>
    </div>
    </body>
</html>