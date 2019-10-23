# Distance point - cote

## Projet
Ce script detecte si un point (lat, lon) est a moins de 30 metres d'une cote maritime.

La fonction telecharge une tuile OpenStreetMap aux coordonnees donnees, puis calcul le nombre de pixels bleus. Si ce nombre depasse un certain seuil (PIXELS_THRESHOLD), alors il renvoie true.

## Utilisation
```php
include_once("is_near_sea.php");
is_near_sea([49.339975, -0.621558]);
```
