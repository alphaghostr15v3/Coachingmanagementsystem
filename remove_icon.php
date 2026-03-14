<?php
$path = 'c:\\xampp\\htdocs\\Coachingmanagementsystem\\resources\\views\\coaching\\salary_slips\\pdf.blade.php';

if (!file_exists($path)) {
    echo "File not found: $path\n";
    exit(1);
}

$content = file_get_contents($path);

// Even simpler pattern: target the img tag itself based on its alt text
// Pattern looks for <img ... alt="Signature Icon">
$pattern = '/<img\s+src="data:image\/png;base64,[^"]+"\s+alt="Signature Icon">/';
$replacement = '';

$new_content = preg_replace($pattern, $replacement, $content);

if ($new_content !== null && $new_content !== $content) {
    file_put_contents($path, $new_content);
    echo "REPLACED\n";
} else {
    echo "NOT_FOUND\n";
    // Debug: find where "Signature Icon" is
    if (strpos($content, 'alt="Signature Icon"') !== false) {
        echo "Found alt text at position " . strpos($content, 'alt="Signature Icon"') . "\n";
        // Extract surrounding text for debug
        echo "Surrounding text: " . substr($content, strpos($content, 'alt="Signature Icon"') - 100, 200) . "\n";
    } else {
        echo "alt text NOT found at all\n";
    }
}
?>
