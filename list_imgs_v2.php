<?php
$path = 'resources/views/coaching/salary_slips/pdf.blade.php';
$content = file_get_contents($path);
preg_match_all('/<img[^>]+>/i', $content, $matches, PREG_OFFSET_CAPTURE);

echo "Total images found: " . count($matches[0]) . "\n";
foreach ($matches[0] as $i => $match) {
    $tag = $match[0];
    $offset = $match[1];
    echo "--- Tag #$i at offset $offset ---\n";
    echo "Length: " . strlen($tag) . "\n";
    echo "Start: " . substr($tag, 0, 200) . "\n";
    echo "End: " . substr($tag, -200) . "\n";
    echo "\n";
}
?>
