<!-- Functions -->


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
            // Avoiding equation going below 0
            if (($matches[0] - $matches[2]) < 0) {
                $operator = chooseOperator(mt_rand(0, 199));
                return evaluateEquation(formEquation($matches[0], $operator, $matches[2]));
            }
            return $matches[0] - $matches[2];
        case '*':
            return $matches[0] * $matches[2];
        case '/':
            // Avoiding equation going below returning a float
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
function calculateUserEquation($equation) {
    return eval('return ' . $equation . ';');
}
function generateArray($num1, $num2, $num3, $num4, $num5, $num6) {
    $firstArray = reverseArray($_GET["num1"], $_GET["num2"], $_GET["num3"], $_GET["num4"], $_GET["num5"], $_GET["num6"]);
    shuffle($firstArray);
    return $firstArray;
}
function generateOutput($firstArray){
    $output = 0;
    $stringEquation;
    $operator;
    for ($i = 0; $i < 5; $i++) {
        $operator = chooseOperator(mt_rand(0, 199));
        if ($i == 0) {
            $stringEquation = formEquation($firstArray[$i], $operator, (string)$firstArray[$i+1]);
        // $keywords = preg_split("//", $stringEquation, -1, PREG_SPLIT_NO_EMPTY);
            //print_r($stringEquation);
            $output = evaluateEquation($stringEquation);
        // echo $stringEquation;
        }
        else {
            $stringEquation = formEquation($output, $operator, $firstArray[$i+1]);
            $output = evaluateEquation($stringEquation);
        //  echo $stringEquation;
        }
    }
    return $output;
}
function inOriginalSet($str, $originalArray) {
    // have to convert to 1d array
    preg_match_all('!\d+!', $str, $matches);
    $newMatches = convert2DInto1D($matches);
    if (!array_diff($newMatches, $originalArray)) {
        return true;
    }
    return false;
}
function convert2DInto1D($inputArray) {
    $outputArray = array();
    for ($i = 0; $i < count($inputArray); $i++) {
      for ($j = 0; $j < count($inputArray[$i]); $j++) {
        $outputArray[] = $inputArray[$i][$j];
      }
    }
    return $outputArray;
}   
?>

<!-- HTML Code -->
<?php
    // if there aren't enough numbers, it prompts the user to enter 6 numbers
    if (empty($_GET["num1"]) && empty($_GET["num2"]) && empty($_GET["num3"]) && empty($_GET["num4"]) && empty($_GET["num5"]) && empty($_GET["num6"])) {
        $isValid = false;
    }
    else if (empty($_GET["num1"]) || empty($_GET["num2"]) || empty($_GET["num3"]) || empty($_GET["num4"]) || empty($_GET["num5"]) || empty($_GET["num6"])) {
        $isValid = false;
        $result = "Please input 6 numbers!";
    }
    else {
        $isValid = true;
        $num1 = $_GET["num1"];
        $num2 = $_GET["num2"];
        $num3 = $_GET["num3"];
        $num4 = $_GET["num4"];
        $num5 = $_GET["num5"];
        $num6 = $_GET["num6"];
        $firstArray = generateArray($num1, $num2, $num3, $num4, $num5, $num6);
        if (!empty($_GET["calculatedOutput"])) {
            $output = $_GET["calculatedOutput"];
        }
        else {
            $output = generateOutput($firstArray);
        }   
        if (isset($_GET["equation"])){
            $userStringEquation = $_GET["equation"];
            if (preg_match('/^([0-9]+[\+\-\*\/])*[0-9]+$/', $userStringEquation)) {
            	if (inOriginalSet($userStringEquation, $firstArray) == true) {
               		$userIntEquation = calculateUserEquation($userStringEquation);
                	$outcome;
                	if ($userIntEquation == $output) {
                   	 	$result = "Good Job";
                	}
                	else if (($userIntEquation != $output) && (!empty($userIntEquation))){
                    		$result = "Incorrect Answer";
                	}
            	}  
            	else {
                	$result = "Please input an equation that uses your numbers!";
            	}
	    }
	   else if (empty($_GET["equation"])){
           	$result = "";
	  }
	   else {
		 $result = "Please input a valid equation!";
		}
        }
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
        <script>
        </script>
    </head>
    <body>
    <div class="content">
        <form action="index.php" method="get">
            <h1>Welcome to Countdown</h1>
            <a href="index.php"><h2>Press here to restart</h2></a>
            <p> Please choose 6 numbers</p>
            <!-- User inputs the numbers, after submitting, the value remains in the box -->
            <input type="number" name="num1" class="numberInput" value="<?php if(isset($_GET['num1'])) echo $_GET['num1']; ?>">
            <input type="number" name="num2" class="numberInput" value="<?php if(isset($_GET['num2'])) echo $_GET['num2']; ?>">
            <input type="number" name="num3" class="numberInput" value="<?php if(isset($_GET['num3'])) echo $_GET['num3']; ?>">
            <input type="number" name="num4" class="numberInput" value="<?php if(isset($_GET['num4'])) echo $_GET['num4']; ?>">
            <input type="number" name="num5" class="numberInput" value="<?php if(isset($_GET['num5'])) echo $_GET['num5']; ?>">
            <input type="number" name="num6" class="numberInput" value="<?php if(isset($_GET['num6'])) echo $_GET['num6']; ?>"><br>
            <p class="buttonNew"> <button type="submit" class="btn btn-primary btn-lg">Generate a number!</button></p>
            <p>Get to this number:</p>
            <input type="text" name="calculatedOutput" value="<?php if($isValid == true) echo $output;?>" readonly/>
            <p>Input your equation:</p>
            <input type="text" name="equation" class="fullEquation" value="<?php if(isset($_GET['equation'])) echo $_GET['equation']; ?>">
            <p class="buttonNew"> <button type="submit" class="btn btn-primary btn-lg">Submit</button></p>
            <p><?php if (isset($result)) echo $result; ?></p>
        </form>
        
    </div>
    </body>
</html>
