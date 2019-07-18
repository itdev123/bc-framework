<?php

namespace DigiSpider;

/**
 * DigiSpider ADA Crawler
 * @author rj@DigiProMedia.com
 */
class DigiSpider {

    private $domain;
    private $_html;
    private $_links;
    private $currentPage;

    /**
     *
     * @param string $url
     */
    public function __construct($url) {
        $d = parse_url($url);
        if (empty($d['host'])):
            return false;
        endif;

        $this->domain = $d['host'];

        $this->_html[$url] = file_get_contents($url);
        $this->currentPage = $url;
    }

    /**
     * GET SPECIFIC PAGE OR CURRENT IF PARAMETER IS EMPTY
     * Returns the original DOM
     * @return string $html
     */
    public function getHTML($url = null) {
        if (!$url):
            return !empty($this->_html[$this->currentPage]) ? $this->_html[$this->currentPage] : null;
        endif;
        return !empty($this->_html[$url]) ? $this->_html[$url] : null;
    }

    /**
     * GET ORIGINAL IFRAME OF SPECIFIC PAGE OR CURRENT IF PARAMETER IS EMPTY
     * Returns the original DOM in iframe
     * @return string $html
     */
    public function loadIframe($url = null) {
        if (!$url):
            return !empty($this->_html[$this->currentPage]) ? '<iframe src="' . $this->currentPage . '" style="width: 100%; height: 100%;">' : null;
        endif;
        return !empty($this->_html[$url]) ? '<iframe src="' . $url . '" style="width: 100%; height: 100%;">' : null;
    }

    /**
     * CRAWL ALL INTENAL PAGES
     * Return array containing all internal links URL found with a page
     * @return array
     */
    public function crawlLinks() {
        //first collect all internal links indexed by page
        //starting by current $domain $this->currentPage 
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);//prevent validation warnings
        $dom->loadHTML($this->_html[$this->currentPage]);

        foreach ($dom->getElementsByTagName('a') as $node) {
            $href = $node->getAttribute('href');
            if (empty($href)):
                continue;
            endif;
           // echo $dom->saveHtml($node) . '<br>';//outerHMTL
           // echo $node->nodeValue . '<br>';//text value of a tag
            echo $href . '<br>';//href value
            
        }

        libxml_use_internal_errors(false);
    }

    /**
     * CRAWL IMAGES
     * Return array containing all internal links URL found with a page
     * @return array
     */
    public function crawlImages() {
        
    }

}
