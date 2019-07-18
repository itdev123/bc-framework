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
 * Class Wizard
 * BriskCoder Wizard Class
 * @category BriskCoder
 * @package System
 */
final class Debugger
{

    /**
     * ERROR CODE 
     * @var Mixed $CODE Error code number in your .debug file. Call as bc::debugger()->CODE = 'your_code_key'
     */
    public $CODE,
            /**
             * PROBLEM DYNAMIC TEXT 
             * @var array $_PROBLEM Array containing all your dynamic problem text to be parsed. Call as bc::debugger()->_PROBLEM[] = "text"
             */
            $_PROBLEM,
            /**
             * SOLUTION DYNAMIC TEXT 
             * @var array $_SOLUTION Array containing all your dynamic solution text to be parsed. Call as bc::debugger()->_SOLUTION[] = "text"
             */
            $_SOLUTION;
    private $init,
            $_trace,
            $breakPoint,
            $breakPointForwardTrailing,
            $debugCode = NULL,
            $debugEditor = NULL,
            $debugType = NULL,
            $debugTitle = NULL,
            $debugProblem = NULL,
            $debugSolution = NULL,
            $debugLevel,
            $invokerNamespace,
            $invokerClass,
            $invokerMethod,
            $invokerFile = NULL,
            $invokerLine = NULL,
            $executerNamespace,
            $executerClass,
            $executerMethod,
            $executerFile,
            $executerLine,
            $_dependencies = FALSE;

    public function __construct( $CALLER, $_TRACE )
    {

        if ( $CALLER !== 'BriskCoder\bc' ):
            exit( 'Debug: Forbidden System class usage - ' . __CLASS__ );
        endif;

        if ( ob_get_level() ):
            ob_end_clean();
        endif;

        $this->_trace = $_TRACE;
        $this->traceLevels();
    }

    /**
     * CUSTOM BREAK POINT
     * @var string $MESSAGE Custom Message to render.
     * @var string $OUTPUT  0 = autodetect, 1 = print_r, 2 = var_dump  Default is 0
     * @return Void
     */
    public function breakPoint( $MESSAGE, $OUTPUT = 0 )
    {
        if ( !$this->init ):
            if ( ob_get_level() ):
                ob_end_clean();
            endif;

            ob_start();
            switch ( $OUTPUT ):
                case 1:
                    print_r( $MESSAGE );
                    break;
                case 2:
                    var_dump( $MESSAGE );
                    break;
                default:
                    if ( (array) $MESSAGE === $MESSAGE ):
                        print_r( $MESSAGE );
                    elseif ( (object) $MESSAGE === $MESSAGE ):
                        var_dump( $MESSAGE );
                    else:
                        echo $MESSAGE;
                endif;
            endswitch;
            $MESSAGE = ob_get_contents();
            ob_end_clean();


            $pathDebuggerLang = $_SERVER['DOCUMENT_ROOT'] . '/BriskCoder/Pub/Media/Language/Debugger/Debugger' . '.' . bc::$DEV_LANGUAGE . '.lang';
            $_guiLang = parse_ini_file( $pathDebuggerLang );

            $info = '<tr>
                        <th colspan="3" id="bc-wizard-debugger-info-title">' . $_guiLang['TITLE'] . '</th>
                    </tr>';


            $_parse['DEBUGGER-INFO'] = $info;

            $_parse['DEBUGGER-CALLER'] = "";

            $breakPoint = '<tr>
                        <th colspan="2" id="bc-wizard-debugger-caller-title">' . $_guiLang['BREAKPOINT'] . '</th>
                    </tr>
                    <tr>
                        <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['NAMESPACE'] . '</th>
                        <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $this->invokerNamespace . '</td>
                    </tr>
                    <tr>
                        <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['CLASS'] . '</th>
                        <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $this->invokerClass . '</td>
                    </tr>
                    <tr>
                        <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['METHOD'] . '</th>
                        <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $this->invokerMethod . '</td>
                    </tr>
                    <tr>
                        <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['FILE'] . '</th>
                        <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $this->invokerFile . '</td>
                    </tr>
                    <tr>
                        <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['LINE'] . '</th>
                        <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $this->invokerLine . '</td>
                    </tr>';

            $_parse['DEBUGGER-BREAKPOINT'] = $breakPoint;

            $ms = '<div class="bc-wizard-debugger-inner-wrapper">
                        <table class="bc-debugger-tbl" cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                                <tr>
                                    <th colspan="3" id="bc-wizard-debugger-problem-title">' . $_guiLang['MESSAGE'] . '</th>
                                </tr>
                                <tr>
                                    <td colspan="3" id="bc-wizard-debugger-problem-desc">' . $MESSAGE . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>';

            $_parse['DEBUGGER-CUSTOM-MESSAGE'] = $ms;

            $_parse['DEBUGGER-DEPENDENCIES'] = "";

            $pathDebuggerTpl = $_SERVER['DOCUMENT_ROOT'] . '/BriskCoder/Pub/Media/Template/Debugger/Debugger.html';

            $tpl = file_get_contents( $pathDebuggerTpl );
            $_pattern = array();
            $_replacement = array();

            foreach ( $_parse as $k => $v ):
                $_pattern[] = '/<!--bc.' . $k . '-->(.*?)<!--bc-->/s';
                $_replacement[] = $v;
            endforeach;

            $x = preg_replace( $_pattern, $_replacement, $tpl );

            echo $x;
            exit();
        endif;
    }

    /**
     * INVOKE DEBUGGER
     * Call BriskCoder Debugger System
     * @return Void
     */
    public function invoke()
    {
        if ( $this->init ):
            return;
        endif;
        $this->init = TRUE;


        $this->translation();
        $this->renderDebugger();
        exit;
    }

    private function traceLevels()
    {
        $this->debugLevel = 'DEBUG TRACE LEVEL UNKNOWN';
        if ( array_key_exists( 1, $this->_trace ) ):
            if ( array_key_exists( 'class', $this->_trace[1] ) ):
                $this->breakPoint = $this->_trace[1]['class'];
                $this->breakPointForwardTrailing = str_replace( '\\', '/', $this->breakPoint );


                if ( substr( $this->breakPoint, 0, 17 ) === 'BriskCoder\System' ):
                    $this->debugLevel = 'SYSTEM';
                    $this->registerLevels();
                elseif ( substr( $this->breakPoint, 0, 18 ) === 'BriskCoder\Package' ):
                    $this->debugLevel = 'PACKAGE';
                    $this->registerLevels();
                elseif ( substr( $this->breakPoint, 0, 20 ) === 'BriskCoder\External' ):
                    $this->debugLevel = 'EXTENSION';
                    $this->registerLevels();
                else:
                    $l = explode( '\\', $this->breakPoint );
                    $l = array_flip( $l );

                    if ( array_key_exists( 'Dispatcher', $l ) ):
                        $this->debugLevel = 'DISPATCHER';
                        $this->registerLevels( TRUE );
                        return;
                    endif;

                    if ( array_key_exists( 'Domain', $l ) ):
                        $this->debugLevel = 'DOMAIN';
                        $this->registerLevels( TRUE );
                        return;
                    endif;

                    if ( array_key_exists( 'Model', $l ) ):
                        $this->debugLevel = 'MODEL';
                        $this->registerLevels( TRUE );
                        return;
                    endif;

                    if ( array_key_exists( 'Subroutine', $l ) ):
                        $this->debugLevel = 'SUBROUTINE';
                        $this->registerLevels( TRUE );
                        return;
                    endif;

                    //call unknown level error page
                    exit( $this->debugLevel );
                endif;
                return;
            endif;
        endif;
        //call unknown level error page
        exit( $this->debugLevel );
    }

    private function registerLevels( $isApp = FALSE )
    {
        $this->invokerNamespace = str_replace( '/', '\\', substr_replace( $this->breakPointForwardTrailing, '', strlen( $this->breakPointForwardTrailing ) - strlen( basename( $this->breakPointForwardTrailing ) ) - 1 ) );
        $this->invokerClass = basename( $this->breakPointForwardTrailing );
        $this->invokerMethod = $this->_trace[1]['function'];


        if ( isset( $this->_trace[2]['class'] ) ):
            $ClassfwTrailing = str_replace( '\\', '/', $this->_trace[2]['class'] );
            $this->executerNamespace = str_replace( '/', '\\', substr_replace( $ClassfwTrailing, '', strlen( $ClassfwTrailing ) - strlen( basename( $ClassfwTrailing ) ) - 1 ) );
            $this->executerClass = basename( $ClassfwTrailing );
            $this->executerMethod = $this->_trace[2]['function'];
            $this->executerFile = $this->_trace[1]['file'];
            $this->executerLine = $this->_trace[1]['line'];
        endif;

        if ( $isApp ):
            $this->invokerFile = $this->_trace[0]['file'];
            $this->invokerLine = $this->_trace[0]['line'];
            return;
        endif;

        $c = count( $this->_trace );

        for ( $i = 3; $i <= $c; $i++ ):
            if ( !array_key_exists( $i, $this->_trace ) ):
                break;
            endif;

            if ( !array_key_exists( 'class', $this->_trace[$i] ) ):
                break;
            endif;
            if ( $this->_trace[$i]['class'] === 'BriskCoder\System\Router' ):
                break;
            endif;

            $ClassfwTrailing = str_replace( '\\', '/', $this->_trace[$i]['class'] );
            $this->_dependencies[] = array(
                'namespace' => str_replace( '/', '\\', substr_replace( $ClassfwTrailing, '', strlen( $ClassfwTrailing ) - strlen( basename( $ClassfwTrailing ) ) - 1 ) ),
                'class' => basename( $ClassfwTrailing ),
                'method' => $this->_trace[$i]['function'],
                'file' => $this->_trace[$i - 1]['file'],
                'line' => $this->_trace[$i - 1]['line']
            );
        endfor;
    }

    private function translation()
    {
        foreach ( bc::registry()->_LANGUAGES as $_language ):
            if ( strtolower( $_language['languages_tag'] ) == strtolower( bc::$DEV_LANGUAGE ) ):
                bc::$DEV_LANGUAGE = 'en-us';
            endif;
        endforeach;

        switch ( $this->debugLevel ):
            case 'SYSTEM':
            case 'PACKAGE':
            case 'EXTENSION':
                $pathDebugFile = BC_PRIVATE_PATH . $this->breakPointForwardTrailing . '/' . basename( $this->breakPointForwardTrailing ) . '.' . bc::$DEV_LANGUAGE . '.debug';
                break;
            default:
                $pathDebugFile = BC_PRIVATE_PATH . bc::registry()->PROJECT_PACKAGE . '/Logic/' . $this->breakPointForwardTrailing . '/' . basename( $this->breakPointForwardTrailing ) . '.' . bc::$DEV_LANGUAGE . '.debug';
                if ( !is_file( $pathDebugFile ) ):
                    $pathDebugFile = BC_PRIVATE_PATH . bc::registry()->PROJECT_PACKAGE . '/Logic/' . $this->breakPointForwardTrailing . '.' . bc::$DEV_LANGUAGE . '.debug';
            endif;
        endswitch;

        $_translatedErrors = NULL;
        if ( is_file( $pathDebugFile ) ):
            $_translatedErrors = parse_ini_file( $pathDebugFile, TRUE );
        endif;
        if ( (array) $_translatedErrors === $_translatedErrors ):
            if ( array_key_exists( $this->CODE, $_translatedErrors ) ):
                $_keys[] = 'EDITOR';
                $_keys[] = 'TYPE';
                $_keys[] = 'TITLE';
                $_keys[] = 'PROBLEM';
                $_keys[] = 'SOLUTION';

                foreach ( $_keys as $v ):
                    if ( !array_key_exists( $v, $_translatedErrors[$this->CODE] ) ):
                        $_translatedErrors[$this->CODE][$v] = NULL;
                    endif;
                endforeach;

                $this->debugCode = $this->CODE;
                $this->debugEditor = $_translatedErrors[$this->CODE]['EDITOR'];
                $this->debugType = strtoupper( 'BRISKCODER_' . preg_replace( '/\s|-/', '_', $_translatedErrors[$this->CODE]['TYPE'] ) );
                $this->debugTitle = $_translatedErrors[$this->CODE]['TITLE'];

                if ( (array) $this->_PROBLEM === $this->_PROBLEM ):
                    if ( $_translatedErrors[$this->CODE]['PROBLEM'] != NULL ):
                        foreach ( $this->_PROBLEM as $k => $v ):
                            $search[] = '{' . $k . '}';
                            $replace[] = '<span class="debug-problem-var">' . $v . '</span>';
                        endforeach;
                        $this->debugProblem = str_replace( $search, $replace, $_translatedErrors[$this->CODE]['PROBLEM'] );
                    endif;
                else:
                    $this->debugProblem = $_translatedErrors[$this->CODE]['PROBLEM'];
                endif;
                unset( $search, $replace );

                if ( (array) $this->_SOLUTION === $this->_SOLUTION ):
                    if ( $_translatedErrors[$this->CODE]['SOLUTION'] != NULL ):
                        foreach ( $this->_SOLUTION as $k => $v ):
                            $search[] = '{' . $k . '}';
                            $replace[] = '<span class="debug-solution-var">' . $v . '</span>';
                        endforeach;
                        $this->debugSolution = str_replace( $search, $replace, $_translatedErrors[$this->CODE]['SOLUTION'] );
                    endif;
                else:
                    $this->debugSolution = $_translatedErrors[$this->CODE]['SOLUTION'];
                endif;
                unset( $search, $replace );
            endif;
        endif;
    }

    private function renderDebugger()
    {
        $_parse = array();
        $pathDebuggerLang = $_SERVER['DOCUMENT_ROOT'] . '/BriskCoder/Pub/Media/Language/Debugger/Debugger' . '.' . bc::$DEV_LANGUAGE . '.lang';

        $_guiLang = parse_ini_file( $pathDebuggerLang );

        $info = '<tr>
                    <th colspan="3" id="bc-wizard-debugger-info-title">' . $this->debugTitle . '</th>
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
                    <td class="bc-wizard-debugger-info-subtitle-cell">' . $this->debugLevel . '</td>
                    <td class="bc-wizard-debugger-info-subtitle-cell">' . $this->debugCode . '</td>
                    <td class="bc-wizard-debugger-info-subtitle-cell">' . $this->debugType . '</td>
                </tr>
                <tr>
                    <td colspan="3" class="bc-debugger-tbl-line-spacer"></td>
                </tr>';
        if ( $this->debugProblem ):
            $info .= '<tr>
                                <th colspan="3" id="bc-wizard-debugger-problem-title">' . $_guiLang['PROBLEM'] . '</th>
                            </tr>
                            <tr>
                                <td colspan="3" id="bc-wizard-debugger-problem-desc">' . $this->debugProblem . '</td>
                            </tr>';
        endif;

        if ( $this->debugSolution ):
            $info .= '<tr>
                                <th colspan="3" id="bc-wizard-debugger-solution-title">' . $_guiLang['SOLUTION'] . '</th>
                            </tr>
                            <tr>
                                <td colspan="3" id="bc-wizard-debugger-solution-desc">' . $this->debugSolution . '</td>
                            </tr>';
        endif;


        $_parse['DEBUGGER-INFO'] = $info;

        $caller = '<tr>
                        <th colspan="2" id="bc-wizard-debugger-caller-title">' . $_guiLang['CALLER'] . '</th>
                    </tr>
                    <tr>
                        <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['NAMESPACE'] . '</th>
                        <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $this->invokerNamespace . '</td>
                    </tr>
                    <tr>
                        <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['CLASS'] . '</th>
                        <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $this->invokerClass . '</td>
                    </tr>
                    <tr>
                        <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['METHOD'] . '</th>
                        <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $this->invokerMethod . '</td>
                    </tr>';
        if ( $this->debugLevel === 'Application' ):
            $caller .='<tr>
                            <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['FILE'] . '</th>
                            <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $this->invokerFile . '</td>
                        </tr>
                        <tr>
                            <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['LINE'] . '</th>
                            <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $this->invokerLine . '</td>
                        </tr>';
        endif;

        $_parse['DEBUGGER-CALLER'] = $caller;

        $breakPoint = "";
        if ( $this->executerNamespace ):

            $breakPoint = '<tr>
                                <th colspan="2" id="bc-wizard-debugger-breakpoint-title">' . $_guiLang['BREAKPOINT'] . '</th>
                            </tr>
                            <tr>
                                <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['NAMESPACE'] . '</th>
                                <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $this->executerNamespace . '</td>
                            </tr>
                            <tr>
                                <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['CLASS'] . '</th>
                                <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $this->executerClass . '</td>
                            </tr>
                            <tr>
                                <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['METHOD'] . '</th>
                                <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $this->executerMethod . '</td>
                            </tr>
                            <tr>
                                <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['FILE'] . '</th>
                                <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $this->executerFile . '</td>
                            </tr>
                            <tr>
                                <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['LINE'] . '</th>
                                <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $this->executerLine . '</td>
                            </tr>';

        endif;

        $_parse['DEBUGGER-BREAKPOINT'] = $breakPoint;

        $dependencies = "";
        if ( $this->_dependencies !== FALSE ):
            $dependencies = '<tr>
                            <th colspan="2" id="bc-wizard-debugger-dependencies-title">' . $_guiLang['DEPENDENCIES'] . '</th>
                        </tr>';
            foreach ( $this->_dependencies as $k => $v ):
                $dependencies .= '<tr>
                                    <th class="bc-wizard-debugger-tbl-number">' . ($k + 1) . '</th>
                                    <td class="bc-wizard-debugger-tbl-subtitle-cell"></td>
                                </tr>
                                <tr>
                                    <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['NAMESPACE'] . '</th>
                                    <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $v['namespace'] . '</td>
                                </tr>
                                <tr>
                                    <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['CLASS'] . '</th>
                                    <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $v['class'] . '</td>
                                </tr>
                                <tr>
                                    <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['METHOD'] . '</th>
                                    <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $v['method'] . '</td>
                                </tr>
                                <tr>
                                    <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['FILE'] . '</th>
                                    <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $v['file'] . '</td>
                                </tr>
                                <tr>
                                    <th class="bc-wizard-debugger-tbl-subtitle">' . $_guiLang['LINE'] . '</th>
                                    <td class="bc-wizard-debugger-tbl-subtitle-cell">' . $v['line'] . '</td>
                                </tr>';

            endforeach;
        endif;

        $_parse['DEBUGGER-DEPENDENCIES'] = $dependencies;


        $pathDebuggerTpl = $_SERVER['DOCUMENT_ROOT'] . '/BriskCoder/Pub/Media/Template/Debugger/Debugger.html';


        $tpl = file_get_contents( $pathDebuggerTpl );

        $_pattern = array();
        $_replacement = array();

        foreach ( $_parse as $k => $v ):
            $_pattern[] = '/<!--bc.' . $k . '-->(.*?)<!--bc-->/s';
            $_replacement[] = $v;
        endforeach;

        $x = preg_replace( $_pattern, $_replacement, $tpl );

        echo $x;
    }

}
