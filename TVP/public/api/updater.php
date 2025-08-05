<?php
// DEBUGGED VERSION
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CONFIG
$files_dir = "/var/www/TVP-Ravenor.Web/storage/app/public/client/TVP-Ravenor-Client-Encryption";
$cache_dir = "/var/www/TVP-Ravenor.Web/storage/app/public";
$files_url = "https://ravenor.online/api/client/TVP-Ravenor-Client-Encryption";

$files_and_dirs = array("init.lua", "data", "modules", "layouts", "mods");
$checksum_file = "checksums.txt";
$checksum_update_interval = 60; // seconds

$binaries = array(
    "WIN32-WGL" => "otclient_gl.bin",
    "WIN32-EGL" => "otclient_dx.bin",
    "WIN32-WGL-GCC" => "",
    "WIN32-EGL-GCC" => "",
    "X11-GLX" => "",
    "X11-EGL" => "",
    "ANDROID-EGL" => "", // we can't update android binary
    "ANDROID64-EGL" => "" // we can't update android binary
);

// ERROR HANDLER
function sendError($message) {
    header('Content-Type: application/json');
    echo json_encode(["error" => $message]);
    exit;
}

// READ JSON INPUT SAFELY
$input = file_get_contents("php://input");
if (!$input) {
    sendError("No input received.");
}

$data = json_decode($input);
if (!$data) {
    sendError("Invalid JSON format.");
}

// EXTRACT FIELDS SAFELY
$version = isset($data->version) ? $data->version : 0;
$build = isset($data->build) ? $data->build : "";
$os = isset($data->os) ? $data->os : "unknown";
$platform = isset($data->platform) ? $data->platform : "";
$args = isset($data->args) ? $data->args : null;
$binary = isset($binaries[$platform]) ? $binaries[$platform] : "";

// INIT CACHE
$cache = null;
$cache_file = $cache_dir . DIRECTORY_SEPARATOR . $checksum_file;

// USE CACHE IF FRESH
if (file_exists($cache_file) && (filemtime($cache_file) + $checksum_update_interval > time())) {
    $cache = json_decode(file_get_contents($cache_file), true);
}

// IF NO CACHE, GENERATE IT
if (!$cache) {
    $dir = realpath($files_dir);
    if (!$dir || !is_dir($dir)) {
        sendError("Invalid files directory.");
    }

    try {
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
        $cache = array(); 

        foreach ($rii as $file) {
            if (!$file->isFile()) continue;

            $fullPath = $file->getPathname();
            $relativePath = str_replace($dir, '', $fullPath);
            $relativePath = str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);
            $relativePath = ltrim($relativePath, '/');

            $cache[$relativePath] = hash_file("crc32b", $fullPath);
        }

        // Save cache
        file_put_contents($cache_file . ".tmp", json_encode($cache));
        rename($cache_file . ".tmp", $cache_file);
    } catch (Exception $e) {
        sendError("Error while generating checksums: " . $e->getMessage());
    }
}

// BUILD RESPONSE
$ret = array(
    "url" => $files_url,
    "files" => array(),
    "keepFiles" => false
);

// SELECT FILES TO SYNC
foreach ($cache as $file => $checksum) {
    $base = explode("/", $file)[0]; 

    if (in_array($base, $files_and_dirs)) {
        $ret["files"][$file] = $checksum;
    }

    if ($base === $binary && !empty($binary)) {
        $ret["binary"] = array("file" => $file, "checksum" => $checksum);
    }
}

// SEND JSON RESPONSE
header('Content-Type: application/json');
echo json_encode($ret, JSON_PRETTY_PRINT);
?>
