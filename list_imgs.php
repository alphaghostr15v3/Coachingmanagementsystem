<?php
$path = 'resources/views/coaching/salary_slips/pdf.blade.php';
$content = file_get_contents($path);
preg_match_all('/<img[^>]+>/i', $content, $matches, PREG_OFFSET_CAPTURE);

foreach ($matches[0] as $match) {
    $tag = $match[0];
    $offset = $match[1];
    echo "Found tag at offset $offset:\n";
    echo "Start: " . substr($tag, 0, 100) . "\n";
    echo "End: " . substr($tag, -100) . "\n";
    echo "-------------------\n";
}
?>
