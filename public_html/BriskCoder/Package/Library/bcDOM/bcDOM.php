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
 * BRISKCODER DOCUMENT OBJECT MODEL
 * @category    Library
 * @package     Package
 */
class bcDOM
{
    private static
        $_ns    = array(),
        $currNS = NULL;

    private function __construct()
    {

    }

    private function __clone()
    {
        
    }




    /**
     * USE NAMESPACE
     * @param string $NAMESPACE DOM Namespace
     * @return boolean FALSE when Namespace is already set
     */
    public static function useNamespace($NAMESPACE)
    {
        self::$currNS = $NAMESPACE;

        //namespace exists?
        if (isset(self::$_ns[self::$currNS])):
            return FALSE;
        endif;

        self::$_ns[self::$currNS]['REMOTE'] = FALSE;
        self::$_ns[self::$currNS]['DOM'] = NULL;
        self::$_ns[self::$currNS]['NODE'] = NULL;

    }

    /**
     * LOADS WEBPAGE DOM CONTENTS.
     * @param string $URL Target Address
     * @param boolean $BODY  Returns Body Only
     * @return string NULL or String DOM Content
     */
    public static function load($URL, $BODY = TRUE)
    {
        $_d = parse_url($URL);

        if (empty($_d['host'])):
            return NULL;
        endif;

        $domain = $_d['host'];

        $_opt = array(
            "http" => array(
                'user_agent' => 'DigiSpider ADA Compliance Converter'
            ),
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $html = file_get_contents($URL, FALSE, stream_context_create($_opt));

        if ($html && $BODY):
            $dom                     = new \DOMDocument();
            libxml_use_internal_errors(true); //prevent validation warnings
            $dom->loadHTML($html);
            $dom->preserveWhiteSpace = FALSE;
            $nodes                   = $dom->getElementsByTagName('body');

            if ($nodes && ($nodes->length > 0)):
                $html = $dom->saveHTML($nodes->item(0));
            endif;
        endif;

        return $html;
    }

    /**
     * FIND NODE BY CLASS MATCHING CRITERIA WITHIN HTML.
     * @param String $CLASS  ID to search for
     * @param String $HTML  HTML Markup to search within
     * @param boolen $RETURN_ARRAY TRUE|FALSE
     * @param boolean $REMOVE_NODE Remove Found Nodes from Document, then use bcCrawler::getNewDocument()
     * @return mixed string|array
     */
    public static function findByClass($CLASS, $HTML, $RETURN_ARRAY = FALSE,
                                       $REMOVE_NODE = FALSE)
    {
        $dom                     = new \DOMDocument();
        libxml_use_internal_errors(true); //prevent validation warnings
        $dom->loadHTML($HTML);
        $dom->preserveWhiteSpace = FALSE;
        $xpath                   = new \DOMXPath($dom);
        $nodes                   = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $CLASS ')]");
        self::$newDoc            = '';
        $html                    = null;
        $_n                      = array();

        if ($nodes && ($nodes->length > 0)):
            foreach ($nodes as $el):
                if ($REMOVE_NODE):
                    $_n[] = $el;
                endif;

                if (!$RETURN_ARRAY):
                    $html .= $dom->saveHTML($el);
                    continue;
                endif;

                $html[] = $dom->saveHTML($el);
            endforeach;

            if (!empty($_n)):
                foreach ($_n as $e):
                    $e->parentNode->removeChild($e);
                endforeach;
                self::$newDoc = $dom->saveHTML();
            endif;
        endif;
        return $html;
    }

    /**
     * FIND NODE BY ID MATCHING CRITERIA WITHIN HTML.
     * @param String $ID  ID to search for
     * @param String $HTML  HTML Markup to search within
     * @param boolean $REMOVE_NODE Remove Found Nodes from Document, then use bcCrawler::getNewDocument()
     * @return string
     */
    public static function findByID($ID, $HTML, $REMOVE_NODE = FALSE)
    {
        $dom          = new \DOMDocument();
        libxml_use_internal_errors(true); //prevent validation warnings
        $dom->loadHTML($HTML);
        $xpath        = new \DOMXPath($dom);
        $nodes        = $xpath->query("//*[@id='$ID']")->item(0);
        self::$newDoc = '';
        $html         = null;
        if ($nodes && ($nodes->length > 0)):
            $html = $dom->saveHTML($nodes);
            if ($REMOVE_NODE):
                $nodes->parentNode->removeChild($nodes);
                self::$newDoc = $dom->saveHTML();
            endif;
        endif;
        return $html;
    }

    /**
     * FIND NODE BY TAG AND ITS CHILDREN WITHIN HTML. Not Recursive, First Level Only
     * @param String $TAG  HTML Tag to Search For
     * @param String $HTML  HTML Markup to search within
     * @param boolean $RETURN_ARRAY TRUE|FALSE
     * @param boolean $REMOVE_NODE Remove Found Nodes from Document, then use bcCrawler::getNewDocument()
     * @return mixed string|array
     */
    public static function findByTag($TAG, $HTML, $RETURN_ARRAY = FALSE,
                                     $REMOVE_NODE = FALSE)
    {
        $dom                     = new \DOMDocument();
        libxml_use_internal_errors(true); //prevent validation warnings
        $dom->loadHTML($HTML);
        $dom->preserveWhiteSpace = FALSE;
        $nodes                   = $dom->getElementsByTagName($TAG);
        self::$newDoc            = '';
        $html                    = null;
        $_n                      = array();

        if ($nodes && ($nodes->length > 0)):
            foreach ($nodes as $el):
                if ($REMOVE_NODE):
                    $_n[] = $el;
                endif;

                if (!$RETURN_ARRAY):
                    $html .= $dom->saveHTML($el);
                    continue;
                endif;

                $html[] = $dom->saveHTML($el);
            endforeach;

            if (!empty($_n)):
                foreach ($_n as $e):
                    $e->parentNode->removeChild($e);
                endforeach;
                self::$newDoc = $dom->saveHTML();
            endif;
        endif;
        return $html;
    }

    /**
     * FIND FIRST OCCURENCY OF ID OR CLASS THAT MATCHES A KEYWORD
     * @param String $CLASS  ID to search for
     * @param String $HTML HTML Markup to search within
     * @param boolean $REMOVE_NODE Remove Found Nodes from Document, then use bcCrawler::getNewDocument()
     * @return string
     */
    public static function findFirst($KEYWORD, $HTML, $REMOVE_NODE = FALSE)
    {
        $dom          = new \DOMDocument();
        libxml_use_internal_errors(true); //prevent validation warnings
        $dom->loadHTML($HTML);
        $xpath        = new \DOMXPath($dom);
        $nodes        = $xpath->query("//*[contains(@id,'$KEYWORD') or contains(@class,'$KEYWORD')]");
        self::$newDoc = '';
        $html         = null;
        if ($nodes):
            $html = $dom->saveHTML($nodes->item(0));
            if ($REMOVE_NODE):
                $nodes->item(0)->parentNode->removeChild($nodes->item(0));
                self::$newDoc = $dom->saveHTML();
            endif;
        endif;
        return $html;
    }

    /**
     * FIND FIRST OCCURENCY OF ATTRIBUTE THAT MATCHES A KEYWORD
     * @param String $ATTRIBUTE  Attribute to search for, use * for any
     * @param String $KEYWORD  Criteria to search for within attributes
     * @param String $HTML HTML Markup to search within
     * @param boolean $REMOVE_NODE Remove Found Nodes from Document, then use bcCrawler::getNewDocument()
     * @return string
     */
    public static function findFirstByAttribute($ATTRIBUTE, $KEYWORD, $HTML,
                                                $REMOVE_NODE = FALSE)
    {
        $dom          = new \DOMDocument();
        libxml_use_internal_errors(true); //prevent validation warnings
        $dom->loadHTML($HTML);
        $xpath        = new \DOMXPath($dom);
        $nodes        = $xpath->query("//*[contains(@$ATTRIBUTE,'$KEYWORD')]");
        self::$newDoc = '';
        $html         = null;
        if ($nodes && ($nodes->length > 0)):
            $html = $dom->saveHTML($nodes->item(0));
            if ($REMOVE_NODE):
                $nodes->item(0)->parentNode->removeChild($nodes->item(0));
                self::$newDoc = $dom->saveHTML();
            endif;
        endif;
        return $html;
    }

    /**
     * GETS NEW DOCUMENT WITH REMOVED NODES
     * @return string
     */
    public static function getNewDocument()
    {
        return self::$newDoc;
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

        if (preg_match_all('/\b="[a-zA-Z0-9_]+[\/]+\b/', $HTML, $_m)):
            $_search  = array();
            $_replace = array();
            // var_dump($_m);exit;
            foreach ($_m[0] as $m):
                $_search[]  = $m;
                $_replace[] = '="'.$URL.'/'.ltrim($m, '="');
            endforeach;
            $HTML = str_replace($_search, $_replace, $HTML);
        endif;

        return $HTML;
    }
}