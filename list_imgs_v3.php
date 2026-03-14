<?php
$path = 'resources/views/coaching/salary_slips/pdf.blade.php';
$content = file_get_contents($path);
preg_match_all('/<img[^>]+>/i', $content, $matches, PREG_OFFSET_CAPTURE);

$output = "Total images found: " . count($matches[0]) . "\n";
foreach ($matches[0] as $i => $match) {
    $tag = $match[0];
    $offset = $match[1];
    $output .= "--- Tag #$i at offset $offset ---\n";
    $output .= "Length: " . strlen($tag) . "\n";
    $output .= "Start: " . substr($tag, 0, 200) . "\n";
    $output .= "End: " . substr($tag, -200) . "\n";
    $output .= "\n";
}
file_put_contents('img_tags_debug.txt', $output);
?>
