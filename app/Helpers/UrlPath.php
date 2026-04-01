<?php

namespace App\Helpers;

class UrlPath
{
    /**
     * Vstup: absolutní URL (https://domena.tld/o-nas?x=1) NEBO relativní (/o-nas)
     * Výstup: relativní cesta začínající "/" bez trailing "/", bez query, např. "/o-nas"
     */
    public static function normalize(string $value): string
    {
        $v = trim($value);

        // Je to absolutní URL?
        if (preg_match('#^https?://#i', $v)) {
            $parts = parse_url($v);
            $path  = $parts['path'] ?? '/';
        } else {
            // Bereme to jako cestu
            $path = $v === '' ? '/' : $v;
        }

        // vždy přidej začáteční "/" a odstraň trailing "/"
        $path = '/'.trim($path, '/');

        // speciálka: pokud výsledek je "//", vrať "/"
        return $path === '//' ? '/' : $path;
    }
}
