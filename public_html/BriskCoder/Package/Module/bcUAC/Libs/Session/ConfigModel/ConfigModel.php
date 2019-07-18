<?php
namespace BriskCoder\Package\Module\bcUAC\Libs\Session;

use BriskCoder\Package\Module\bcUAC\Libs\Session\ConfigModel\TableSession;

final class ConfigModel
{
    public 
            /**
             * bcDB Connection NAMESPACE
             * Used with bcDB Library only
             * @var string $bcDB_NS
             */
            $bcDB_NS,
            
             /**
             * TABLE uac_sessions
             * Execute bcDB::architect after creating module tables then 
             * invoke BriskCoder\Priv\Schema to assign values.
             */
            $tbl_uac_sessions;
            
    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Session' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }
    
    /**
     * Table Session Columns
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Session\ConfigModel\TableSession
     */
    public function uac_session()
    {
        static $sess;
        return ( $sess instanceof TableSession ) ? $sess : $sess = new TableSession( __CLASS__ );
    }
}