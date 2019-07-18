<?php
//htmlEntities($_POST['code'], ENT_QUOTES);
if (!json_decode($_POST['content'])) {
	exit('Not valid content!');
}
$code_arr = json_decode($_POST['content']);
$code = '';

foreach ($code_arr->blockList as $key => $code_obj) {
	if ($key != 0 && $key != (count($code_arr->blockList) - 1)) {
		$code .= $code_obj->html;
	}
}
$pageid = $_POST['pageid'];
$page = $db->get_results("SELECT * FROM webpages WHERE page_id = '$pageid' AND org_id = $org_id" );
$location = $page[0]['location'];

//$create_restore_point = (isset( $_POST['create_restore_point'] ) ) ? $_POST['create_restore_point'] : 0;
//header("Location:".$returnpage);

# Redirect if not logged in.
$_SESSION[ 'user_id' ] = 34;
if ( !isset( $_SESSION[ 'user_id' ] ) ) { 
	die("Session Expired."); //require ( 'login_tools.php' ) ; load() ;
}

$table = "webpages";

if( isset( $_GET['source'] ) and $_GET['source'] == "vb" ){

    $code = str_ireplace('outline: rgba(233, 94, 94, 0.498039) solid 2px; outline-offset: -2px; cursor: pointer;', '', $code);
    $code = str_ireplace('outline: 2px solid rgba(233, 94, 94, 0.5); outline-offset: -2px; cursor: pointer;', '', $code);
	$code = str_ireplace('outline: rgba(233, 94, 94, 0.498039) solid 2px; cursor: pointer; outline-offset: -2px;', '', $code);

    $code = str_ireplace('outline: none; cursor: inherit;', '', $code);
    $code = str_ireplace('outline: medium none; outline-offset: -2px; cursor: inherit;', '', $code);
    $code = str_ireplace('outline: medium none; cursor: inherit;', '', $code);
    
    $code = str_ireplace('data-selector=".editContent"', '', $code);
    $code = str_ireplace('data-selector="img"', '', $code);
    $code = str_ireplace('data-selector="a.btn, button.btn"', '', $code);

    $code = str_ireplace('contenteditable="true"', '', $code);
    $code = str_ireplace('spellcheck="true"', '', $code);
    $code = str_ireplace('role="textbox"', '', $code);
    $code = str_ireplace('aria-multiline="true"', '', $code);
    $code = str_ireplace('data-placeholder="Type your text"', '', $code);
    $code = str_ireplace('data-medium-focused="true"', '', $code);

    /*check if any shortcode has been rendered, if yes, convert HTML to shortcode*/
	// Include html parsing class
	include_once('class_html_dom.php');
	if( !empty(trim($code)) ){
		// Pass the html to html dom class function
		$html = str_get_html($code);
		foreach($html->find('.container_dynamic') as $dynamic_container) {
			if( isset($dynamic_container->label) and !empty($dynamic_container->label) ){

				$shortcode_html = $dynamic_container->outertext;
				$shortcode_label = base64_decode($dynamic_container->label);
				//replace HTML by its shortcode
				$code = str_ireplace($shortcode_html, $shortcode_label, $code);
			}
		}
		//Check for shortcode slugs HTML
		foreach($html->find('.container_slug') as $dynamic_container) {
			if( isset($dynamic_container->label) and !empty($dynamic_container->label) ){

				$shortcode_html = $dynamic_container->outertext;
				$shortcode_label = base64_decode($dynamic_container->label);
				//replace HTML by its shortcode
				$code = str_ireplace($shortcode_html, $shortcode_label, $code);
			}
		}

		$check_custom = '';
		foreach($html->find('.dynamic_custom_html') as $dynamic_container) {

			//handle dynamic menus
			if( strpos( $dynamic_container->class, 'dynamic_menu' ) !== false ) {
				if( isset($_SESSION['custom_html']['dynamic_menu'] ) and isset($dynamic_container->custom) ){

					$shortcode_html = $dynamic_container->outertext;

					if( $check_custom != $dynamic_container->custom ){
						$custom_html = base64_decode($_SESSION['custom_html']['dynamic_menu'][$dynamic_container->custom]);
						$check_custom = $dynamic_container->custom;
					}else{
						$custom_html = '';
					}

					$code = str_ireplace($shortcode_html, $custom_html, $code);
				}
			}

		}
		unset($html);
	}
}


//if global css/js
if( $location == 'css' or $location == 'js' ){
	$db_arr = array(
		"page_content"	=>	$code,
		"saved_page_content"	=>	$code
	);	
	$create_history = 1;
//if other pages
}else{
	$db_arr = array(
		"saved_page_content"	=>	$code
	);	
	$create_history = 0;
}


// //check if restore point exists, if not create the first one
// if( !$db->num_rows("SELECT pr_id FROM page_restore_point WHERE org_id = $org_id AND location = '{$location}' ") ){
// 	$old_content = $db->get_row("SELECT page_content FROM webpages WHERE location = '$location' AND org_id = $org_id" );
// 	$prp_db_arr = array(
// 		'page_content'	=>	$old_content[0],
// 		'location'		=>	$location,
// 		'org_id'		=>	$org_id,
// 		'user_id'		=>	$_SESSION['user_id'],
// 	);
// 	$page_restore_point = $db->insert( 'page_restore_point', $prp_db_arr, 0, 1 );
// 	$db_arr["page_restore_point"] = $page_restore_point;
// }

$check = $db->get_results("SELECT * FROM webpages WHERE location = '$location' AND org_id = $org_id" );

if( count($check) > 0 ){

	$check = $check[0];

	/*START: This is to overcome a test case when 2 pages are being edited in VB by two users, Header or Footer will not save for one of the users otherwise.*/
	$skip = 0;
	if( $location == 'header' || $location == 'footer' ){
		$page_edited_time  = strtotime($check['edited_at']);
		$current_time = strtotime(date('Y-m-d H:i:s'));
		$time_difference = $current_time - $page_edited_time;
		if( $time_difference > 5 ){
			$skip = 1;
		}
	}
	/*END*/


	/*$history_arr = array(
		"page_id"		=>	$check["page_id"],
		"page_content"	=>	$check["page_content"],
		"parent"		=>	$check["parent"],
		"page_name"		=>	$check["page_name"],
		"page_title"	=>	$check["page_title"],
		"location"		=>	$check["location"],
		"css"			=>	$check["css"],
		"js"			=>	$check["js"],
		"org_id"		=>	$check["org_id"],
		"user_id"		=>	$check["user_id"],
		"protected"		=>	$check["protected"],
		
		"edited_by"		=>	$check["edited_by"],
		"edited_at"		=>	$check["edited_at"],
		"page_type"		=>	$check["page_type"],
		"saved_page_content"		=>	$check["saved_page_content"],
		"wh_user_id"	=>	$_SESSION['user_id']	
	);

	if( !empty($check["roles"]) ){
		$history_arr["roles"]			=	$check["roles"];
	}*/

	$where_clause = array( 
		"location"	=>	$location,
		"org_id"	=>	$org_id
	);
	
	if( $check['edited_by'] > 0 and !$skip ){
		// if( $check['edited_by'] == $_SESSION['user_id']) {
		// 	var_dump($db_arr);
			$response = $db->update( $table, $db_arr, $where_clause );	
		// } else {
		// 	echo "Another user editing this page";
		// 	$create_history = 0;
		// }
	}else{
		$response = $db->update( $table, $db_arr, $where_clause );	
	}

	//version control for webpages
	if( $create_history ){
		create_page_history('',$check);
		//$db->insert("webpages_history",$history_arr);
	
	}
	

	
}
else{
	$db_arr['location'] = $location;
	$db_arr['org_id'] = $org_id;
	$response = $db->insert( $table, $db_arr );
	
}

//creaet restore point so that can be used in Redo/Undo options
if( $create_restore_point ){

	//Keep max 10 records for a page
	$check_max_records = $db->num_rows("SELECT * FROM page_restore_point WHERE org_id = $org_id AND location = '{$location}' ");
	if( $check_max_records >= 11 ){
		$db->query("DELETE FROM page_restore_point WHERE org_id = $org_id AND location = '{$location}' ORDER BY pr_id LIMIT 1");
	}

	//check if forward points exist, if yes, then delete
	if( count($check) and $check['page_restore_point'] > 0 ){
		$db->query("DELETE FROM page_restore_point WHERE org_id = $org_id AND location = '{$location}' AND pr_id > {$check['page_restore_point']}");
	}

	$db_arr = array(
		'page_content'	=>	$code,
		'location'		=>	$location,
		'org_id'		=>	$org_id,
		'user_id'		=>	$_SESSION['user_id'],
	);
	$page_restore_point = $db->insert( 'page_restore_point', $db_arr, 0, 1 );
}

//if restore point for page is set, then add to webpages table.
if( isset($page_restore_point) and $page_restore_point > 0 ){

	$db_arr = array(
		'page_restore_point'	=>	$page_restore_point
	);
	$where_clause = array( 
		"location"	=>	$location,
		"org_id"	=>	$org_id
	);
	$db->update( $table, $db_arr, $where_clause );
}
?>