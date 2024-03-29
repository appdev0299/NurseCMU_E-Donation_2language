<?php
session_start();
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = "th";
}

if (isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang'])) {
    if ($_GET['lang'] == "en" || $_GET['lang'] == "th") {
        $_SESSION['lang'] = $_GET['lang'];
    }
}
$langFile = "languages/" . $_SESSION['lang'] . ".php";
if (file_exists($langFile)) {
    require_once $langFile;
} else {
    echo "Language file not found!";
    exit;
}
