import os
import re

path = 'vendor/composer/autoload_static.php'
with open(path, 'r', encoding='utf-8', errors='ignore') as f:
    content = f.read()

start_idx = content.find('public static $files = array (')
end_idx = content.find(');', start_idx)

if start_idx != -1 and end_idx != -1:
    files_block = content[start_idx:end_idx+2]
    lines = files_block.splitlines()
    new_lines = []
    removed_count = 0
    for line in lines:
        if '=> __DIR__ .' in line:
            m = re.search(r"__DIR__\s*\.\s*'/..'\s*\.\s*'([^']+)'", line)
            if m:
                rel = m.group(1).lstrip('/\\')
                full_path = os.path.normpath(os.path.join('vendor', rel))
                if not os.path.exists(full_path):
                    print('Removing missing file:', full_path)
                    removed_count += 1
                    continue
        new_lines.append(line)
    
    new_files_block = '\n'.join(new_lines)
    content = content[:start_idx] + new_files_block + content[end_idx+2:]
    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)
    print(f'Done. Removed {removed_count} missing files.')
