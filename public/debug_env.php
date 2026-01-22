<?php
echo "<h1>PHP Debug Info</h1>";
echo "<strong>PHP Version:</strong> " . phpversion() . "<br>";
echo "<strong>Loaded php.ini:</strong> " . php_ini_loaded_file() . "<br>";
echo "<strong>PDO Drivers:</strong> " . implode(', ', PDO::getAvailableDrivers()) . "<br>";
echo "<strong>Extension Dir:</strong> " . ini_get('extension_dir') . "<br>";
echo "<strong>Current Dir:</strong> " . getcwd() . "<br>";

try {
    $path = __DIR__ . '/../database/database.sqlite';
    echo "<strong>Target DB Path:</strong> " . realpath($path) . "<br>";
    $db = new PDO('sqlite:' . $path);
    echo "<strong style='color:green'>Database Connection: SUCCESS</strong><br>";
} catch (Exception $e) {
    echo "<strong style='color:red'>Database Connection: FAILED</strong> - " . $e->getMessage() . "<br>";
}
?>
