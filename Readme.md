# Neos Eel Helper to crop HTML

Currently the eelHelper uses [judev/php-htmltruncator](https://github.com/judev/php-htmltruncator) package to do the cropping. 
This implementation might change in future versions.

## Installation

**Install the package:**

	composer require punktde/eel-htmlcrop

## Usage

This package provides an Eel Helper with the following methods:

* `HtmlCropping.cropAtWord(string $html, int $words, string $ellipsis = '…')`

* `HtmlCropping.cropAtCharacter(string $html, int $chars, string $ellipsis = '…')`
