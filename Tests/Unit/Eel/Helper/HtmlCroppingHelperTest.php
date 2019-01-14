<?php
declare(strict_types=1);

namespace PunktDe\Eel\HtmlCrop\Tests\Unit\Eel\Helper;

/*
 *  (c) 2019 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 *  All rights reserved.
 */

use HtmlTruncator\InvalidHtmlException;
use Neos\Flow\Tests\UnitTestCase;
use PunktDe\Eel\HtmlCrop\Eel\Helper\HtmlCroppingHelper;

class HtmlCroppingHelperTest extends UnitTestCase
{
    /**
     * @var HtmlCroppingHelper
     */
    protected $htmlCroppingHelper;


    public function setUp()
    {
        parent::setUp();

        $this->htmlCroppingHelper = new HtmlCroppingHelper();
    }

    /**
     * @test
     * @throws InvalidHtmlException
     */
    public function croppingByCharactersReturnsSameStringIfThresholdIsHigh()
    {
        $input = '<div class="test-class"><span>Das ist ein Text</span><img src="/src/image.jpg"/>Hier weiterer Text der dann irgendwann nicht mehr zu lesen ist. Schade.</div>';
        $actual = $this->htmlCroppingHelper->cropAtCharacter($input, 1000);

        $this->assertEquals($input, $actual);
    }

    /**
     * @test
     * @throws InvalidHtmlException
     */
    public function croppingByWordsReturnsSameStringIfThresholdIsHigh()
    {
        $input = '<div class="test-class"><span>Das ist ein Text</span><img src="/src/image.jpg"/>Hier weiterer Text der dann irgendwann nicht mehr zu lesen ist. Schade.</div>';
        $actual = $this->htmlCroppingHelper->cropAtWord($input, 100);

        $this->assertEquals($input, $actual);
    }

    public function cropDataProvider()
    {
        return [
            'in div' => [
                'input' => '<div class="test-class"><span>Das ist ein Text</span><img src="/src/image.jpg"/>Hier weiterer Text der dann irgendwann nicht mehr zu lesen ist. Schade.</div>',
                'wordCount' => 10,
                'characterCount' => 20,
                'expectedCroppedByWords' => '<div class="test-class"><span>Das ist ein Text</span><img src="/src/image.jpg"/>Hier weiterer Text der dann irgendwann---</div>',
                'expectedCroppedByCharacters' => '<div class="test-class"><span>Das ist ein Text</span><img src="/src/image.jpg"/>Hier---</div>'
            ],
            'in table' => [
                'input' => '<table><tbody><tr><td>Eins</td><td>Zwei</td><td>Drei</td></tr></tbody></table>',
                'wordCount' => 2,
                'characterCount' => 5,
                'expectedCroppedByWords' => '<table><tbody><tr><td>Eins</td><td>Zwei</td></tr></tbody></table>---',
                'expectedCroppedByCharacters' => '<table><tbody><tr><td>Eins</td><td>Z</td></tr></tbody></table>---'
            ]
        ];
    }

    /**
     * @param string $input
     * @param int $wordCount
     * @param int $characterCount
     * @param string $expectedCroppedByWords
     * @param string $expectedCroppedByCharacters
     * @throws InvalidHtmlException
     *
     * @dataProvider cropDataProvider
     * @test
     */
    public function cropTest(string $input, int $wordCount, int $characterCount, string $expectedCroppedByWords, string $expectedCroppedByCharacters)
    {
        $actualCoppedByCharacters = $this->htmlCroppingHelper->cropAtCharacter($input, $characterCount, '---');
        $this->assertEquals($expectedCroppedByCharacters, $actualCoppedByCharacters, 'Word cropping does not match expected');

        $actualCoppedByWords = $this->htmlCroppingHelper->cropAtWord($input, $wordCount, '---');
        $this->assertEquals($expectedCroppedByWords, $actualCoppedByWords, 'Character cropping does not match expected');
    }
}
