<?php
declare(strict_types=1);

namespace PunktDe\Eel\HtmlCrop\Eel\Helper;

/*
 *  (c) 2019 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 *  All rights reserved.
 */

use HtmlTruncator\InvalidHtmlException;
use HtmlTruncator\Truncator;
use Neos\Eel\ProtectedContextAwareInterface;

class HtmlCroppingHelper implements ProtectedContextAwareInterface
{

    /**
     * @param string $html
     * @param int $words Crop after this amount of words
     * @param string $ellipsis The ellipsis to show after cropping
     * @return string The cropped text
     * @throws InvalidHtmlException
     */
    public function cropAtWord(string $html, int $words, string $ellipsis = '…'): string
    {
        $options = [
            'ellipsis' => $ellipsis,
            'length_in_chars' => false
        ];

        if (mb_strpos($html, ContentCache::CACHE_SEGMENT_START_TOKEN)) {
            throw new \Exception('A Fusion cache segment was found while cropping the content. (A prototype with @cache.mode=\'cached\'). Cached prototypes cannot be cropped, as we might crop inside the cache markers and with that break the cache segment.', 1587573052);
        }

        return Truncator::truncate($html, $words, $options);
    }


    /**
     * @param string $html
     * @param int $chars Crop after this amount of chars
     * @param string $ellipsis
     * @return string
     * @throws InvalidHtmlException
     */
    public function cropAtCharacter(string $html, int $chars, string $ellipsis = '…'): string
    {

        $options = [
            'ellipsis' => $ellipsis,
            'length_in_chars' => true
        ];

        if (mb_strpos($html, ContentCache::CACHE_SEGMENT_START_TOKEN)) {
            throw new \Exception('A Fusion cache segment was found while cropping the content. (A prototype with @cache.mode=\'cached\'). Cached prototypes cannot be cropped, as we might crop inside the cache markers and with that break the cache segment.', 1587573052);
        }

        $truncatedHtml = Truncator::truncate($html, $chars, $options);

        return is_string($truncatedHtml) ? $truncatedHtml : $html;
    }

    /**
     * @param string $methodName
     * @return boolean
     */
    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
