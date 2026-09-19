import json

with open('vendor/composer/installed.json', 'r', encoding='utf-8') as f:
    installed_data = json.load(f)

packages = installed_data.get('packages', [])
versions = {}

for p in packages:
    versions[p['name']] = {
        'pretty_version': p.get('version', '1.0.0'),
        'version': p.get('version_normalized', p.get('version', '1.0.0.0')),
        'reference': p.get('source', {}).get('reference', p.get('dist', {}).get('reference', '')),
        'type': p.get('type', 'library'),
        'install_path': f"__DIR__ . '/../../{p.get('target-dir', '')}'" if p.get('target-dir') else f"__DIR__ . '/../{p.get('name')}'",
        'aliases': p.get('aliases', []),
        'dev_requirement': p.get('name') in installed_data.get('dev-package-names', [])
    }

def format_php(val, indent=2):
    ind = ' ' * indent
    if isinstance(val, dict):
        lines = ['array(']
        for k, v in val.items():
            if k == 'install_path':
                lines.append(f"{ind}    '{k}' => {v},")
            else:
                lines.append(f"{ind}    '{k}' => {format_php(v, indent+4)},")
        lines.append(f"{ind})")
        return '\n'.join(lines)
    elif isinstance(val, list):
        lines = ['array(']
        for item in val:
            lines.append(f"{ind}    {format_php(item, indent+4)},")
        lines.append(f"{ind})")
        return '\n'.join(lines)
    elif isinstance(val, str):
        escaped = val.replace('\\', '\\\\').replace("'", "\\'")
        return f"'{escaped}'"
    elif isinstance(val, bool):
        return 'true' if val else 'false'
    else:
        return str(val)

php_content = f"""<?php return array(
    'root' => array(
        'name' => 'laravel/laravel',
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'reference' => NULL,
        'type' => 'project',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => {format_php(versions, 4)},
);
"""

with open('vendor/composer/installed.php', 'w', encoding='utf-8') as f:
    f.write(php_content)

print('Generated vendor/composer/installed.php cleanly!')
