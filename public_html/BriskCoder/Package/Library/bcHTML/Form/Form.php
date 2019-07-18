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

class Form
{

    private $html = NULL;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Library\bcHTML' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * BUTTON TAG TYPE BUTTON
     * <button type="button"></button>
     * @link http://www.w3schools.com/tags/att_button_type.asp W3C Doc
     * @param String $VALUE Value of element
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function button( $VALUE, $_ATTRIBUTES = array() )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<button type="button"' . $_ATTRIBUTES . '>' . $VALUE . '</button>';
    }

    /**
     * INPUT TAG TYPE CHECKBOX
     * <input type="checkbox"></input> 
     * @link http://www.w3schools.com/tags/att_input_type.asp W3C Doc
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function checkbox( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<input type="checkbox"' . $_ATTRIBUTES . '>';
    }

    /**
     * DATALIST TAG
     * <input list="name"><datalist><option></datalist>
     * @link http://www.w3schools.com/tags/tag_datalist.asp W3C Doc
     * @param String $LIST Input List name reference for datalist <input list="your_name">
     * @param Array $_LIST_ATTRIBUTES Input List attributes ie: $_LIST_ATTRIBUTES = array( 'name="your_name"' );
     * @param Array $_DATALIST_VALUES Detalist options ie: $_DATALIST_VALUES[] = 'value' 
     * @param Array $_DATALIST_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_DATALIST_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function datalist( $LIST, $_LIST_ATTRIBUTES, $_DATALIST_VALUES, $_DATALIST_ATTRIBUTES )
    {
        $_LIST_ATTRIBUTES = !empty( $_LIST_ATTRIBUTES ) ? ' ' . implode( ' ', $_LIST_ATTRIBUTES ) : NULL;
        $this->html .= '<input list="' . $LIST . '"' . $_LIST_ATTRIBUTES . '>';
        $_DATALIST_ATTRIBUTES = !empty( $_DATALIST_ATTRIBUTES ) ? ' ' . implode( ' ', $_DATALIST_ATTRIBUTES ) : NULL;
        $this->html .= '<datalist' . $_DATALIST_ATTRIBUTES . '>';
        foreach ( $_DATALIST_VALUES as $val ):
            $this->html .= '<option value="' . $val . '">';
        endforeach;
        $this->html .= '</datalist>';
    }

    /**
     * INPUT TAG TYPE EMAIL
     * @link http://www.w3schools.com/tags/att_input_type.asp W3C Doc
     * @param array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function email( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<input type="email"' . $_ATTRIBUTES . '>';
    }

    /**
     * FIELDSET TAG OPENNING
     * <fieldset><legend></legend>Content</fieldset>
     * @link http://www.w3schools.com/tags/tag_fieldset.asp W3C Doc
     * @param String $LEGEND Fieldset legend
     * @param String $CONTENT Fieldset content
     * @param Array $_FIELDSET_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_FIELDSET_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function fieldset( $LEGEND, $CONTENT, $_FIELDSET_ATTRIBUTES )
    {
        $_FIELDSET_ATTRIBUTES = !empty( $_FIELDSET_ATTRIBUTES ) ? ' ' . implode( ' ', $_FIELDSET_ATTRIBUTES ) : NULL;
        $this->html .= '<fieldset' . $_FIELDSET_ATTRIBUTES . '>';
        $this->html .= '<legend> ' . $LEGEND . '</legend>';
        $this->html .= $CONTENT;
        $this->html .= '</fieldset>';
    }

    /**
     * INPUT TAG TYPE FILE
     * @link http://www.w3schools.com/tags/att_input_type.asp W3C Doc
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function file( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<input type="file"' . $_ATTRIBUTES . '>';
    }

    /**
     * FORM TAG OPENNING
     * @link http://www.w3schools.com/tags/tag_form.asp W3C Doc
     * @param String $CONTENT Fieldset content
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function form( $CONTENT, $_ATTRIBUTES = array() )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<form' . $_ATTRIBUTES . '>' . $CONTENT . '</form>';
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
     * INPUT TAG TYPE HIDDEN
     * @link http://www.w3schools.com/tags/att_input_type.asp W3C Doc
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function hidden( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<input type="hidden"' . $_ATTRIBUTES . '>';
    }

    /**
     * KEYGEN TAG
     * <keygen name="security">
     * @link http://www.w3schools.com/tags/tag_keygen.asp WC Doc     
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' ); 
     * @return Void
     */
    public function keygen( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<keygen' . $_ATTRIBUTES . '>';
    }

    /**
     * LABEL TAG
     * @link http://www.w3schools.com/tags/tag_label.asp W3C Doc
     * @param String $FOR Binds label to specific element
     * @param String $LABEL Label text
     * @param array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function label( $FOR, $LABEL, $_ATTRIBUTES = array() )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<label for="' . $FOR . '"' . $_ATTRIBUTES . '>' . $LABEL . '</label>';
    }

    /**
     * INPUT TAG TYPE NUMBER
     * @link http://www.w3schools.com/tags/att_input_type.asp W3C Doc
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function number( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<input type="number"' . $_ATTRIBUTES . '>';
    }

    /**
     * INPUT TAG TYPE PASSWORD
     * @link http://www.w3schools.com/tags/att_input_type.asp W3C Doc
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function password( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<input type="password"' . $_ATTRIBUTES . '>';
    }

    /**
     * INPUT TAG TYPE RADIO
     * @link http://www.w3schools.com/tags/att_input_type.asp W3C Doc
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function radio( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<input type="radio"' . $_ATTRIBUTES . '>';
    }

    /**
     * INPUT TAG TYPE RANGE
     * @link http://www.w3schools.com/tags/att_input_type.asp W3C Doc
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function range( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<input type="range"' . $_ATTRIBUTES . '>';
    }

    /**
     * BUTTON TAG TYPE RESET
     * @link http://www.w3schools.com/tags/att_button_type.asp W3C Doc
     * @param String $VALUE Value of an input element
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function reset( $VALUE, $_ATTRIBUTES = array() )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<button type="reset"' . $_ATTRIBUTES . '>' . $VALUE . '</button>';
    }

    /**
     * TAG SELECT
     * @link http://www.w3schools.com/tags/tag_select.asp W3C Doc
     * @param Array $_OPTIONS Select options ie: $_OPTIONS[value] = 'text' || if setting optGroup then <br>
     * $_OPTIONS[optGroup_label] = array( value => 'text'), if array value is identified as array type the optgroup is set.
     * @param Array $_SELECT_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_attributes = array( 'id="your_id"' );
     * @param Array $_OPTION_ATTRIBUTES Options & optgroup attributes ie:  $_OPTION_ATTRIBUTES[$_OPTIONS key] = array('disabled="disabled"', 'label="your_label"') <br>
     * As longs as $_OPTION_ATTRIBUTES has the matching key from $_OPTIONS it works for optgroup parameters and option parameters.
     * @return Void
     */
    public function select( $_OPTIONS, $_SELECT_ATTRIBUTES, $_OPTION_ATTRIBUTES )
    {
        $_SELECT_ATTRIBUTES = !empty( $_SELECT_ATTRIBUTES ) ? ' ' . implode( ' ', $_SELECT_ATTRIBUTES ) : NULL;
        $this->html .= '<select' . $_SELECT_ATTRIBUTES . '>';
        foreach ( $_OPTIONS as $val => $text ):
            if ( (array) $text === $text ):
                $option_attributes = !empty( $_OPTION_ATTRIBUTES[$val] ) ? ' ' . implode( ' ', $_OPTION_ATTRIBUTES[$val] ) : NULL;
                $this->html .= '<optgroup  label="' . $val . '"' . $option_attributes . '>';
                foreach ( $text as $v => $t ):
                    $option_attributes = !empty( $_OPTION_ATTRIBUTES[$v] ) ? ' ' . implode( ' ', $_OPTION_ATTRIBUTES[$v] ) : NULL;
                    $this->html .= '<option value="' . $v . '"' . $option_attributes . '>' . $t . '</option>';
                endforeach;
                $this->html .= '</optgroup>';
                continue;
            endif;
            $option_attributes = !empty( $_OPTION_ATTRIBUTES[$val] ) ? ' ' . implode( ' ', $_OPTION_ATTRIBUTES[$val] ) : NULL;
            $this->html .= '<option value="' . $val . '"' . $option_attributes . '>' . $text . '</option>';
        endforeach;
        $this->html .= '</select>';
    }

    /**
     * BUTTON TAG TYPE SUBMIT
     * @link http://www.w3schools.com/tags/att_button_type.asp W3C Doc
     * @param String $VALUE Value of an input element
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function submit( $VALUE, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<button type="submit"' . $_ATTRIBUTES . '>' . $VALUE . '</button>';
    }

    /**
     * INPUT TAG TYPE TEL
     * @link http://www.w3schools.com/tags/att_input_type.asp W3C Doc
     * @param array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function tel( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<input type="tel"' . $_ATTRIBUTES . '>';
    }

    /**
     * INPUT TAG TYPE TEXT
     * @link http://www.w3schools.com/tags/att_input_type.asp W3C Doc
     * @param array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void
     */
    public function text( $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<input type="text"' . $_ATTRIBUTES . '>';
    }

    /**
     * TEXTAREA TAG
     * @link http://www.w3schools.com/tags/tag_textarea.asp W3C Doc
     * @param String $VALUE Value of an input element
     * @param Array $_ATTRIBUTES HTML global attributes and specific ones related to this tag, ie: $_ATTRIBUTES = array( 'id="your_id"' );
     * @return Void 
     */
    public function textarea( $VALUE, $_ATTRIBUTES )
    {
        $_ATTRIBUTES = !empty( $_ATTRIBUTES ) ? ' ' . implode( ' ', $_ATTRIBUTES ) : NULL;
        $this->html .= '<textarea' . $_ATTRIBUTES . '>' . $VALUE . '</textarea>';
    }

}
