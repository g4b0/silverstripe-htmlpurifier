# HtmlPurifier

A simple wrapper around HtmlPurifier [http://htmlpurifier.org/]

## Introduction

This module adds a wrapper named Purifier around the famous HtmlPurifier. You can use HtmlPurifier by itself, or use some 
of the custom function to have clean HTML or XHTML code, TXT code or to strip the [embed] tags. It's also possible to extend
the Purifier class to add your own purifier functions.

## Requirements

 * SilverStripe >= 4.1 < 5.0

 For 3.x installations refer to the 1.x version

## Installation

Install the module through [composer](http://getcomposer.org):

	composer require g4b0/htmlpurifier
	composer update

## Usage

Whenever you need to purify your HTML code, eg. during OnBeforeWrite, OnAfterWrite or in a custom search, just call the wrapper function:

```php
$content = Purifier::PurifyTXT($p->Content);
$content = Purifier::RemoveEmbed($content);
```
