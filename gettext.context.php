<?php
/**
 * Implementation of missing gettext functions in PHP to enable support for contextual translations and lookups
 * as well as extending the functionality of lookups to provide placeholders replacements
 *
 * @author Stefan Crnjaković <stefan@hotmail.rs>
 * @copyright 2018 Stefan Crnjaković
 * @license MIT
 * @version 1.0.0
 * @link https://github.com/scrnjakovic/php-gettext-context#generate-pot-files For more information on how to generate .POT files
 * @link http://php.net/manual/en/book.gettext.php#89975 Comment on the PHP website
 * @link http://git.savannah.gnu.org/cgit/gettext.git/tree/gnulib-local/lib/gettext.h gettext header file
 */

/**
 * This function performs singular message lookup and optionally replaces placeholders with supplied values
 *
 * @param string  $msgId        Message id
 * @param array   $placeholders Associative array where key/value pairs represent a placeholder and it's replacement
 * i.e. passing ['world' => 'Earth'] would make function look for %world% placeholder and replace it with 'Earth'
 * @return string
 */
function __(string $msgId, array $placeholders = null)
{
    $translation = gettext($msgId);
    
    return __replace($translation, $placeholders);
}

/**
 * This function performs singular message lookup overriding the current domain and optionally replacing placeholders
 * with supplied values
 *
 * @param string  $domain       Domain to use for this lookup
 * @param string  $msgId        Message id
 * @param array   $placeholders Associative array where key/value pairs represent a placeholder and it's replacement
 * i.e. passing ['world' => 'Earth'] would make function look for %world% placeholder and replace it with 'Earth'
 * @return string
 */
function __d(string $domain, string $msgId, array $placeholders = null)
{
    $translation = dgettext($domain, $msgId);

    return __replace($translation, $placeholers);
}

/**
 * This function performs singular message lookup overriding the current domain and category and optionally replacing
 * placeholders with supplied values
 *
 * @param string  $domain       Domain to use for this lookup
 * @param string  $msgId        Message id
 * @param string  $msgIdPlural  Plural message id
 * @param integer $n            Count
 * @param integer $category     Category to use for this lookup
 * @param array   $placeholders Associative array where key/value pairs represent a placeholder and it's replacement
 * i.e. passing ['world' => 'Earth'] would make function look for %world% placeholder and replace it with 'Earth'
 * @return string
 */
function __dc(string $domain, string $msgId, int $category, array $placeholders = null)
{
    $translation = dcgettext($domain, $msgId, $category);

    return __replace($translation, $placeholders);
}

/**
 * This function performs contextual singular message lookup and optionally replaces placeholders with supplied values
 *
 * @param string  $msgCtxt      Context
 * @param string  $msgId        Message id
 * @param array   $placeholders Associative array where key/value pairs represent a placeholder and it's replacement
 * i.e. passing ['world' => 'Earth'] would make function look for %world% placeholder and replace it with 'Earth'
 * @return string
 */
function __p(string $msgCtxt, string $msgId, array $placeholders = null) : string
{
    $ctxtString = "{$msgCtxt}\004{$msgId}";
    
    // we can't implement it like in gettext.h because of PHP's implementation of dcgettext
    // in which dcgettext requires a domain, whereas in native gcgettext domain can be null
    // so we go with gettext instead
    $translation = gettext($ctxtString);
    
    if ($translation == $ctxtString) {
        return __replace($msgId, $placeholders);
    }
    
    return __replace($translation, $placeholders);
}

/**
 * This function performs contextual singular message lookup overriding the current domain and optionally replacing
 * placeholders with supplied values
 *
 * @param string  $domain       Domain to use for this lookup
 * @param string  $msgCtxt      Context
 * @param string  $msgId        Message id
 * @param array   $placeholders Associative array where key/value pairs represent a placeholder and it's replacement
 * i.e. passing ['world' => 'Earth'] would make function look for %world% placeholder and replace it with 'Earth'
 * @return string
 */
function __dp(string $domain, string $msgCtxt, string $msgId, array $placeholders = null) : string
{
    $ctxtString = "{$msgCtxt}\004{$msgId}";
    
    // we can't implement it like in gettext.h because of PHP's implementation of dcgettext
    // in which dcgettext requires a domain, whereas in native gcgettext domain can be null
    // so we go with dgettext instead
    $translation = dgettext($domain, $ctxtString);
    
    if ($translation == $ctxtString) {
        return __replace($msgId, $placeholders);
    }
    
    return __replace($translation, $placeholders);
}

/**
 * This function performs contextual singular message lookup overriding the current domain and category and optionally
 * replacing placeholders with supplied values
 *
 * @param string  $domain       Domain to use for this lookup
 * @param string  $msgCtxt      Context
 * @param string  $msgId        Message id
 * @param integer $category     Category to use for this lookup
 * @param array   $placeholders Associative array where key/value pairs represent a placeholder and it's replacement
 * i.e. passing ['world' => 'Earth'] would make function look for %world% placeholder and replace it with 'Earth'
 * @return string
 */
function __dcp(string $domain, string $msgCtxt, string $msgId, int $category, array $placeholders = null) : string
{
    $ctxtString = "{$msgCtxt}\004{$msgId}";

    $translation = dcgettext($domain, $ctxtString, $category);
    
    if ($translation == $ctxtString) {
        return __replace($msgId, $placeholders);
    }
    
    return __replace($translation, $placeholders);
}

/**
 * This function performs plural message lookup and optionally replaces placeholders with supplied values
 *
 * @param string  $msgId        Message id
 * @param string  $msgIdPlural  Plural message id
 * @param integer $n            Count
 * @param array   $placeholders Associative array where key/value pairs represent a placeholder and it's replacement
 * i.e. passing ['world' => 'Earth'] would make function look for %world% placeholder and replace it with 'Earth'
 * @return string
 */
function __n(string $msgId, string $msgIdPlural, int $n, array $placeholders = null) : string
{
    $translation = ngettext($msgId, $msgIdPlural, $n);

    return __replace($translation, $placeholders);
}

/**
 * This function performs plural message lookup overriding the current domain and optionally replacing placeholders
 * with supplied values
 *
 * @param string  $domain       Domain to use for this lookup
 * @param string  $msgId        Message id
 * @param string  $msgIdPlural  Plural message id
 * @param integer $n            Count
 * @param array   $placeholders Associative array where key/value pairs represent a placeholder and it's replacement
 * i.e. passing ['world' => 'Earth'] would make function look for %world% placeholder and replace it with 'Earth'
 * @return string
 */
function __dn(string $domain, string $msgId, string $msgIdPlural, int $n, array $placeholders = null) : string
{
    $translation = dngettext($domain, $msgId, $msgIdPlural, $n);

    return __replace($translation, $placeholders);
}

/**
 * This function performs plural message lookup overriding the current domain and category and optionally replacing
 * placeholders with supplied values
 *
 * @param string  $domain       Domain to use for this lookup
 * @param string  $msgId        Message id
 * @param string  $msgIdPlural  Plural message id
 * @param integer $n            Count
 * @param integer $category     Category to use for this lookup
 * @param array   $placeholders Associative array where key/value pairs represent a placeholder and it's replacement
 * i.e. passing ['world' => 'Earth'] would make function look for %world% placeholder and replace it with 'Earth'
 * @return string
 */
function __dcn(
    string $domain,
    string $msgId,
    string $msgIdPlural,
    int $n,
    int $category,
    array $placeholders = null
) : string {
    $translation = dcngettext($domain, $msgId, $msgIdPlural, $n, $category);

    return __replace($translation, $placeholders);
}

/**
 * This function performs contextual plural message looku and optionally replaces placeholders with supplied values
 *
 * @param string  $msgCtxt      Context
 * @param string  $msgId        Message id
 * @param string  $msgIdPlural  Plural message id
 * @param integer $n            Count
 * @param array   $placeholders Associative array where key/value pairs represent a placeholder and it's replacement
 * i.e. passing ['world' => 'Earth'] would make function look for %world% placeholder and replace it with 'Earth'
 * @return string
 */
function __np(string $msgCtxt, string $msgId, string $msgIdPlural, int $n, array $placeholders = null) : string
{
    $ctxtString = "{$msgCtxt}\004{$msgId}";

    // we can't implement it like in gettext.h because of PHP's implementation of dcngettext
    // in which dcngettext requires a domain, whereas in native dcngettext domain can be null
    // so we go with ngettext instead
    $translation = ngettext($ctxtString, $msgIdPlural, $n);

    if ($translation == $ctxtString || $translation == $msgIdPlural) {
        $translation = ($n == 1 ? $msgId : $msgIdPlural);
    }

    return __replace($translation, $placeholders);
}

/**
 * This function performs contextual plural message lookup overriding the current domain and optionally replacing
 * placeholders with supplied values
 *
 * @param string  $domain       Domain to use for this lookup
 * @param string  $msgCtxt      Context
 * @param string  $msgId        Message id
 * @param string  $msgIdPlural  Plural message id
 * @param integer $n            Count
 * @param array   $placeholders Associative array where key/value pairs represent a placeholder and it's replacement
 * i.e. passing ['world' => 'Earth'] would make function look for %world% placeholder and replace it with 'Earth'
 * @return string
 */
function __dnp(
    string $domain,
    string $msgCtxt,
    string $msgId,
    string $msgIdPlural,
    int $n,
    array $placeholders = null
) : string {
    $ctxtString = "{$msgCtxt}\004{$msgId}";

    // we can't implement it like in gettext.h because of PHP's implementation of dcngettext
    // in which dcngettext requires a domain, whereas in native dcngettext domain can be null
    // so we go with dngettext instead
    $translation = dngettext($domain, $ctxtString, $msgIdPlural, $n);

    if ($translation == $ctxtString || $translation == $msgIdPlural) {
        $translation = ($n == 1 ? $msgId : $msgIdPlural);
    }

    return __replace($translation, $placeholders);
}

/**
 * This function performs contextual plural message lookup overriding the current domain and category and optionally
 * replacing placeholders with supplied values
 *
 * @param string  $domain       Domain to use for this lookup
 * @param string  $msgCtxt      Context
 * @param string  $msgId        Message id
 * @param string  $msgIdPlural  Plural message id
 * @param integer $n            Count
 * @param integer $category     Category to use for this lookup
 * @param array   $placeholders Associative array where key/value pairs represent a placeholder and it's replacement.
 * i.e. passing ['world' => 'Earth'] would make function look for %world% placeholder and replace it with 'Earth'
 * @return string
 */
function __dcnp(
    string $domain,
    string $msgCtxt,
    string $msgId,
    string $msgIdPlural,
    int $n,
    int $category,
    array $placeholders = null
) : string {
    $ctxtString  = "{$msgCtxt}\004{$msgId}";
    $translation = dcngettext($domain, $ctxtString, $msgIdPlural, $n, $category);

    if ($translation == $ctxtString || $translation == $msgIdPlural) {
        $translation = ($n == 1 ? $msgId : $msgIdPlural);
    }

    return __replace($translation, $placeholders);
}

/**
 * Replaces placeholders from the string with supplied data
 *
 * If we have a string "Hello %world%!" and pass ['world' => 'Earth']
 * it will return "Hello Earth!"
 *
 * @param string $translation  Translation string with placeholders
 * @param array  $placeholders Associative array where key/value pairs represent a placeholder and it's replacement
 * i.e. passing ['world' => 'Earth'] would make function look for %world% placeholder and replace it with 'Earth'
 *
 * @return string
 */
function __replace(string $translation, array $placeholders = null) : string
{
    if (isset($placeholders) == false) {
        return $translation;
    }

    if (count($placeholders)) {
        foreach ($placeholders as $placeholder => $value) {
            $translation = str_replace('%' . $placeholder . '%', $value, $translation);
        }
    }

    return $translation;
}
