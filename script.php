<?php
error_reporting(0);

const ZOOM_LEVEL = 19;
const IMAGE_SIZE = 256;

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

    $img_content = file_get_contents($url);
    if ($img_content == "")
    {
        print_log("Error while dowloading the tile!");
        return false;
    }
    // Uncomment to save the image downloaded 
    // file_put_contents("buffer.png", $img_content);
    return imagecreatefromstring($img_content);
}

function is_sea_on_image($img)
{
    var_dump(imagecolorat($img, 0, 0));
}

/* -1 ==> error
** 0 ==> not near coast
** 1 ==> near sea */
function is_near_coast($coords)
{
    $img = download_image($coords, ZOOM_LEVEL);
    if (!$img)
        return -1;
    is_sea_on_image($img);
}

//$coords = [49.339975, -0.621558];
$coords = [49.340361, -0.621746];
print(is_near_coast($coords));
