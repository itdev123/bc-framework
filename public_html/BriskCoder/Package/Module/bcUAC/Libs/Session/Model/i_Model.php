<?php
namespace BriskCoder\Package\Module\bcUAC\Libs\Session\Model;

//This is just a reference for all other Module\Libs since Session implements \SessionHandlerInterface
interface i_Model
{
    public function open( $save_path, $session_id );
    public function close();
    public function read($sid);
    public function write($sid, $data);
    public function destroy($sid);
    public function gc( $maxlifetime );
}