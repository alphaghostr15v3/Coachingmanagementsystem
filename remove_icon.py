import os
import re

path = r'c:\xampp\htdocs\Coachingmanagementsystem\resources\views\coaching\salary_slips\pdf.blade.php'
if not os.path.exists(path):
    print(f"File not found: {path}")
    exit(1)

with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

# Pattern to match the h2 and the img with the specific alt text
# Using re.DOTALL just in case it spans multiple lines, though it probably doesn't
pattern = r'<h2><img src="data:image/png;base64,[^"]+" alt="Signature Icon"> </h2>'
replacement = '<h2></h2>'

new_content = re.sub(pattern, replacement, content)

if new_content != content:
    with open(path, 'w', encoding='utf-8', newline='') as f:
        f.write(new_content)
    print("REPLACED")
else:
    # Try a more flexible pattern in case of whitespace differences
    pattern_alt = r'<h2>\s*<img src="data:image/png;base64,[^"]+" alt="Signature Icon">\s*</h2>'
    new_content_alt = re.sub(pattern_alt, replacement, content)
    if new_content_alt != content:
        with open(path, 'w', encoding='utf-8', newline='') as f:
            f.write(new_content_alt)
        print("REPLACED_ALT")
    else:
        print("NOT_FOUND")
