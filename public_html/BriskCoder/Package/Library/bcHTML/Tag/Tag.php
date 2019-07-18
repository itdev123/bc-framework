<?php

/**
 * BriskCoder
 *
 * NOTICE OF LICENSE
 *
 * @category    Library
 * @package     bcHTML
 * @internal    Xpler Corporation Staff Only
 * @copyright   Copyright (c) 2010 Xpler Corporation. (http://www.xpler.com)
 * @license     http://www.briskcoder.com/license/  proprietary license, All rights reserved.
 */

namespace BriskCoder\Package\Library\bcHTML;

class Tag
{

    private $html = NULL;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Library\bcHTML' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * COMMENT TAG 
     * <!-- -->
     * @link http://www.w3schools.com/tags/tag_comment.asp W3C Doc
     * @param String $TEXT Defines a comment.
     * @return Void
     */
    public function _comment( $TEXT )
    {
        $this->html .= '<!--' . $TEXT . '-->';
    }

    /**
     * DOCTYPE TAG
     * <!DOCTYPE>
     * Open Grapgh Uses  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
     * @link http://www.w3schools.com/tags/tag_doctype.asp W3C Doc
     * @param String $TYPE Defines the document type.
     * @return Void
     */
    public function _doctype( $TYPE )
    {
        $this->html .= '<!DOCTYPE ' . $TYPE . '>';
    }

    /**
     * A TAG
     * <a href="uri">content</a>
     * @link http://www.w3schools.com/tags/tag_a.asp W3C Doc
     * @param String $CONTENT Hyperlink content.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' );
     * @return Void
     */
    public function a( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<a' . $_ATTRIBUTES . '>' . $CONTENT . '</a>';
    }

    /**
     * ABBR TAG
     * <abbr title="text">content</abbr>
     * @link http://www.w3schools.com/tags/tag_abbr.asp W3C Doc
     * @param String $CONTENT Defines an abbreviation or an acronym.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' );  
     * @return Void
     */
    public function abbr( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<abbr' . $_ATTRIBUTES . '>' . $CONTENT . '</abbr>';
    }

    /**
     * ADDRESS TAG
     * <address></address>
     * @link http://www.w3schools.com/tags/tag_address.asp W3C Doc
     * @param String $CONTENT Defines the contact information for the author/owner of a document or an article.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' );  
     * @return Void
     */
    public function address( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<address' . $_ATTRIBUTES . '>' . $CONTENT . '</address>';
    }

    /**
     * ARTICLE TAG
     * <article></article>
     * @link http://www.w3schools.com/tags/tag_article.asp W3C Doc
     * @param String $CONTENT Specifies independent, self-contained content
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' );  
     * @return Void
     */
    public function article( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<article' . $_ATTRIBUTES . '>' . $CONTENT . '</article>';
    }

    /**
     * ASIDE TAG
     * <aside></aside>
     * @link http://www.w3schools.com/tags/tag_aside.asp W3C Doc
     * @param String $CONTENT Defines some content aside from the content it is placed in
     * @param Array $_attributes HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' );  
     * @return Void
     */
    public function aside( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<aside' . $_ATTRIBUTES . '>' . $CONTENT . '</aside>';
    }

    /**
     * AUDIO TAG
     * <audio><source></audio>
     * @link http://www.w3schools.com/tags/tag_audio.asp W3C Doc
     * @param Array $_AUDIO_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_audio_attributes = array( 'controls', 'autoplay' );
     * @param Array $_SOURCE_AND_ATTRIBUTES Defines number of source tags as keys and value array as attributes $_SOURCE_AND_ATTRIBUTES[] = array( 'src="path"', type="audio/ogg");
     * @return Void 
     */
    public function audio( $_AUDIO_ATTRIBUTES, $_SOURCE_AND_ATTRIBUTES )
    {
        $_AUDIO_ATTRIBUTES = !empty( $_AUDIO_ATTRIBUTES ) ? ' ' . implode( ' ', $_AUDIO_ATTRIBUTES ) : NULL;
        $this->html .= '<audio' . $_AUDIO_ATTRIBUTES . '>';
        foreach ( $_SOURCE_AND_ATTRIBUTES as $attr ):
            $attr = !empty( $attr ) ? ' ' . implode( ' ', $attr ) : NULL;
            $this->html .= '<source' . $attr . '>';
        endforeach;
        $this->html .= '</audio>';
    }

    /**
     * B TAG
     * <b></b>
     * @link http://www.w3schools.com/tags/tag_b.asp W3C Doc
     * @param String $CONTENT Specifies bold text.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void 
     */
    public function b( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<b' . $_ATTRIBUTES . '>' . $CONTENT . '</b>';
    }

    /**
     * BASE TAG
     * <base href="uri">
     * @link http://www.w3schools.com/tags/tag_base.asp W3C Doc
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void 
     */
    public function base( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<base' . $_ATTRIBUTES . '>';
    }

    /**
     * BDI TAG
     * <bdi></bdi>
     * @link http://www.w3schools.com/tags/tag_bdi.asp W3C Doc
     * @param String $CONTENT Isolates a part of text that might be formatted in a different direction from other text outside it.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void 
     */
    public function bdi( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<bdi' . $_ATTRIBUTES . '>' . $CONTENT . '</bdi>';
    }

    /**
     * BDO TAG
     * <bdo dir="rtl" ></bdo>
     * @link http://www.w3schools.com/tags/tag_bdo.asp W3C Doc
     * @param String $CONTENT Used to override the current text direction..
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void 
     */
    public function bdo( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<bdo' . $_ATTRIBUTES . '>' . $CONTENT . '</bdo>';
    }

    /**
     * BLOCKQUOTE TAG
     * <blockquote cite="uri"></blockquote>
     * @link http://www.w3schools.com/tags/tag_blockquote.asp W3C Doc
     * @param String $CONTENT  Specifies a section that is quoted from another source.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void 
     */
    public function blockquote( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<blockquote' . $_ATTRIBUTES . '>' . $CONTENT . '</blockquote>';
    }

    /**
     * BODY TAG
     * <body></body>
     * @link http://www.w3schools.com/tags/tag_body.asp W3C Doc
     * @param String $CONTENT Defines the document's body.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void 
     */
    public function body( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<body' . $_ATTRIBUTES . '>' . $CONTENT . '</body>';
    }

    /**
     * BR TAG
     * <br>
     * @link http://www.w3schools.com/tags/tag_br.asp W3C Doc
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void 
     */
    public function br( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<br' . $_ATTRIBUTES . '>';
    }

    /**
     * CANVAS TAG
     * <canvas></canvas>
     * @link http://www.w3schools.com/tags/tag_canvas.asp W3C Doc
     * @param String $CONTENT Used to draw graphics, on the fly, via scripting (usually JavaScript).
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void 
     */
    public function canvas( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<canvas' . $_ATTRIBUTES . '>' . $CONTENT . '</canvas>';
    }

    /**
     * CITE TAG
     * <cite></cite>
     * @link http://www.w3schools.com/tags/tag_cite.asp W3C Doc
     * @param String $CONTENT Defines the title of a work (e.g. a book, a song, a movie, a TV show, a painting, a sculpture, etc).
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void 
     */
    public function cite( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<cite' . $_ATTRIBUTES . '>' . $CONTENT . '</cite>';
    }

    /**
     * CODE TAG
     * <code></code>
     * @link http://www.w3schools.com/tags/tag_code.asp W3C Doc
     * @param String $CONTENT Defines a piece of computer code.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void 
     */
    public function code( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<code' . $_ATTRIBUTES . '>' . $CONTENT . '</code>';
    }

    /**
     * DEL TAG
     * <del></del>
     * @link http://www.w3schools.com/tags/tag_del.asp W3C Doc
     * @param String $CONTENT Defines text that has been deleted from a document.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void 
     */
    public function del( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<del' . $_ATTRIBUTES . '>' . $CONTENT . '</del>';
    }

    /**
     * DETAILS TAG
     * <details><summary></summary></details>
     * @link http://www.w3schools.com/tags/tag_details.asp W3C Doc
     * @param String $SUMMARY Specify a visible heading for the details.
     * @param String $CONTENT Specifies addtional details that the user can view or hide on demand.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @param Array $_SUMMARY_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_SUMMARY_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function details( $SUMMARY, $CONTENT, $_ATTRIBUTES = array(), $_SUMMARY_ATTRIBUTES = array() )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<details' . $_ATTRIBUTES . '>';
        $_SUMMARY_ATTRIBUTES = !empty( $_SUMMARY_ATTRIBUTES ) ? ' ' . implode( ' ', $_SUMMARY_ATTRIBUTES ) : NULL;
        $this->html .= '<summary' . $_SUMMARY_ATTRIBUTES . '> ' . $SUMMARY . '</summary>';
        $this->html .= $CONTENT . '</details>';
    }

    /**
     * DFN TAG
     * <dfn></dfn>
     * @link http://www.w3schools.com/tags/tag_del.asp W3C Doc
     * @param String $CONTENT Represents the defining instance of a term in HTML.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void 
     */
    public function dfn( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<dfn' . $_ATTRIBUTES . '>' . $CONTENT . '</dfn>';
    }

    /**
     * DL TAG
     * <dl><dt></dt><dd></dd></dl>
     * @link http://www.w3schools.com/tags/tag_dl.asp W3C Doc
     * @param Array $_DL_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @param Array $_LIST Description List with subkeys: 0 as "type dt|dd", 1 as "content" and 3 as "attributes" and their respective values<br>
     * ie:  <br>
     * $_LIST[] = array( 'dt', "your content", array( 'class="your_class")) <br>
     * $_LIST[] = array( 'dd', "your content", array( 'onclick="your_function"))
     * @return Void 
     */
    public function dl( $_DL_ATTRIBUTES, $_LIST )
    {
        $_DL_ATTRIBUTES = !empty( $_DL_ATTRIBUTES ) ? ' ' . implode( ' ', $_DL_ATTRIBUTES ) : NULL;
        $this->html .= '<dl' . $_DL_ATTRIBUTES . '>';
        foreach ( $_LIST as $_l ):
            if ( (!isset( $_l[0] )) || (!isset( $_l[1] )) ):
                continue;
            endif;
            $this->html .= '<' . $_l[0] . implode( ' ', isset( $_l[3] ) ? $_l[3] : array()  ) . '>' . $_l[1] . '</' . $_l[0] . '>';
        endforeach;
        $this->html .= '</dl>';
    }

    /**
     * DIALOG TAG
     * <dialog open></dialog>
     * @link http://www.w3schools.com/tags/tag_dialog.asp WC Doc
     * @param String $CONTENT Defines a dialog box or window.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void 
     */
    public function dialog( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<dialog' . $_ATTRIBUTES . '>' . $CONTENT . '</dialog>';
    }

    /**
     * DIV TAG
     * <div></div>
     * @link http://www.w3schools.com/tags/tag_div.asp WC Doc 
     * @param String $CONTENT Defines a division or a section in an HTML document.    
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function div( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<div' . $_ATTRIBUTES . '>' . $CONTENT . '</div>';
    }

    /**
     * EM TAG
     * <em></em>
     * @link http://www.w3schools.com/tags/tag_em.asp WC Doc
     * @param String $CONTENT Renders as emphasized text.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function em( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<em' . $_ATTRIBUTES . '>' . $CONTENT . '</em>';
    }

    /**
     * EMBED TAG
     * <embed src="url">
     * @link http://www.w3schools.com/tags/tag_embed.asp WC Doc
     * @param String $CONTENT Defines a container for an external application or interactive content (a plug-in).
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function embed( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<embed' . $_ATTRIBUTES . '>' . $CONTENT . '</embed>';
    }

    /**
     * FIGCAPTION TAG
     * <figcaption></figcaption>
     * @link http://www.w3schools.com/tags/tag_figcaption.asp WC Doc
     * @param String $CONTENT Defines a caption for a <figure> element.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function figcaption( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<figcaption' . $_ATTRIBUTES . '>' . $CONTENT . '</figcaption>';
    }

    /**
     * FIGURE TAG
     * <figure></figure>
     * @link http://www.w3schools.com/tags/tag_figure.asp WC Doc
     * @param String $CONTENT Specifies self-contained content, like illustrations, diagrams, photos, code listings, etc.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function figure( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<figure' . $_ATTRIBUTES . '>' . $CONTENT . '</figure>';
    }

    /**
     * FOOTER TAG
     * <footer></footer>
     * @link http://www.w3schools.com/tags/tag_footer.asp WC Doc
     * @param String $CONTENT Defines a footer for a document or section.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function footer( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<footer' . $_ATTRIBUTES . '>' . $CONTENT . '</footer>';
    }

    /**
     * HEAD TAG
     * <head></head>
     * @link http://www.w3schools.com/tags/tag_head.asp WC Doc
     * @param String $CONTENT Inner contents.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function head( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<head' . $_ATTRIBUTES . '>' . $CONTENT . '</head>';
    }

    /**
     * HEADER TAG
     * <header></header>
     * @link http://www.w3schools.com/tags/tag_header.asp WC Doc
     * @param String $content Inner contents.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function header( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<header' . $_ATTRIBUTES . '>' . $CONTENT . '</header>';
    }

    /**
     * HGROUP TAG
     * <hgroup>
     * @link http://www.w3schools.com/tags/tag_hgroup.asp WC Doc
     * @param String $CONTENT Used to group heading elements.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function hgroup( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<hgroup' . $_ATTRIBUTES . '>' . $CONTENT . '</hgroup>';
    }

    /**
     * H1 TAG
     * <h1></h1>
     * @link http://www.w3schools.com/tags/tag_hn.asp WC Doc
     * @param String $CONTENT Used to define HTML headings.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function h1( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<h1' . $_ATTRIBUTES . '>' . $CONTENT . '</h1>';
    }

    /**
     * H2 TAG
     * <h2></h2>
     * @link http://www.w3schools.com/tags/tag_hn.asp WC Doc
     * @param String $CONTENT Used to define HTML headings.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function h2( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<h2' . $_ATTRIBUTES . '>' . $CONTENT . '</h2>';
    }

    /**
     * H3 TAG
     * <h3></h3>
     * @link http://www.w3schools.com/tags/tag_hn.asp WC Doc
     * @param String $CONTENT Used to define HTML headings.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function h3( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<h3' . $_ATTRIBUTES . '>' . $CONTENT . '</h3>';
    }

    /**
     * H4 TAG
     * <h4></h4>
     * @link http://www.w3schools.com/tags/tag_hn.asp WC Doc
     * @param String $CONTENT Used to define HTML headings.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function h4( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<h4' . $_ATTRIBUTES . '>' . $CONTENT . '</h4>';
    }

    /**
     * H5 TAG
     * <h5></h5>
     * @link http://www.w3schools.com/tags/tag_hn.asp WC Doc
     * @param String $CONTENT Used to define HTML headings.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function h5( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<h5' . $_ATTRIBUTES . '>' . $CONTENT . '</h5>';
    }

    /**
     * H6 TAG
     * <h6></h6>
     * @link http://www.w3schools.com/tags/tag_hn.asp WC Doc
     * @param String $CONTENT Used to define HTML headings.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function h6( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<h6' . $_ATTRIBUTES . '>' . $CONTENT . '</h6>';
    }

    /**
     * HR TAG
     * <hr>
     * @link http://www.w3schools.com/tags/tag_hn.asp WC Doc    
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function hr( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<hr' . $_ATTRIBUTES . '>';
    }

    /**
     * HTML TAG
     * <html></html>
     * @link http://www.w3schools.com/tags/tag_html.asp W3C Doc
     * @param String $CONTENT Tells the browser that this is an HTML document.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void 
     */
    public function html( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<html' . $_ATTRIBUTES . '>' . $CONTENT . '</html>';
    }

    /**
     * I TAG
     * <i></i>
     * @link http://www.w3schools.com/tags/tag_i.asp WC Doc
     * @param String $CONTENT Used to indicate a technical term, a phrase from another language, a thought, or a ship name, etc.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function i( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<i' . $_ATTRIBUTES . '>' . $CONTENT . '</i>';
    }

    /**
     * IFRAME TAG
     * <iframe></iframe>
     * @link http://www.w3schools.com/tags/tag_iframe.asp WC Doc
     * @param String $URL source of inline frame.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function iframe( $URL, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<iframe src="'.$URL.'" ' . $_ATTRIBUTES . '></iframe>';
    }

    /**
     * IMG TAG
     * <img src="url">
     * @link http://www.w3schools.com/tags/tag_img.asp WC Doc     
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function img( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<img' . $_ATTRIBUTES . ' >';
    }

    /**
     * INS TAG
     * <ins></ins>
     * @link http://www.w3schools.com/tags/tag_ins.asp WC Doc     
     * @param String $CONTENT Defines a text that has been inserted into a document.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function ins( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<ins ' . implode( ' ', $_ATTRIBUTES ) . ' >' . $CONTENT . '</ins>';
    }

    /**
     * KBD TAG
     * <kbd></kbd>
     * @link http://www.w3schools.com/tags/tag_kbd.asp WC Doc     
     * @param String $CONTENT Defines keyboard input.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function kbd( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<kbd' . $_ATTRIBUTES . '>' . $CONTENT . '</kbd>';
    }

    /**
     * MAIN TAG
     * <main></main>
     * @link http://www.w3schools.com/tags/tag_main.asp WC Doc     
     * @param String $CONTENT Specifies the main content of a document.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function main( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<main' . $_ATTRIBUTES . '>' . $CONTENT . '</main>';
    }

    /**
     * TAG MAP
     * @param Array $_IMAGE_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_IMAGE_ATTRIBUTES = array( 'usemap="#your_name"' );
     * @param Array $_MAP_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_MAP_ATTRIBUTES = array( 'name="your_name"' );
     * @param Array $_AREA_AND_ATTRIBUTES Defines number of area tags as keys and value array as attributes for each area $_AREA_AND_ATTRIBUTES[] = array( 'shape="rect"', cords="0,0,82,126", 'href="your_path"');
     * @return Void
     */
    public function map( $_IMAGE_ATTRIBUTES, $_MAP_ATTRIBUTES, $_AREA_AND_ATTRIBUTES )
    {
        $_IMAGE_ATTRIBUTES = !empty( $_IMAGE_ATTRIBUTES ) ? ' ' . implode( ' ', $_IMAGE_ATTRIBUTES ) : NULL;
        $this->html .= '<image' . $_IMAGE_ATTRIBUTES . '>';
        $_MAP_ATTRIBUTES = !empty( $_MAP_ATTRIBUTES ) ? ' ' . implode( ' ', $_MAP_ATTRIBUTES ) : NULL;
        $this->html .= '<map' . $_MAP_ATTRIBUTES . '>';
        foreach ( $_AREA_AND_ATTRIBUTES as $attr ):
            $attr = !empty( $attr ) ? ' ' . implode( ' ', $attr ) : NULL;
            $this->html .= '<area' . $attr . '>';
        endforeach;
        $this->html .= '</map>';
    }

    /**
     * MARK TAG
     * <mark></mark>
     * @link http://www.w3schools.com/tags/tag_mark.asp WC Doc     
     * @param String $CONTENT Defines marked text.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void
     */
    public function mark( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<mark' . $_ATTRIBUTES . '>' . $CONTENT . '</mark>';
    }

    /**
     * MENU TAG
     * <menu></menu>
     * @link http://www.w3schools.com/tags/tag_menu.asp WC Doc     
     * @param String $CONTENT Defines a list/menu of commands.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void
     */
    public function menu( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<menu' . $_ATTRIBUTES . '>' . $CONTENT . '</menu>';
    }

    /**
     * MENUITEM TAG
     * <menuitem></menuitem>
     * @link http://www.w3schools.com/tags/tag_menuitem.asp WC Doc     
     * @param String $CONTENT Defines a command/menu item that the user can invoke from a popup menu.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void
     */
    public function menuitem( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<menuitem' . $_ATTRIBUTES . '>' . $CONTENT . '</menuitem>';
    }

    /**
     * METER TAG
     * <meter></meter>
     * @link http://www.w3schools.com/tags/tag_meter.asp WC Doc     
     * @param String $CONTENT Defines a scalar measurement within a known range, or a fractional value. This is also known as a gauge.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void
     */
    public function meter( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<meter' . $_ATTRIBUTES . '>' . $CONTENT . '</meter>';
    }

    /**
     * NAV TAG
     * <nav></nav>
     * @link http://www.w3schools.com/tags/tag_nav.asp WC Doc     
     * @param String $CONTENT Defines a set of navigation links.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void
     */
    public function nav( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<nav' . $_ATTRIBUTES . '>' . $CONTENT . '</nav>';
    }

    /**
     * NOSCRIPT TAG
     * <noscript></noscript>
     * @link http://www.w3schools.com/tags/tag_noscript.asp WC Doc     
     * @param String $CONTENT Defines an alternate content for users that have disabled scripts in their browser or have a browser that doesn't support script.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void
     */
    public function noscript( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<noscript' . $_ATTRIBUTES . '>' . $CONTENT . '</noscript>';
    }

    /**
     * OUTPUT TAG
     * <output></output>
     * @link http://www.w3schools.com/tags/tag_output.asp WC Doc     
     * @param String $CONTENT Represents the result of a calculation (like one performed by a script).
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void
     */
    public function output( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<output' . $_ATTRIBUTES . '>' . $CONTENT . '</output>';
    }

    /**
     * P TAG
     * <p></p>
     * @link http://www.w3schools.com/tags/tag_p.asp WC Doc     
     * @param String $CONTENT Defines a paragraph.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function p( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<p' . $_ATTRIBUTES . '>' . $CONTENT . '</p>';
    }

    /**
     * PRE TAG
     * <pre></pre>
     * @link http://www.w3schools.com/tags/tag_pre.asp WC Doc     
     * @param String $CONTENT Defines preformatted text.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function pre( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<pre' . $_ATTRIBUTES . '>' . $CONTENT . '</pre>';
    }

    /**
     * PROGRESS TAG
     * <progress></progress>
     * @link http://www.w3schools.com/tags/tag_progress.asp WC Doc     
     * @param String $CONTENT Represents the progress of a task.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function progress( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<progress' . $_ATTRIBUTES . '>' . $CONTENT . '</progress>';
    }

    /**
     * Q TAG
     * <q></q>
     * @link http://www.w3schools.com/tags/tag_q.asp WC Doc     
     * @param String $CONTENT Defines a short quotation.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function q( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<q' . $_ATTRIBUTES . '>' . $CONTENT . '</q>';
    }

    /**
     * S TAG
     * <s></s>
     * @link http://www.w3schools.com/tags/tag_s.asp WC Doc     
     * @param String $CONTENT Specifies text that is no longer correct, accurate or relevant.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function s( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<s' . $_ATTRIBUTES . '>' . $CONTENT . '</s>';
    }

    /**
     * SAMP TAG
     * <samp></samp>
     * @link http://www.w3schools.com/tags/tag_samp.asp WC Doc     
     * @param String $CONTENT Defines sample output from a computer program.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function samp( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<samp' . $_ATTRIBUTES . '>' . $CONTENT . '</samp>';
    }

    /**
     * SECTION TAG
     * <section></section>
     * @link http://www.w3schools.com/tags/tag_section.asp WC Doc     
     * @param String $CONTENT Defines sections in a document, such as chapters, headers, footers, or any other sections of the document.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function section( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<section' . $_ATTRIBUTES . '>' . $CONTENT . '</section>';
    }

    /**
     * SMALL TAG
     * <small></small>
     * @link http://www.w3schools.com/tags/tag_small.asp WC Doc     
     * @param String $CONTENT Defines smaller text (and other side comments).
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' ); 
     * @return Void
     */
    public function small( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<small' . $_ATTRIBUTES . '>' . $CONTENT . '</small>';
    }

    /**
     * SPAN TAG
     * <span></span>
     * @link http://www.w3schools.com/tags/tag_span.asp WC Doc     
     * @param String $CONTENT Used to group inline-elements in a document.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function span( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<span' . $_ATTRIBUTES . '>' . $CONTENT . '</span>';
    }

    /**
     * STRONG TAG
     * <strong></strong>
     * @link http://www.w3schools.com/tags/tag_strong.asp WC Doc     
     * @param String $CONTENT Defines important text.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function strong( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<strong' . $_ATTRIBUTES . '>' . $CONTENT . '</strong>';
    }

    /**
     * SUB TAG
     * <sub></sub>
     * @link http://www.w3schools.com/tags/tag_sub.asp WC Doc     
     * @param String $CONTENT Defines subscript text
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function sub( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<sub' . $_ATTRIBUTES . '>' . $CONTENT . '</sub>';
    }

    /**
     * SUP TAG
     * <sup></sup>
     * @link http://www.w3schools.com/tags/tag_sup.asp WC Doc     
     * @param String $CONTENT Defines superscript text
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function sup( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<sup' . $_ATTRIBUTES . '>' . $CONTENT . '</sup>';
    }

    /**
     * TIME TAG
     * <time></time>
     * @link http://www.w3schools.com/tags/tag_time.asp WC Doc     
     * @param String $CONTENT Defines a human-readable date/time.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function time( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<time' . $_ATTRIBUTES . '>' . $CONTENT . '</time>';
    }

    /**
     * U TAG
     * <u></u>
     * @link http://www.w3schools.com/tags/tag_u.asp WC Doc     
     * @param String $CONTENT Represents some text that should be stylistically different from normal text,
     *  such as misspelled words or proper nouns in Chinese.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function u( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<u' . $_ATTRIBUTES . '>' . $CONTENT . '</u>';
    }

    /**
     * UL TAG
     * @link http://www.w3schools.com/tags/tag_ul.asp W3C Doc
     * @param Array $_LI_VALUES li tag values ie: $_LI_VALUES[] = 'text'
     * @param Array $_UL_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_UL_ATTRIBUTES = array( 'id="your_id"' );
     * @param Array $_LI_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie:  $_LI_ATTRIBUTES[$_LI_VALUES key] = array('id="your_id"', 'class="your_class"') <br>
     * As longs as $_LI_ATTRIBUTES has the matching key from $_LI_VALUES it will match the proper li tag with parameters.
     * @return Void
     */
    public function ul( $_LI_VALUES, $_UL_ATTRIBUTES, $_LI_ATTRIBUTES )
    {
        $_UL_ATTRIBUTES = !empty( $_UL_ATTRIBUTES ) ? ' ' . implode( ' ', $_UL_ATTRIBUTES ) : NULL;
        $this->html .= '<ul' . $_UL_ATTRIBUTES . '>';
        foreach ( $_LI_VALUES as $k => $val ):
            $attr = !empty( $_LI_ATTRIBUTES[$k] ) ? ' ' . implode( ' ', $_LI_ATTRIBUTES[$k] ) : NULL;
            $this->html .= '<li' . $attr . '>' . $val . '</li>';
        endforeach;
        $this->html .= '</ul>';
    }

    /**
     * OL TAG
     * @link http://www.w3schools.com/tags/tag_ol.asp W3C Doc
     * @param Array $_LI_VALUES li tag values ie: $_LI_VALUES[] = 'text'
     * @param Array $_OL_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_OL_ATTRIBUTES = array( 'id="your_id"' );
     * @param Array $_LI_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie:  $_LI_ATTRIBUTES[$_LI_VALUES key] = array('id="your_id"', 'class="your_class"') <br>
     * As longs as $_LI_ATTRIBUTES has the matching key from $_LI_VALUES it will match the proper li tag with parameters.
     * @return Void
     */
    public function ol( $_LI_VALUES, $_OL_ATTRIBUTES, $_LI_ATTRIBUTES )
    {
        $this->html .= '<ol ' . implode( ' ', $_OL_ATTRIBUTES ) . '>';
        foreach ( $_LI_VALUES as $k => $val ):
            $attr = !empty( $_LI_ATTRIBUTES[$k] ) ? ' ' . implode( ' ', $_LI_ATTRIBUTES[$k] ) : NULL;
            $this->html .= '<li' . $attr . '>' . $val . '</li>';
        endforeach;
        $this->html .= '</ol>';
    }

    /**
     * VAR TAG
     * <var></var>
     * @link http://www.w3schools.com/tags/tag_var.asp WC Doc     
     * @param String $CONTENT Defines a variable.     
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function var_tag( $CONTENT, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<var' . $_ATTRIBUTES . '>' . $CONTENT . '</var>';
    }

    /**
     * VIDEO TAG
     * <video><source></video>
     * @link http://www.w3schools.com/tags/tag_video.asp W3C Doc
     * @param Array $_VIDEO_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_video_attributes = array( 'controls', 'autoplay' );
     * @param Array $_SOURCE_AND_ATTRIBUTES Defines number of source tags as keys and value array as attributes $_SOURCE_AND_ATTRIBUTES[] = array( 'src="path"', type="video/ogg");
     * @return Void 
     */
    public function video( $_VIDEO_ATTRIBUTES, $_SOURCE_AND_ATTRIBUTES )
    {
        $_VIDEO_ATTRIBUTES = !empty( $_VIDEO_ATTRIBUTES ) ? ' ' . implode( ' ', $_VIDEO_ATTRIBUTES ) : NULL;
        $this->html .= '<video' . $_VIDEO_ATTRIBUTES . '>';
        foreach ( $_SOURCE_AND_ATTRIBUTES as $attr ):
            $attr = !empty( $attr ) ? ' ' . implode( ' ', $attr ) : NULL;
            $this->html .= '<source' . $attr . '>';
        endforeach;
        $this->html .= '</video>';
    }

    /**
     * WBR TAG
     * <wbr></wbr>
     * @link http://www.w3schools.com/tags/tag_wbr.asp WC Doc     
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function wbr( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<wbr' . $_ATTRIBUTES . '>';
    }

    /**
     * TODO: PUT MENU AND MENU ITEM TOGETHER.
     * MAKE UL, LI.
     * MAKE OL, LI.
     * MAKE OBJECT AND PARAM.
     * MAKE RUBY, RT, RP.
     * MAKE TRACK TO AUDIO AND VIDEO.
     */

    /**
     * GET MARKUP
     * @return string
     */
    public function getMarkup()
    {
        $return = $this->html;
        $this->html = NULL;
        return $return;
    }

}
