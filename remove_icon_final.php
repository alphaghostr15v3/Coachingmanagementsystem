<?php
$path = 'c:\\xampp\\htdocs\\Coachingmanagementsystem\\resources\\views\\coaching\\salary_slips\\pdf.blade.php';

if (!file_exists($path)) {
    echo "File not found: $path\n";
    exit(1);
}

$content = file_get_contents($path);

// The start of the tag we want to remove
$targetStart = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAoAAAAKACAIAAACDr150';
// The end of the tag we want to remove
$targetEnd = 'style="height: 30px; vertical-align: middle; margin-right: 10px;">';

$startPos = strpos($content, $targetStart);
if ($startPos !== false) {
    $endPos = strpos($content, $targetEnd, $startPos);
    if ($endPos !== false) {
        $actualEnd = $endPos + strlen($targetEnd);
        $before = substr($content, 0, $startPos);
        $after = substr($content, $actualEnd);
        
        $newContent = $before . $after;
        
        file_put_contents($path, $newContent);
        echo "REPLACED_SUCCESSFULLY\n";
    } else {
        echo "END_NOT_FOUND\n";
    }
} else {
    echo "START_NOT_FOUND\n";
}
?>
