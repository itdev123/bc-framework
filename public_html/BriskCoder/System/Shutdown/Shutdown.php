<?php

/**
 * BriskCoder
 *
 * NOTICE OF LICENSE
 * 
 * @category    BriskCoder
 * @package     System
 * @internal    Xpler Corporation Staff Only
 * @copyright   Copyright (c) 2010 Xpler Corporation. (http://www.xpler.com)
 * @license     http://www.codebrisker.com/license/  proprietary license, All rights reserved.
 */

namespace BriskCoder\System;

use BriskCoder\bc;

/**
 * Class Debugger
 * BriskCoder Debug Class
 * @category BriskCoder
 * @package System
 */
final class Shutdown
{

    /**
     * core Function
     * @param string $CALLER
     * @return mixed
     */
    public static function coreDebugger( $CALLER )
    {

        if ( $CALLER !== __FUNCTION__ ):
            return;
        endif;

        $error = error_get_last();

        //if no errors then it was invoked by an exit and not a php core error
        if ( !$error ):
            return;
        endif;

        //Since we have an error clear any buffer since $error is already loaded.
        if ( ob_get_level() ):
            ob_end_clean();
        endif;

        $action = 0;
        switch ( $error['type'] ):
            case \E_ERROR:
                $CODE = 1;
                $TYPE = 'E_ERROR';
                $INFO = 'FATAL RUN-TIME ERROR';
                $action = 2;
                break;
            case \E_WARNING:
                $CODE = 2;
                $TYPE = 'E_WARNING';
                $INFO = 'RUN-TIME WARNING';
                $action = 1;
                break;
            case \E_PARSE:
                $CODE = 4;
                $TYPE = 'E_PARSE';
                $INFO = 'COMPILE-TIME PARSE ERROR';
                break;
            case \E_NOTICE:
                $CODE = 8;
                $TYPE = 'E_NOTICE';
                $INFO = 'RUN-TIME NOTICE';
                break;
            case \E_CORE_ERROR:
                $CODE = 16;
                $TYPE = 'E_CORE_ERROR';
                $INFO = 'FATAL PHP STARTUP ERROR';
                $action = 2;
                break;
            case \E_CORE_WARNING:
                $CODE = 32;
                $TYPE = 'E_CORE_WARNING';
                $INFO = 'WARNING PHP STARTUP ERROR';
                $action = 2;
                break;
            case \E_COMPILE_ERROR:
                $CODE = 64;
                $TYPE = 'E_COMPILE_ERROR';
                $INFO = 'FATAL COMPILE-TIME ERROR';
                break;
            case \E_COMPILE_WARNING:
                $CODE = 128;
                $TYPE = 'E_COMPILE_WARNING';
                $INFO = 'COMPILE-TIME WARNING';
                break;
            case \E_USER_ERROR:
                $CODE = 256;
                $TYPE = 'E_USER_ERROR';
                $INFO = 'DEVELOPER\'S ERROR MESSAGE';
                break;
            case \E_USER_WARNING:
                $CODE = 512;
                $TYPE = 'E_USER_WARNING';
                $INFO = 'DEVELOPER\'S WARNING MESSAGE';
                break;
            case \E_USER_NOTICE:
                $CODE = 1024;
                $TYPE = 'E_USER_NOTICE';
                $INFO = 'DEVELOPER\'S NOTICE MESSAGE';
                break;
            case \E_STRICT:
                $CODE = 2048;
                $TYPE = 'E_STRICT';
                $INFO = 'PHP\'S CORE CODE STANDARDS ADVICE';
                break;
            case \E_RECOVERABLE_ERROR:
                $CODE = 4096;
                $TYPE = 'E_RECOVERABLE_ERROR';
                $INFO = 'CATCHABLE FATAL ERROR';
                break;
            case \E_DEPRECATED:
                $CODE = 8192;
                $TYPE = 'E_DEPRECATED';
                $INFO = 'DEPRECATED API USAGE';
                break;
            case \E_USER_DEPRECATED:
                $CODE = 16384;
                $TYPE = 'E_USER_DEPRECATED';
                $INFO = 'DEVELOPER\'S DEPRECATED MESSAGE';
                break;
        endswitch;

        $EDITOR = TRUE;
        if ( $action === 1 ):
            $matches = array();
            $x = preg_match_all( '/called in(.*?)on line(.[0-9]+)/si', $error['message'], $matches );
            if ( $x != 0 && array_key_exists( 1, $matches ) && array_key_exists( 2, $matches ) ):
                $FILE = $matches[1][0];
                $LINE = $matches[2][0]; // need offer editor button
                $search[] = 'called in' . $FILE;
                $search[] = 'on line' . $LINE;
                $MESSAGE = str_replace( $search, ' ', $error['message'] );
            else:
                $FILE = $error['file'];
                $LINE = $error['line']; // need offer editor button
                $MESSAGE = $error['message'];
            endif;
        elseif ( $action === 2 ):
            $FILE = $error['file'];
            $LINE = $error['line'];
            $MESSAGE = $error['message'];
            $EDITOR = FALSE;
        else:
            $FILE = $error['file'];
            $LINE = $error['line']; // need offer editor button
            $MESSAGE = $error['message'];
        endif;

        $ERRORS = array(
            'CODE' => $CODE,
            'TYPE' => $TYPE,
            'INFO' => $INFO,
            'MESSAGE' => $MESSAGE,
            'FILE' => $FILE,
            'LINE' => $LINE
        );

        //call debug backtrace and find EXECUTER class
        //here will call the wizard GUI
        //when is LIVE_MODE TRUE them we need to add erros on log system
        //TODO above line
        $_parse = array();
        foreach ( bc::registry()->_LANGUAGES as $_language ):
            if ( strtolower( $_language['languages_tag'] ) == strtolower( bc::$DEV_LANGUAGE ) ):
                bc::$DEV_LANGUAGE = 'en-us';
            endif;
        endforeach;

        $pathDebuggerLang = $_SERVER['DOCUMENT_ROOT'] . '/BriskCoder/Pub/Media/Language/Debugger/CoreDebugger' . '.' . bc::$DEV_LANGUAGE . '.lang';
        $_guiLang = parse_ini_file( $pathDebuggerLang );

        $info = '<tr>
                    <th colspan="3" id="bc-wizard-debugger-info-title">' . $ERRORS['INFO'] . ' - ' . $ERRORS['MESSAGE'] . '</th>
                </tr>
                <tr>
                    <td colspan="3" class="bc-debugger-tbl-line-spacer"></td>
                </tr>
                <tr>
                    <th class="bc-wizard-debugger-info-subtitle">' . $_guiLang['LEVEL'] . '</th>
                    <th class="bc-wizard-debugger-info-subtitle">' . $_guiLang['CODE'] . '</th>
                    <th class="bc-wizard-debugger-info-subtitle">' . $_guiLang['TYPE'] . '</th>
                </tr>
                <tr>
                    <td class="bc-wizard-debugger-info-subtitle-cell">PHP CORE</td>
                    <td class="bc-wizard-debugger-info-subtitle-cell">' . $ERRORS['CODE'] . '</td>
                    <td class="bc-wizard-debugger-info-subtitle-cell">' . $ERRORS['TYPE'] . '</td>
                </tr>';

        $_parse['DEBUGGER-INFO'] = $info;

        $breakPoint = '<tr>
                            <th colspan="2" id="bc-wizard-debugger-breakpoint-title">' . $_guiLang['BREAKPOINT'] . '</th>
                        </tr>
                        <tr>
                            <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['FILE'] . '</th>
                            <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $ERRORS['FILE'] . '</td>
                        </tr>
                        <tr>
                            <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['LINE'] . '</th>
                            <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $ERRORS['LINE'] . '</td>
                        </tr>';

        $_parse['DEBUGGER-BREAKPOINT'] = $breakPoint;


        $pathDebuggerTpl = $_SERVER['DOCUMENT_ROOT'] . '/BriskCoder/Pub/Media/Template/Debugger/CoreDebugger.html';
        $tpl = file_get_contents( $pathDebuggerTpl );

        $_pattern = array();
        $_replacement = array();

        foreach ( $_parse as $k => $v ):
            $_pattern[] = '/<!--bc.' . $k . '-->(.*?)<!--bc-->/s';
            $_replacement[] = $v;
        endforeach;

        $tpl = preg_replace( $_pattern, $_replacement, $tpl );
        echo $tpl;
    }

    
}
