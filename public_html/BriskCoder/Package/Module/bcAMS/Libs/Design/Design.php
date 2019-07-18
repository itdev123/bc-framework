<?php

/**
 * bcAMS Design Module
 * Manage bcAMS Design
 * @author Emily
 */

namespace BriskCoder\Package\Module\bcAMS\Libs;

use BriskCoder\bc,
    BriskCoder\Package\Library\bcDB,
    BriskCoder\Package\Module\bcAMS\Libs\Design\Config,
    BriskCoder\Package\Module\bcAMS\Libs\Design\ConfigModel;

final class Design
{

    private $USER_PATH = BC_PUBLIC_PATH . 'BriskCoder' . DIRECTORY_SEPARATOR . 'User' . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcAMS' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * CREATE CUSTOM FILE FROM ORIGINAL
     * @param String $PACKAGE
     * @param String $TEMPLATE
     * @param String $DISPATCHER Full Path ie: Blog\Blocks\LatestArticles
     * @return Boolean FALSE if trying to create an existent custom file, otherwise TRUE
     */
    public function create( $PACKAGE, $TEMPLATE, $DISPATCHER )
    {
        $viewPath = $TEMPLATE . DIRECTORY_SEPARATOR . '_View';
        $_dispatcher = explode( DIRECTORY_SEPARATOR, $DISPATCHER ); //explode dispatcher path to find  file name
        end( $_dispatcher );
        $last = key( $_dispatcher );
        $newFile = 'c_' . $_dispatcher[$last] . '.' . bc::publisher()->FILE_EXTENSION;
        if ( $this->exists( $TEMPLATE, $newFile ) )://if file already exist inside USER_ASSET path, return FALSE
            return FALSE;
        endif;
        if ( !is_dir( $this->USER_PATH . $TEMPLATE ) )://create folder with template name and _View folder if it does not exist
            mkdir( $this->USER_PATH . $viewPath, 0, TRUE );
        endif;
        unset( $_dispatcher[$last] ); //remove block name from dispatcher path, in order to create folders        
        $userView = $this->USER_PATH . $viewPath . DIRECTORY_SEPARATOR . implode( DIRECTORY_SEPARATOR, $_dispatcher ); //if dispatcher folders does not exist, then create it
        if ( !is_dir( $userView ) ):
            mkdir( $userView, 0, TRUE );
        endif;
        $content = file_get_contents( BC_PUBLIC_PATH . $PACKAGE . DIRECTORY_SEPARATOR . 'Media' . DIRECTORY_SEPARATOR . $viewPath . DIRECTORY_SEPARATOR . $DISPATCHER . '.' . bc::publisher()->FILE_EXTENSION ); //Get content from original dispatcher
        //use $this->replacement() to replace classes, ids, and data-attributes by concatenating its original name with '-c'. Replacement is required to avoid one block style to override the other when loading original and custom file in the same page        
        file_put_contents( $userView . DIRECTORY_SEPARATOR . $newFile, $this->replacement( $content ) ); //create file and its content
        return TRUE;
    }

    /**
     * DELETE CUSTOM FILE
     * @param String $TEMPLATE
     * @param String $FILE Full Path ie: Blog\Blocks\LatestArticles.html
     * @return Boolean FALSE if trying to delete a file that does not exist, otherwise TRUE
     */
    public function delete( $TEMPLATE, $FILE )
    {
        if ( !$this->exists( $TEMPLATE, $FILE ) )://before trying to delete a file that does not exist, check if it does exists and return FALSE if it doesn't
            return FALSE;
        endif;
        $viewPath = $this->USER_PATH . $TEMPLATE . DIRECTORY_SEPARATOR . '_View' . DIRECTORY_SEPARATOR;
        unlink( $viewPath . $FILE ); //delete file        
        $_dispatcher = explode( DIRECTORY_SEPARATOR, $FILE ); //explode file path
        end( $_dispatcher );
        unset( $_dispatcher[key( $_dispatcher )] ); //remove file name from path in order to get all folders name        
        $_files = glob( $viewPath . implode( DIRECTORY_SEPARATOR, $_dispatcher ) . DIRECTORY_SEPARATOR . '*.*' ); //Get all files existent within given path        
        if ( empty( $_files ) )://remove dispatchers folders if there is no file left inside            
            $_disps = array_reverse( $_dispatcher ); //delete in reverse order from last folder 'till the first            
            foreach ( $_disps as $k => $disp )://it must loop do delete folder by folder, because PHP does not have a function that delete directory recursively                
                unset( $_disps[$k] ); //remove current folder from path in order to build parent folder path                
                $path = $viewPath . ltrim( implode( DIRECTORY_SEPARATOR, $_disps ) . DIRECTORY_SEPARATOR . $disp, DIRECTORY_SEPARATOR ); //build full path until current folder, or only current folder if it's the last, and remove first DIRECTORY_SEPARATOR "ltrim"                
                if ( count( glob( $path . DIRECTORY_SEPARATOR . "*" ) ) === 0 )://get everything within USER_ASSET _view path and if does not exists any other directory within given path delete path
                    rmdir( $path );
                endif;
            endforeach;
        endif;
        if ( (count( glob( $viewPath . "*" ) ) === 0 ) && $TEMPLATE !== 'Default' )://Get all files existent within USER_ASSET _View path and remove template folder if there's nothing else inside _View and template is different than default.(Default always exist inside user, and it's set as default template)            
            rmdir( $viewPath ); //remove _View folder            
            rmdir( $this->USER_PATH . $TEMPLATE ); //remove template folder, if it was created  by the user when using bcAMS::design()->create()    
        endif;
        return TRUE;
    }

    /**
     * LOAD CUSTOM FILE
     * @param String $TEMPLATE
     * @param String $FILE
     * @return String
     */
    public function load( $TEMPLATE, $FILE )
    {
        bc::publisher()->TEMPLATE = $TEMPLATE; //set template that file belongs to        
        bc::publisher()->USER_ASSET = TRUE; //set USER_ASSET to TRUE to read file path from BriskCoder\Pub\User\        
        $content = bc::publisher()->render( $FILE, FALSE, TRUE ); //GET CUSTOM FILE BUFFER        
        bc::publisher()->USER_ASSET = FALSE; //set USER_ASSET to FALSE to reset USER_ASSET as read file path from BriskCoder\PROJECT_PACKAGE\
        return $content;
    }

    /**
     * GET ALL FILES WITHIN A DISPATCHER AND A TEMPLATE
     * @param String $DISPATCHER
     * @param String $TEMPLATE          
     * @return Array
     * ie: $_files[] = array(     
     * 'file_original_dispatcher' => 'file original path without extension',<br>
     * 'file_dispatcher'=> 'file path without extension',<br>
     * 'file_dispatcher_extension'=> 'file path with extension',<br>
     * 'file_original_name' => 'file original friendly name'<br>
     * );
     */
    public function files( $DISPATCHER, $TEMPLATE )
    {
        $disp = rtrim( $DISPATCHER, DIRECTORY_SEPARATOR ); //remove backslash in the end in case user sent it ending with a backslash
        $directoryPath = $this->USER_PATH . $TEMPLATE . DIRECTORY_SEPARATOR . '_View' . DIRECTORY_SEPARATOR . $disp;
        if ( !file_exists( $directoryPath ) )://if directory path does not exist return an empty array
            return array();
        endif;
        $_files = array();
        $_scanned_directory = array_diff( scandir( $directoryPath ), array( '..', '.' ) ); //get files from directory path and remove double dots('..') and single dot('.') from array
        foreach ( $_scanned_directory as $i => $file ):
            $_file = explode( '.', $file ); //explode extension from file name              
            $fileOriginalName = str_replace( 'c_', '', $_file[0] ); //remove c_ from file name tin order to get original name              
            $_files[$i]['file_original_dispatcher'] = $disp . DIRECTORY_SEPARATOR . $fileOriginalName; //file original path without extension            
            $_files[$i]['file_dispatcher'] = $disp . DIRECTORY_SEPARATOR . $_file[0]; //file path without extension            
            $_files[$i]['file_dispatcher_extension'] = $disp . DIRECTORY_SEPARATOR . $file; //file path with extension            
            $_files[$i]['file_original_name'] = trim( str_replace( '_', ' ', preg_replace( '/(?<!\ )[A-Z]/', ' $0', $fileOriginalName ) ) ); //file original name. Split camelCase words into two, and if file name is separated by underscore replace it with a space. Remove all spaces from the right and left position of the word
        endforeach;
        return $_files;
    }

    /**
     * CHECK IF FILE EXISTS WITHIN GIVEN TEMPLATE IN USER_ASSET PATH
     * @param String $TEMPLATE
     * @param String $path Full File Path ie: Blog\Blocks\LatestArticles.html
     * @return Boolean FALSE if $path within given $TEMPLATE does not exist, otherwise TRUE
     */
    public function exists( $TEMPLATE, $path )
    {
        if ( !is_file( $this->USER_PATH . $TEMPLATE . DIRECTORY_SEPARATOR . '_View' . DIRECTORY_SEPARATOR . $path ) )://if file within given template doesn't exist, returns FALSE
            return FALSE;
        endif;
        return TRUE; //otherwise, returns TRUE
    }

    /**
     * REPLACE CLASSES, IDS, AND DTA-ATTRIBUTES FROM HTML MARKUP, CSS, AND JAVASCRIPT     
     * @param String $CONTENT
     * @return String HTML MARKKUP, CSS, AND JAVASCRIPT
     */
    private function replacement( $CONTENT )
    {
        $_patterns = array();
        $_replacements = array();
        preg_match_all( '/class="[^"]*|class=\'[^\']*/', $CONTENT, $_matchedClasses ); //collect classes with dounble and single quotes in an array       
        preg_match_all( '/id="[^"]*|id=\'[^\']*/', $CONTENT, $_matchedIDs ); //collect ids with double and single quotes in an array        
        preg_match_all( '/data-[^"]*|data-[^\']*/', $CONTENT, $_matchedDataAttributes ); //collect data-attributes with double and single quotes in an array        
        foreach ( $_matchedClasses[0] as $mC )://classes pattern and replacement collection(HTML MARKUP, CSS, JAVASCRIPT)
            $replacementClass = '';
            $_mClasses = explode( ' ', $mC ); //explode class to get classes names when there's more than one class per element. ie: class="class-one class-two" = array('class-one', 'class-two')    
            foreach ( $_mClasses as $mCs ):
                if ( empty( $mCs ) )://if it's just an empty space, continue
                    continue;
                endif;
                $replacementClass .= $mCs . '-c '; //override every class name adding -c in the end                
                $patternReplacementCSSandJS = '.' . str_replace( array( 'class="', "class='" ), '', $mCs ); //remove class="|class=' word from matched value                
                $_patterns[] = '/\\' . $patternReplacementCSSandJS . '/'; //pattern and replacement of javascript and css
                $_replacements[] = $patternReplacementCSSandJS . '-c';
            endforeach;
            $replacementClass = rtrim( $replacementClass ); //remove space at the end of class names            
            $_patterns[] = '/' . $mC . '"/'; //pattern of html markup double quotes
            $_replacements[] = $replacementClass . '"'; //replacement of html markup double quotes
            $_patterns[] = "/" . $mC . "'/"; //pattern of html markup single quotes
            $_replacements[] = $replacementClass . "'"; //replacement of html markup single quotes
        endforeach;
        foreach ( $_matchedIDs[0] as $mID )://id pattern and replacement collection(HTML MARKUP, CSS, JAVASCRIPT)            
            $patternReplacementCSSandJS = str_replace( array( 'id="', "id='" ), '', $mID ); //remove id="|id=' word from matched value            
            $_patterns[] = '/' . $mID . '"/'; //pattern of html markup double quotes
            $_replacements[] = $mID . '-c"'; //replacement of html markup double quotes
            $_patterns[] = "/" . $mID . "'/"; //pattern of html markup single quotes
            $_replacements[] = $mID . "-c'"; //replacement of html markup single quotes
            $_patterns[] = '/#' . $patternReplacementCSSandJS . '/'; //pattern of javascript and css
            $_replacements[] = '#' . $patternReplacementCSSandJS . '-c'; //replacement of javascript and css
            $_patterns[] = '/\("' . $patternReplacementCSSandJS . '"\)/'; //pattern of core javascript double quotes
            $_replacements[] = '("' . $patternReplacementCSSandJS . '-c")'; //replacement of core javascript double quotes
            $_patterns[] = "/\('" . $patternReplacementCSSandJS . "'\)/"; //pattern of core javascript single quotes
            $_replacements[] = "('" . $patternReplacementCSSandJS . "-c')"; //replacement of core javascript single quotes
        endforeach;
        foreach ( $_matchedDataAttributes[0] as $mDa )://data-attributes replacement collection(HTML MARKUP, CSS, JAVASCRIPT)                       
            $mDa = str_replace( '=', '', $mDa ); //remove equal sign from matched values                 
            $_patterns[] = '/' . $mDa . '/'; //pattern of html, css, and javascript
            $_replacements[] = $mDa . '-c'; //replacement of html, css, and javascript
        endforeach;
        return preg_replace( $_patterns, $_replacements, $CONTENT ); //replace all classes, ids, and data-attributes from HTML MARKUP, CSS, and JAVASCRIPT
    }

    /* END HELPERS */

    /**
     * LIBRARY CONFIGURATION
     * @staticvar type $obj
     * @return \BriskCoder\Package\Module\bcAMS\Libs\Design\Config
     */
    public function config()
    {
        static $obj;
        return $obj instanceof Config ? $obj : $obj = new Config( __CLASS__ );
    }

    /**
     * MODEL CONFIGURATION     
     * Connection namespace, table and columns
     * @staticvar type $obj
     * @return \BriskCoder\Package\Module\bcAMS\Libs\Design\ConfigModel
     */
    public function configModel()
    {
        static $obj;
        return $obj instanceof ConfigModel ? $obj : $obj = new ConfigModel( __CLASS__ );
    }

    /**
     * MODEL Object
     * NOTE: returning associative DataSet column indexes are always the same names informed
     * via bcAMS::design()->configModel()->column_name. When using bcDB::$FQN = TRUE (recomended), then indexes within the DataSet
     * will be FQN as well. ie: $_data['mydb.tbl.column_name'], that way it's always consistent and easy to use
     * BriskCoder\Priv\DataObject\Schema to build queries and access DataSets. This will help with code consistence
     * in case any change oocurs to database, table and column names.<br>
     * TIP: When using your own models via \logic\Model layer, create properties within the Model class referencing the columns that
     * are required to the code implementation, and during object creation assign BriskCoder\Priv\DataObject\Schema to each, 
     * this way the only maintence required will be on the property assignment, if any new database column is added or removed.
     * @staticvar type $obj
     * @return \BriskCoder\Package\Module\bcAMS\Libs\Design\Model\i_Model
     */
    public function model()
    {
        static $obj;
        if ( $obj instanceof \BriskCoder\Package\Module\bcAMS\Libs\Design\Model\i_Model ):
            return $obj;
        endif;
        if ( $this->config()->STORAGE_RESOURCE === FALSE ):
            bcDB::connection( $this->configModel()->bcDB_NS );
            return $obj = new Design\Model\Model( __CLASS__ );
        endif;
        if ( !$this->config()->STORAGE_RESOURCE instanceof \BriskCoder\Package\Module\bcAMS\Libs\Design\Model\i_Model ):
            //debug
            exit( 'STORAGE_RESOURCE must implement \BriskCoder\Package\Module\bcAMS\Libs\Design\Model\i_Model ' );
        endif;
        return $obj = $this->config()->STORAGE_RESOURCE;
    }

}
