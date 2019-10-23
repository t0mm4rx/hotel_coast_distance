<?php

const ZOOM_LEVEL = 18;
const PIXELS_THRESHOLD = 1000;

function print_log($x)
{
    print("[" . date("d/m/Y h:i:s") . "] {$x}\n");
}

// Get x/y OSM array from a lat/lon array
function coords_to_tile($coords, $zoom)
{
    $x = floor((($coords[1] + 180) / 360) * pow(2, $zoom));
    $y = floor((1 - log(tan(deg2rad($coords[0])) + 1 / cos(deg2rad($coords[0]))) / pi()) /2 * pow(2, $zoom));
    return [$x, $y];
}

// Download a tile at given coords, with ZOOM_LEVEL zoom
function download_image($coords, $zoom)
{
    $tile = coords_to_tile($coords, $zoom);
    $url = "https://tile.openstreetmap.bzh/oc/{$zoom}/{$tile[0]}/{$tile[1]}.png";
    print_log("Downloading {$url}");
    $img = imagecreatefrompng($url);
    if (!$img)
    {
        print_log("Error while dowloading the tile!");
        return false;
    }
    return $img;
}

function is_pixel_blue($color)
{
    return ($color["blue"] > 210 && $color["red"] < 180 && $color["green"] < 180);
}

function is_sea_on_image($img)
{
    $blue_count = 0;
    for ($x = 0; $x < imagesx($img); $x++)
    {
        for ($y = 0; $y < imagesy($img); $y++)
        {
            $rgb = imagecolorat($img, $x, $y);
            $color = imagecolorsforindex($img, $rgb);
            $blue_count += is_pixel_blue($color);
        }
    }
    return ($blue_count >= PIXELS_THRESHOLD);
}

/* -1 ==> error
** 0 ==> not near coast
** 1 ==> near sea */
function is_near_coast($coords)
{
    $img = download_image($coords, ZOOM_LEVEL);
    if (!$img)
        return -1;
    imagepng($img, "buffer.png");
    return is_sea_on_image($img);
}
