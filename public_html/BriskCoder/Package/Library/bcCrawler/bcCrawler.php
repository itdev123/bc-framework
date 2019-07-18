<?php
/**
 * BriskCoder
 *
 * NOTICE OF LICENSE
 *
 * @category    Library
 * @package     Package
 * @internal    Xpler Corporation Staff Only
 * @copyright   Copyright (c) 2010 Xpler Corporation. (http://www.xpler.com)
 * @license     http://www.briskcoder.com/license/  proprietary license, All rights reserved.
 */

namespace BriskCoder\Package\Library;

/**
 * Content Crawler
 * @category    Library
 * @package     Package
 */
class bcCrawler
{
    /**
     * @var object \DOMDocument
     */
    private $DOMLoaded;
    private $realURL;
    private $html;
    private $newHTML;
    private $currDOM;

    public function __construct()
    {
        
    }

    /**
     * LOADS WEBPAGE DOM CONTENTS.
     * @param string $URL Target Address
     * @param boolean $BODY  Returns Body Only
     * @return object BriskCoder\Package\Library\bcCrawler
     */
    public static function load($URL, $BODY = TRUE)
    {

        $_options[CURLOPT_URL]            = $URL;
        $_options[CURLOPT_USERAGENT]      = 'DigiSpider ADA Compliance Converter';
        $_options[CURLOPT_RETURNTRANSFER] = 1;
        $_options[CURLOPT_SSL_VERIFYPEER] = false;
        $_options[CURLOPT_SSL_VERIFYHOST] = false;

        $curl         = curl_init();
        curl_setopt_array($curl, $_options);
        $html         = curl_exec($curl);
        $realURL      = curl_getinfo($curl, CURLINFO_REDIRECT_URL);
        $realURL      = $realURL ? $realURL : curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
        $responseCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);

        if ($responseCode == '301' || $responseCode == '302'):
            $_options[CURLOPT_URL] = $realURL;
            $curl                  = curl_init();
            curl_setopt_array($curl, $_options);
            $html                  = curl_exec($curl);
        endif;

        if (!$html):
            return FALSE;
        endif;

        curl_close($curl);

        //start object
        $bcCrawler          = new bcCrawler();
        $bcCrawler->html    = $html;
        $bcCrawler->realURL = $realURL;


        //loads DOMLoaded
        $bcCrawler->DOMLoaded                     = new \DOMDocument();
        libxml_use_internal_errors(true); //prevent validation warnings
        $bcCrawler->DOMLoaded->loadHTML($html);
        $bcCrawler->DOMLoaded->preserveWhiteSpace = FALSE;

        if ($BODY):
            $nodes = $bcCrawler->DOMLoaded->getElementsByTagName('body');
            if ($nodes && ($nodes->length > 0)):
                $bcCrawler->html = $bcCrawler->DOMLoaded->saveHTML($nodes->item(0));
            endif;
        endif;

        $bcCrawler->newHTML = $bcCrawler->html;
        $bcCrawler->currDOM = $bcCrawler->DOMLoaded;
        return $bcCrawler;
    }

    public function getDomain($FQN = TRUE)
    {
        $_d = parse_url($this->realURL);
        if (empty($_d['host'])):
            return false;
        endif;

        if ($FQN):
            return $_d['scheme'].'://'.$_d['host'];
        endif;

        return $_d['host'];
    }

    /**
     * GETS ORIGINAL DOCUMENT FROM FIRST LOAD
     * @return string
     */
    public function getHTML()
    {
        return $this->html;
    }

    /**
     * GETS MODIFIED DOCUMENT WITH REMOVED NODES
     * @return string
     */
    public function getNewHTML()
    {
        return $this->newHTML;
    }

    /**
     * CONVERTS NODE OBJECTS TO HTML
     * @return string
     */
    public function saveHTML($NODES )
    {
        $el = $this->currDOM->saveHTML($NODES);
        $this->currDOM = $this->DOMLoaded;
        
        return $el;
        
        
        $html = '';
        if ($NODES && ($NODES->length > 0)):
            foreach ($NODES as $el):
                $html .= $this->currDOM->saveHTML($el);
            endforeach;
        endif;
        $this->currDOM = $this->DOMLoaded;
        return $html;
    }

    /**
     * REMOVE CURRENT NODE FROM DOCUMENT
     * @return string
     */
    public function removeNodes($NODES)
    {
        if ($NODES && ($NODES->length > 0)):
            foreach ($NODES as $el):
                $el->parentNode->removeChild($el);
            endforeach;
            $this->newHTML = $this->currDOM->saveHTML();
        endif;
        $this->currDOM = $this->DOMLoaded;
        return $this->newHTML;
    }

    /**
     * FIND NODE BY CLASS MATCHING CRITERIA WITHIN HTML.
     * @param String $CLASS  ID to search for
     * @param String $NEW_DOCUMENT Default is NULL, then current loaded DOM is used
     * @return mixed \DOMNodeLIst | FALSE
     */
    public function findByClass($CLASS)
    {
        $xpath = new \DOMXPath($this->currDOM);
        return $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $CLASS ')]");
    }

    /**
     * FIND NODE BY ID MATCHING CRITERIA WITHIN HTML.
     * @param String $ID  ID to search for
     * @param String $NEW_DOCUMENT Default is NULL, then current loaded DOM is used
     * @return mixed \DOMNodeLIst | FALSE
     */
    public function findByID($ID)
    {
        $xpath = new \DOMXPath($this->currDOM);
        return $xpath->query("//*[@id='$ID']")->item(0);
    }

    /**
     * FIND NODE BY TAG AND ITS CHILDREN WITHIN HTML. Not Recursive, First Level Only
     * @param String $TAG  HTML Tag to Search For
     * @param String $NEW_DOCUMENT Default is NULL, then current loaded DOM is used
     * @return mixed \DOMNodeLIst | FALSE
     */
    public function findByTag($TAG)
    {
        return $this->currDOM->getElementsByTagName($TAG);
    }

    /**
     * FIND FIRST OCCURENCY OF ID OR CLASS THAT MATCHES A KEYWORD
     * @param String $CLASS  ID to search for
     * @param String $NEW_DOCUMENT Default is NULL, then current loaded DOM is used
     * @return mixed \DOMNodeLIst | FALSE
     */
    public function findFirst($KEYWORD)
    {
        $xpath = new \DOMXPath($this->currDOM);
        return $xpath->query("//*[contains(@id,'$KEYWORD') or contains(@class,'$KEYWORD')]");
    }

    /**
     * FIND FIRST OCCURENCY OF ATTRIBUTE THAT MATCHES A KEYWORD
     * @param String $ATTRIBUTE  Attribute to search for, use * for any
     * @param String $KEYWORD  Criteria to search for within attributes
     * @param object $NEW_DOCUMENT Default is NULL, then current loaded DOM is used
     * @return mixed \DOMNodeLIst | FALSE
     */
    public function findFirstByAttribute($ATTRIBUTE, $KEYWORD, $NEW_DOCUMENT = NULL)
    {
        $xpath = new \DOMXPath($this->currDOM);
        return $xpath->query("//*[contains(@$ATTRIBUTE,'$KEYWORD')]");
    }

    /**
     * Converts Attributes SRC, HREF, ACTION and JS & CSS Ref: ('/ to absolute path from origin
     * @param string $URL Protocol + Domain
     * @param type $HTML Document target to be replaced
     * @return type
     */
    public static function makeAbsolutePath($URL, $HTML)
    {
        $_search[] = ' action="/';
        $_search[] = ' src="/';
        $_search[] = ' href="/';
        $_search[] = "('/"; //js and css references

        $_replace[] = ' action="'.$URL.'/';
        $_replace[] = ' src="'.$URL.'/';
        $_replace[] = ' href="'.$URL.'/';
        $_replace[] = "('".$URL."/";

        $HTML = str_replace($_search, $_replace, $HTML);

//        if (preg_match_all('/\b="[a-zA-Z0-9_]+[\/]+\b/', $HTML, $_m)):
//            $_search  = array();
//            $_replace = array();
//            // var_dump($_m);exit;
//            foreach ($_m[0] as $m):
//                $_search[]  = $m;
//                $_replace[] = '="'.$URL.'/'.ltrim($m, '="');
//            endforeach;
//            $HTML = str_replace($_search, $_replace, $HTML);
//        endif;

        return $HTML;
    }

    public function newDocument($NEW_DOCUMENT)
    {
        $this->currDOM                     = new \DOMDocument();
        libxml_use_internal_errors(true); //prevent validation warnings
        $this->currDOM->loadHTML($NEW_DOCUMENT);
        $this->currDOM->preserveWhiteSpace = FALSE;
        return $this;
    }
}