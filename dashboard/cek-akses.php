<?php
$role = $_SESSION['user']['role'];
$fileAkses = __DIR__.DIRECTORY_SEPARATOR.'akses'.DIRECTORY_SEPARATOR.$role.'.php';

if (!file_exists($fileAkses)) {
    echo "Terjadi kesalahan: File akses tidak ditemukan.";
    exit;
}

$akses = include $fileAkses;
$url = $_SERVER['REQUEST_URI'];
$filename = pathinfo($url, PATHINFO_FILENAME);

if (!in_array($filename, $akses)) {
    header('location: 404.php');
    exit;
}