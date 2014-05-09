# Widgets Pages Extension

A simple wrapper around HtmlPurifier v. 4.6.0 [http://htmlpurifier.org/]

## Introduction

This module adds a wrapper named Purifier around the famous HtmlPurifier. You can use HtmlPurifier by itself, or use some 
of the custom function to have clean HTML or XHTML code, TXT code or to strip the [embed] tags. It's also possible to extend
the Purifier class to add your own purifier functions.

## Requirements

 * SilverStripe 3.1

## Installation

Install the module through [composer](http://getcomposer.org):

	composer zirak/htmlpurifier

## Usage

Whenever you need to purify your HTML code, eg. during OnBeforeWrite, OnAfterWrite or in a custom search, just call the wrapper function:

```php
$content = Purifier::PurifyTXT($p->Content);
$content = Purifier::RemoveEmbed($content);
```