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

        return Truncator::truncate($html, $chars, $options);
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
