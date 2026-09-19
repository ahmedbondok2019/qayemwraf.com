import json

with open('vendor/composer/installed.json', 'r', encoding='utf-8') as f:
    data = json.load(f)

packages = data.get('packages', [])
discovered = {}

for p in packages:
    name = p.get('name')
    extra = p.get('extra', {}).get('laravel', {})
    providers = extra.get('providers', [])
    aliases = extra.get('aliases', [])
    dont_discover = extra.get('dont-discover', [])
    
    if providers or aliases:
        discovered[name] = {
            'providers': providers,
            'aliases': aliases
        }

# Write PHP export to bootstrap/cache/packages.php
php_content = "<?php return " + repr(discovered).replace("'", '"').replace('True', 'true').replace('False', 'false') + ";\n"

# Convert Python dict representation to valid PHP array syntax
import pprint
def to_php_array(val, indent=0):
    ind = "  " * indent
    if isinstance(val, dict):
        items = []
        for k, v in val.items():
            items.append(f'{ind}  "{k}" => ' + to_php_array(v, indent + 1).lstrip())
        return "array (\n" + ",\n".join(items) + f"\n{ind})"
    elif isinstance(val, list):
        items = []
        for v in val:
            items.append(f'{ind}  ' + to_php_array(v, indent + 1).lstrip())
        return "array (\n" + ",\n".join(items) + f"\n{ind})"
    elif isinstance(val, str):
        # Escape backslashes for PHP string
        escaped = val.replace('\\', '\\\\')
        return f"'{escaped}'"
    elif isinstance(val, bool):
        return 'true' if val else 'false'
    else:
        return str(val)

php_output = "<?php\n\n// packages.php @generated\n\nreturn " + to_php_array(discovered) + ";\n"

with open('bootstrap/cache/packages.php', 'w', encoding='utf-8') as f:
    f.write(php_output)

print('Generated bootstrap/cache/packages.php with', len(discovered), 'packages.')
