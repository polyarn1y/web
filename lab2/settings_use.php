<?php
spl_autoload_register();

use Singleton\Settings;

Settings::get()->items_per_page = 20;
Settings::get()->site_name = "MySite";
Settings::get()->maintenance = true;

echo "Items per page: " . Settings::get()->items_per_page . "<br>";
echo "Site name: " . Settings::get()->site_name . "<br>";
echo "Maintenance mode: " . (Settings::get()->maintenance ? 'ON' : 'OFF') . "<br>";
