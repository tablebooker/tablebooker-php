<?php
/**
 * Example to fetch restaurant info
 */

// Tablebooker singleton
require(dirname(__FILE__) . '/../lib/Tablebooker.php');


try {
    \Tablebooker\Tablebooker::setAPIKey("PUT-API-KEY-HERE");
    $infoRequest = new RestaurantInfo("0003487");
    $info = \Tablebooker\Restaurant::info($infoRequest);
    echo "<h1>Restaurant $info->name</h1>";
} catch (Exception $e) {
    echo "<h1>Call failed</h1>";
    echo "<p>$e->getMessage()</p>";
}
