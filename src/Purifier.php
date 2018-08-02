<?php

namespace g4b0\HtmlPurifier;
use SilverStripe\Core\Config\Config;

/**
 * Standard HTML purifier
 */
class Purifier {

	/**
	 * Set custom options for HTML Purifier
	 * @link http://htmlpurifier.org/live/configdoc/plain.html
	 * @config
	 * @var array
	 */
	private static $html_purifier_config = [];

	/**
	 * Get the HTML Purifier config
	 * @return \HTMLPurifier_Config
	 */
	private static function GetHTMLPurifierConfig() {
		$defaultConfig = \HTMLPurifier_Config::createDefault();

		$customConfig = Config::inst()->get('g4b0\HtmlPurifier\Purifier', 'html_purifier_config');

		if(is_array($customConfig)) {
			foreach ($customConfig as $key => $value) {
				$defaultConfig->set($key, $value);
			}
		}

		return $defaultConfig;
	}

	/**
	 * Standard HTML purifier
	 * @param String $html HTML to purify
	 * @param String $encoding
	 * @return String Valid HTML string
	 */
	public static function Purify($html = null, $encoding = 'UTF-8') {

		$config = self::GetHTMLPurifierConfig();
		$config->set('Core.Encoding', $encoding);
		$config->set('HTML.Allowed', 'span,p,br,a,h1,h2,h3,h4,h5,strong,em,u,ul,li,ol,hr,blockquote,sub,sup,p[class],img');
		$config->set('HTML.AllowedElements', array('span', 'p', 'br', 'a', 'h1', 'h2', 'h3', 'h4', 'h5', 'strong', 'em', 'u', 'ul', 'li', 'ol', 'hr', 'blockquote', 'sub', 'sup', 'img'));
		$config->set('HTML.AllowedAttributes', 'style,target,title,href,class,src,border,alt,width,height,title,name,id');
		$config->set('CSS.AllowedProperties', 'text-align,font-weight,text-decoration');
		$config->set('AutoFormat.RemoveEmpty', true);
		$config->set('Attr.ForbiddenClasses', array('MsoNormal'));

		$purifier = new \HTMLPurifier($config);
		return $cleanCode = $purifier->purify($html);
	}

	/**
	 * XHTML 1.0 Strict purifier
	 * @param String $html HTML to purify
	 * @param String $encoding
	 * @return String XTML 1.0 Strict validating string
	 */
	public static function PurifyXHTML($html = null, $encoding = 'UTF-8') {

		$config = self::GetHTMLPurifierConfig();
		$config->set('Core.Encoding', $encoding);
		$config->set('HTML.Doctype', 'XHTML 1.0 Strict');
		$config->set('HTML.TidyLevel', 'heavy'); // all changes, minus...
		$config->set('CSS.AllowedProperties', array());
		$config->set('Attr.AllowedClasses', array());
		$config->set('HTML.Allowed', null);
		$config->set('AutoFormat.RemoveEmpty', true); // Remove empty tags
		$config->set('AutoFormat.Linkify', true);	// add <A> to links
		$config->set('AutoFormat.AutoParagraph', true);
		$config->set('HTML.ForbiddenElements', array('span', 'center'));
		$config->set('Core.EscapeNonASCIICharacters', true);
		$config->set('Output.TidyFormat', true);

		$purifier = new \HTMLPurifier($config);
		$html = $purifier->purify($html);

		// Rimpiazzo le parentesi quadre
		$html = str_ireplace("%5B", "[", $html);
		$html = str_ireplace("%5D", "]", $html);

		return $html;
	}
	
	/**
	 * Strip all HTML tags, like strip_tags, but encoding safe
	 * @param String $html HTML to purify
	 * @param String $encoding
	 * @return String The input string without any html tags
	 */
	public static function PurifyTXT($html = null, $encoding = 'UTF-8') {
		
		$config = self::GetHTMLPurifierConfig();
		$config->set('Core.Encoding', $encoding);
		$config->set('HTML.Allowed', null); // Allow Nothing
		$config->set('HTML.AllowedElements', array());
		$purifier = new \HTMLPurifier($config);
		return $purifier->purify($html);
	}

	/**
	 * Removes Silverstripe [embed] tags
	 * @param String $html
	 * @param String $encoding
	 * @return String
	 */
	public static function RemoveEmbed($html = null, $encoding = 'UTF-8') {
		
		$pattern = '/\[embed.*\].*\[\/embed\]/';
		return preg_replace($pattern, '', $html);
	}
	
}
