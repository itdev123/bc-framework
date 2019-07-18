<?php
namespace BriskCoder\Package\Module\bcUAC\Libs\Session\Model;

use BriskCoder\Package\Module\bcUAC,
    BriskCoder\Package\Library\bcDB;

final class mysql implements \SessionHandlerInterface
{
    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\Session' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }
    public function open( $save_path, $session_id ){}
    public function close(){}

    public function read($sid)
    {

        $db = bcUAC::session()->configModel();
        bcDB::connection( $db->bcDB_NS );
        $sql = bcDB::sql();
        $sql->setFetch()->typeNum();
        $stmt = 'SELECT ' . 
                $db->uac_session()->data .
                ' FROM ' . 
                $db->tbl_uac_sessions .
                ' WHERE ' .
                $db->uac_session()->id. '=' . $sql->quote($sid);
        try{    
            $sql->query($stmt);
            $_data = $sql->fetchRow();
            return $_data[0];
        }catch(\PDOException $e){
            //todo debug system based upon user choices
            // ie: send e-mail... write log etc
            bcDB::throwError($e->getMessage());
        }
    }
    
    public function write($sid, $data)
    {
        $db = bcUAC::session()->configModel();
        bcDB::connection( $db->bcDB_NS );
        $sql = bcDB::sql();
        $data = $sql->quote($data);
        $stmt = 'INSERT INTO ' . $db->tbl_uac_sessions .
            ' (' . $db->uac_session()->id . ', ' .  
                   $db->uac_session()->data . ', ' .
                   $db->uac_session()->last_activity . 
            ') VALUES (' . $sql->quote($sid) . ', ' . $data . ', ' . $_SERVER['REQUEST_TIME'] . ') ON DUPLICATE KEY UPDATE ' .
            $db->uac_session()->data . '=' . $data . ', ' .
            $db->uac_session()->last_activity . '=' . $_SERVER['REQUEST_TIME'];
        try{ 
            $sql->query($stmt);
            return TRUE;
        }catch(\PDOException $e){
            bcDB::throwError($e->getMessage());
        }
    }
    
    public function destroy($sid)
    {
        $db = bcUAC::session()->configModel();
        bcDB::connection( $db->bcDB_NS );
        $sql = bcDB::sql();
        $stmt = 'DELETE FROM ' . $db->tbl_uac_sessions .
                ' WHERE ' .  $db->uac_session()->id . ' = ' . $sql->quote($sid);
        try{    
            $sql->query($stmt);
            return TRUE;
        }catch(\PDOException $e){ 
            bcDB::throwError($e->getMessage());
        }
    }
    
    public function gc( $maxlifetime )
    {
        $db = bcUAC::session()->configModel();
        bcDB::connection( $db->bcDB_NS );
        $sql = bcDB::sql();
        $stmt = 'DELETE FROM ' . $db->tbl_uac_sessions .
                ' WHERE ' . $db->uac_session()->last_activity . ' < ' . ($_SERVER['REQUEST_TIME'] - $maxlifetime );
        try{    
            $sql->query($stmt);
            return TRUE;
        }catch(\PDOException $e){ 
            bcDB::throwError($e->getMessage());
        }
    }   
}