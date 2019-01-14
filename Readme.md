# Neos Eel helper for HTML-safe string cropping

[![Travis Build Status](https://travis-ci.org/punktDe/eel-htmlcrop.svg?branch=master)](https://travis-ci.org/punktDe/eel-htmlcrop) [![Latest Stable Version](https://poser.pugx.org/punktde/eel-htmlcrop/v/stable)](https://packagist.org/packages/punktde/eel-htmlcrop) [![Total Downloads](https://poser.pugx.org/punktde/eel-htmlcrop/downloads)](https://packagist.org/packages/punktde/eel-htmlcrop)

Currently the eelHelper uses [judev/php-htmltruncator](https://github.com/judev/php-htmltruncator) package to do the cropping. 

This implementation might change in future versions.

## Installation

**Install the package:**

    composer require punktde/eel-htmlcrop

## Usage

This package provides an Eel helper with the following methods:

* `HtmlCropping.cropAtWord(string $html, int $words, string $ellipsis = '…')`

* `HtmlCropping.cropAtCharacter(string $html, int $chars, string $ellipsis = '…')`
