<?php
$path = 'resources/views/coaching/salary_slips/pdf.blade.php';
$content = file_get_contents($path);
$pos = strpos($content, 'data:image');
if ($pos !== false) {
    echo "Found 'data:image' at offset $pos\n";
    // Find the start of the line
    $lineStart = strrpos(substr($content, 0, $pos), "\n");
    if ($lineStart === false) $lineStart = 0; else $lineStart++;
    
    // Find the end of the line
    $lineEnd = strpos($content, "\n", $pos);
    if ($lineEnd === false) $lineEnd = strlen($content);
    
    $line = substr($content, $lineStart, $lineEnd - $lineStart);
    echo "Line length: " . strlen($line) . "\n";
    echo "Line start (100 chars): " . substr($line, 0, 100) . "\n";
    echo "Line end (100 chars): " . substr($line, -100) . "\n";
    
    // Specifically look for the img tag boundaries
    $imgStart = strrpos(substr($content, 0, $pos), '<img');
    $imgEnd = strpos($content, '>', $pos);
    if ($imgStart !== false && $imgEnd !== false) {
        $tag = substr($content, $imgStart, $imgEnd - $imgStart + 1);
        echo "Tag start: " . substr($tag, 0, 50) . "\n";
        echo "Tag end: " . substr($tag, -50) . "\n";
    }
} else {
    echo "data:image not found\n";
}
?>
