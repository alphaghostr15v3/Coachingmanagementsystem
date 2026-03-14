<?php
$path = 'resources/views/coaching/salary_slips/pdf.blade.php';
$lines = file($path);
if (isset($lines[260])) { // Line 261 (0-indexed)
    $line = $lines[260];
    echo "Line 261 start: " . substr($line, 0, 100) . "\n";
    echo "Line 261 end: " . substr($line, -100) . "\n";
    echo "Line 261 length: " . strlen($line) . "\n";
} else {
    echo "Line 261 not found\n";
    // Search for img tag
    foreach ($lines as $i => $l) {
        if (strpos($l, '<img') !== false && strpos($l, 'data:image') !== false) {
            echo "Found img tag at line " . ($i + 1) . "\n";
            echo "Start: " . substr($l, 0, 100) . "\n";
            echo "End: " . substr($l, -100) . "\n";
        }
    }
}
?>
