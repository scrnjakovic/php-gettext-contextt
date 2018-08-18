# php-gettext-context
Implementation of missing gettext functions in PHP to enable support for contextual translations and lookups as well as extending the functionality of lookups to provide placeholders replacements

While the main purpose behind this 'lib' is to implement missing functions related to contextual lookups, it does more than that. It adds nice and short macros and introduces support for named placeholders.

There is also small and simple script which aids in generation of **POT** files.

## The problem
While native implementation of gettext exposes **12** lookup functions (actually, most if not all of them are macros for `dcgettext` and `dcngettext`) PHP implements only **6**:

`gettext`, `dgettext`, `dcgettext`
and their plural versions: `ngettext`, `dngettext` and `dcngettext`.

The other 6 missing functions are:

`pgettext`, `dpgettext`, `dcpgettext`
and their plural versions: `npgettext`, `dnpgettext` and `dcnpgettext`.

These 6 missing functions are all used to perform lookups based on [contexts](https://www.gnu.org/software/gettext/manual/html_node/Contexts.html) (as per gettext docs, p stands for "particular" or "special").

## Functions
Function names are inspired by the gettext macros, although bit changed:
all functions start with `__` instead of `_` to avoid conflicts with `_` and `_n` macros.

| native gettext   | PHP gettext      | gettext-context | What it does                         |
| ---------------- | ---------------- | --------------- | ------------------------------------ |
| `gettext()`      | `gettext()`      | `__()`          | translates string                    |
| `dgettext()`     | `dgettext()`     | `__d()`         | translates string and overrides the domain for the curent lookup |
| `dcgettext()`    | `dcgettext()`    | `__dc()`        | same as above plus it overrides the category |
| `ngettext()`     | `ngettext()`     | `__n()`         | translates plural string |
| `dngettext()`    | `dngettext()`    | `__dn()`        | translates plural string and overrides the domain for the current lookup |
| `dcngettext()`   | `dcngettext()`   | `__dcn()`       | same as above plus it overrides the category |
| `pgettext()`     | `NotImplemented` | `__p()`         | translates string for the given context
| `dpgettext()`    | `NotImplemented` | `__dp()`        | translates string for the given context and overrides the domain for the current lookup |
| `dcpgettext()`   | `NotImplemented` | `__dcp()`       | same as above plus it overrides the category |
| `npgettext()`    | `NotImplemented` | `__np()`        | translates plural string for the given context |
| `dnpgettext()`   | `NotImplemented` | `__dnp()`       | translates plural string for the given context and overrides the domain for the current lookup |
| `dcnpgettext()`  | `NotImplemented` | `__dcnp()`      | same as above plus it overrides the category |

All functions in the table have the same signatures as their horizontal counterparts, with the exception of gettext-context functions accepting an additional optional parameter: an associative array where key/value pairs represent placeholder name and it's value.

## How to use
Include `gettext.context.php` file and use functions starting with `__` instead of those ending with `gettext`, i.e.
```php
// include the lib
requre __DIR__ . '/gettext.context.php';

// instead of gettext('string') use:
__('string');

// instead of ngettext('string') use:
__n('string', 'plural string', $count);

// instead of pgettext('context', 'string') use:
__p('context', 'string');

// instead of npgettext('context', 'string', 'plural string', $count) use:
__np('context', 'string', 'plural string', $count);
```
No need to wrap the calls in `sprintf` anymore
```php
$placeholders = [
    'name' => 'свете'
];

echo __('Hello, %name%!', $placeholders);
// Здраво, свете! or Hello, world! in Serbian
```
```php
$count = 3;

$placeholders = [
    'numOfCookies' = $count
]

echo __n('One cookie remaining', '%numOfCookies% cookies remaining', $count, $placeholders);
// Остало је 3 колача
```

## Generate POT files
1. Navigate to the folder where `xgetcontext.sh` is located at
2. Make sure `xgetcontext.sh` can be executed with `chmod +x xgetcontext.sh`
3. Execute the script with the arguments you would normally pass to `xgettext`, for an example:
```
./xgetcontext.sh -c -o messages.pot /path/to/my/script.php
```
