<?php

include_once("is_near_sea.php");

$x = 1.0000;
$y = 1.0000;

for ($i = 0; $i < 1000; $i++) {
    $guess = is_near_coast([$x, $y]);
    $x += 0.001;
    $y += 0.001;
    print("Guess " . $i . ": " . ($guess == 1 ? "yes" : "no") . "\n");
}
//12:49:49
