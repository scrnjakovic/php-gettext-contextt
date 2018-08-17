# php-gettext-context
Implementation of missing gettext functions in PHP to enable support for contextual translations and lookups as well as extending the functionality of lookups to provide placeholders replacements

# Generate POT files
1. Navigate to the folder where xgetcontext.sh is located at
2. Make sure `xgetcontext.sh` can be executed with `chmod +x xgetcontext.sh`
3. Execute the script with the arguments you would normally pass to `xgettext`, for an example:
```
./xgetcontext.sh -c -o messages.pot /path/to/my/script.php
```
