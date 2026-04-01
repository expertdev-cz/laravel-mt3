<?php

namespace App\Helpers;

class RichEditorHelper
{
    /**
     * Zkontroluje, jestli caption vypadá jako název souboru
     */
    private static function looksLikeFilename(string $text): bool
    {
        $text = trim($text);
        
        // Prázdný text
        if (empty($text)) {
            return true;
        }
        
        // Obsahuje typické přípony souborů
        if (preg_match('/\.(jpg|jpeg|png|gif|webp|svg|bmp|pdf|doc|docx)\s*$/i', $text)) {
            return true;
        }
        
        // Obsahuje velikost souboru (např. "207.39 KB")
        if (preg_match('/\d+(\.\d+)?\s*(KB|MB|GB|bytes?)/i', $text)) {
            return true;
        }
        
        // Vypadá jako slug/ID (samé znaky bez mezer nebo s pomlčkami/podtržítky)
        if (preg_match('/^[a-z0-9_-]+$/i', $text)) {
            return true;
        }
        
        return false;
    }

    /**
     * Přidá ALT text z figcaption do img tagů
     */
    public static function addAltFromCaptions(?string $html): ?string
    {
        if (empty($html)) {
            return $html;
        }

        return preg_replace_callback(
            '/<figure[^>]*>.*?<img([^>]*)>.*?<figcaption[^>]*>(.*?)<\/figcaption>.*?<\/figure>/is',
            function ($matches) {
                $imgAttributes = $matches[1];
                $caption = trim(strip_tags($matches[2]));
                
                // Přeskočíme, pokud caption vypadá jako název souboru
                if (empty($caption) || self::looksLikeFilename($caption)) {
                    return $matches[0];
                }
                
                // Nahradíme nebo přidáme alt atribut
                if (preg_match('/alt=["\']([^"\']*)["\']/', $imgAttributes)) {
                    $imgAttributes = preg_replace(
                        '/alt=["\'][^"\']*["\']/',
                        'alt="' . htmlspecialchars($caption, ENT_QUOTES) . '"',
                        $imgAttributes
                    );
                } else {
                    $imgAttributes .= ' alt="' . htmlspecialchars($caption, ENT_QUOTES) . '"';
                }
                
                return str_replace($matches[1], $imgAttributes, $matches[0]);
            },
            $html
        );
    }

    /**
     * Zkontroluje, jestli všechny obrázky mají smysluplný caption
     * @return array [bool hasIssues, int missingCaptionsCount]
     */
    public static function checkMissingCaptions(?string $html): array
    {
        if (empty($html)) {
            return [false, 0];
        }

        $missingCount = 0;

        // Najdi všechny figure s img
        preg_match_all('/<figure[^>]*>.*?<img[^>]*>.*?<\/figure>/is', $html, $figures);
        
        foreach ($figures[0] as $figure) {
            // Zkontroluj, jestli má figcaption s textem
            if (preg_match('/<figcaption[^>]*>(.*?)<\/figcaption>/is', $figure, $captionMatch)) {
                $captionText = trim(strip_tags($captionMatch[1]));
                
                // Považujeme za chybějící, pokud je prázdný nebo vypadá jako název souboru
                if (empty($captionText) || self::looksLikeFilename($captionText)) {
                    $missingCount++;
                }
            } else {
                // Figcaption úplně chybí
                $missingCount++;
            }
        }

        return [$missingCount > 0, $missingCount];
    }

    /**
     * Zpracuje všechny RichEditor pole v content poli článku
     * @return array [data, hasMissingCaptions, totalMissingCount]
     */
    public static function processArticleContent(array $data): array
    {
        $totalMissing = 0;

        // Zpracuj hlavní text článku
        if (isset($data['content']['text'])) {
            [$hasIssues, $count] = self::checkMissingCaptions($data['content']['text']);
            $totalMissing += $count;
            $data['content']['text'] = self::addAltFromCaptions($data['content']['text']);
        }

        // Zpracuj segments (další části obsahu)
        if (isset($data['content']['segments']) && is_array($data['content']['segments'])) {
            foreach ($data['content']['segments'] as $key => $segment) {
                if (isset($segment['text'])) {
                    [$hasIssues, $count] = self::checkMissingCaptions($segment['text']);
                    $totalMissing += $count;
                    $data['content']['segments'][$key]['text'] = self::addAltFromCaptions($segment['text']);
                }
            }
        }

        return [$data, $totalMissing > 0, $totalMissing];
    }
}