<?php

include_once("script.php");

$data = json_decode(file_get_contents("./data/hotels_tests.json"));

foreach ($data as $point) {
    $guess = is_near_coast([$point->lat, $point->lon]);
    print("Guess: " . ($guess == 1 ? "yes" : "no") . "\n");
    print("Real distance: " . $point->distance . "\n");
}
