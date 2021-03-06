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
use Neos\Fusion\Core\Cache\ContentCache;

class HtmlCroppingHelper implements ProtectedContextAwareInterface
{

    /**
     * @param string $html
     * @param int $words Crop after this amount of words
     * @param string $ellipsis The ellipsis to show after cropping
     * @return string The cropped text
     * @throws InvalidHtmlException
     * @throws \Exception
     */
    public function cropAtWord(string $html, int $words, string $ellipsis = '…'): string
    {
        $options = [
            'ellipsis' => $ellipsis,
            'length_in_chars' => false
        ];

        $cacheMarkerPosition = -1;

        if (mb_strpos($html, ContentCache::CACHE_SEGMENT_START_TOKEN) !== false) {
            $cacheMarkerPosition = mb_strpos($html, ContentCache::CACHE_SEGMENT_START_TOKEN);
        }

        $truncatedHtml = Truncator::truncate($html, $words, $options);

        if ($cacheMarkerPosition > -1 && strlen($truncatedHtml) >= $cacheMarkerPosition) {
            throw new \Exception('A Fusion cache segment was found while cropping the content. (A prototype with @cache.mode=\'cached\'). Cached prototypes cannot be cropped, as we might crop inside the cache markers and with that break the cache segment.', 1587573052);
        }
        return $truncatedHtml;
    }

    /**
     * @param string $html
     * @param int $chars Crop after this amount of chars
     * @param string $ellipsis
     * @return string
     * @throws InvalidHtmlException
     * @throws \Exception
     */
    public function cropAtCharacter(string $html, int $chars, string $ellipsis = '…'): string
    {

        $options = [
            'ellipsis' => $ellipsis,
            'length_in_chars' => true
        ];

        if (mb_strpos($html, ContentCache::CACHE_SEGMENT_START_TOKEN) !== false && mb_strpos($html, ContentCache::CACHE_SEGMENT_START_TOKEN) < $chars) {
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
