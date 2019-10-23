var sec = x => 1 / Math.cos(x);

function coords_to_tile(coords, zoom)
{
    let lat = coords[0];
    let lon = coords[1];
    let n = Math.pow(2, zoom);
    let x = n * ((lon + 180) / 360);
    let y = n * (1 - (Math.log(Math.tan(lat) + sec(lat)) / Math.PI)) / 2;
    return [Math.round(x), Math.round(y)];
}

const URL = "https://tile.openstreetmap.bzh/oc/20/525385/356666.png";

let zoom = 1;
let lat = 49.339975;
let lon = -0.621558;
let tile = coords_to_tile([lat, lon], zoom);
console.log(`https://tile.openstreetmap.bzh/oc/${zoom}/${tile[0]}/${tile[1]}.png`);
