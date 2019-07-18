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

class Table
{

    private $html = NULL,
            $buffer = NULL;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Library\bcHTML' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * CAPTION TAG
     * <caption></caption>
     * @link http://www.w3schools.com/tags/tag_caption.asp W3C Doc
     * @param String $CONTENT Defines a table caption.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void 
     */
    public function caption( $CONTENT, $_ATTRIBUTES = array() )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<caption' . $_ATTRIBUTES . '>' . $CONTENT . '</caption>';
    }

    /**
     * COLGROUP TAG
     * <colgroup><col></colsgroup>
     * @link http://www.w3schools.com/tags/tag_colgroup.asp W3C Doc
     * @param Array $_COLGROUP_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_COLGROUP_ATTRIBUTES = array( 'id="your_id"' );
     * @param Array $_COLS_AND_ATTRIBUTES Defines number of cols as keys and value array as attributes $_COLS_AND_ATTRIBUTES[] = array( 'span="2"', class="your_class");
     * @return Void 
     */
    public function colgroup( $_COLGROUP_ATTRIBUTES = array(), $_COLS_AND_ATTRIBUTES = array() )
    {
        $_COLGROUP_ATTRIBUTES = !empty( $_COLGROUP_ATTRIBUTES ) ? ' ' . implode( ' ', $_COLGROUP_ATTRIBUTES ) : NULL;
        $this->html .= '<colgroup' . $_COLGROUP_ATTRIBUTES . '>';
        foreach ( $_COLS_AND_ATTRIBUTES as $attr ):
            $attr = !empty( $attr ) ? ' ' . implode( ' ', $attr ) : NULL;
            $this->html .= '<col' . $attr . '>';
        endforeach;
        $this->html .= '</colgroup>';
    }

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

    /**
     * TABLE TAG
     * <table></table>
     * @link http://www.w3schools.com/tags/tag_table.asp W3C Doc
     * @param String $CONTENT Defines an HTML table.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function table( $CONTENT, $_ATTRIBUTES = array() )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<table' . $_ATTRIBUTES . '>' . $CONTENT . '</table>';
    }

    /**
     * TBODY TAG
     * <tbody></tbody>
     * @link http://www.w3schools.com/tags/tag_tbody.asp W3C Doc
     *  @param String $CONTENT Used to group the body content in an HTML table.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function tbody( $CONTENT, $_ATTRIBUTES = array() )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<tbody' . $_ATTRIBUTES . '>' . $CONTENT . '</tbody>';
    }

    /**
     * TD TAG
     * <td>
     * @link http://www.w3schools.com/tags/tag_td.asp W3C Doc
     * @param String $CONTENT td content
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function td( $CONTENT, $_ATTRIBUTES = array() )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<td' . $_ATTRIBUTES . '>' . $CONTENT . '</td>';
    }

    /**
     * TFOOT TAG
     * <tfoot></tfoot>
     * @link http://www.w3schools.com/tags/tag_tfoot.asp W3C Doc
     * @param String $CONTENT Used to group footer content in an HTML table.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function tfoot( $CONTENT, $_ATTRIBUTES = array() )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<tfoot' . $_ATTRIBUTES . '>' . $CONTENT . '</tfoot>';
    }

    /**
     * TH TAG
     * <th>
     * @link http://www.w3schools.com/tags/tag_th.asp W3C Doc
     * @param String $CONTENT th content
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function th( $CONTENT, $_ATTRIBUTES = array() )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<th' . $_ATTRIBUTES . '>' . $CONTENT . '</th>';
    }

    /**
     * THEAD TAG
     * <thead></thead>
     * @link http://www.w3schools.com/tags/tag_thead.asp W3C Doc
     * @param String $CONTENT Used to group header content in an HTML table.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function thead( $CONTENT, $_ATTRIBUTES = array() )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<thead' . $_ATTRIBUTES . '>' . $CONTENT . '</thead>';
    }

    /**
     * TR TAG 
     * <tr></tr>
     * @link http://www.w3schools.com/tags/tag_tr.asp W3C Doc
     *  @param String $CONTENT Defines a row in an HTML table.
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function tr( $CONTENT, $_ATTRIBUTES = array() )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<tr' . $_ATTRIBUTES . '>' . $CONTENT . '</tr>';
    }

}
