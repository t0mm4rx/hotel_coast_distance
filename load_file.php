<?php

include_once("is_near_sea.php");

function process_line($line)
{
    $args = explode(",", $line);
    $lat = floatval($args[9]);
    $lon = floatval($args[10]);
    return [
        "lat" => $lat,
        "lon" => $lon,
        "coast" => is_near_coast([$lat, $lon])
    ];
}

$lines = 0;
$res = [];
$count_true = 0;
$time_before = time();

$handle = fopen("data/hotels.csv", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false && $lines < 1000) {
        if ($lines++ > 0)
        {
            print("Line " . ($lines - 1) . "\n");
            $res[] = process_line($line);
            if ($res[sizeof($res) - 1]["coast"] == true)
            {
                print("Near coast !\n");
                $count_true++;
            }
        }
    }
    fclose($handle);
}
else {
    print("Error while reading file...\n");
    return;
}

file_put_contents("result.json", json_encode($res));
print("Total of " . $count_true . " hotels on coastline found in " . (time() - $time_before) . "seconds\n");
