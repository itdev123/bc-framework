<?php include("../../config/config.php"); 

$vb_url = $admin_url . "vb3/php/";
$vb_path = $admin_path . "vb3/";

if( isset($_GET["name"]) ){
	$pagename = htmlspecialchars($_GET["name"]);
}
else{
	header("Location: ".$admin_url."custom-pages.php");
	exit;
}

  $page = $db->get_results("SELECT * FROM webpages WHERE location = '$pagename' AND org_id = $org_id" );
  $page_id = $page[0]['page_id'];


  if(isset($_GET['type'])) {
        $Ptype = $_GET['type'];
    }
    else
    {
        $Ptype = 1;
    }
  $all_pages = $db->get_results("SELECT * FROM webpages WHERE org_id = $org_id and page_type = $Ptype and location NOT IN ('header','footer','css','js') ORDER BY page_name ");

  $all_posts = $db->get_results("SELECT * FROM posts WHERE org_id = $org_id and post_status = 1 ");


  $errors = array();
  if( isset($_SESSION['errors']) ){
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
  }

  if( isset($_SESSION['success']) ){
    unset($_SESSION['success']);
  }
  

  $no_access_pages = array(
        "css"           =>  "Site CSS",
        "header"        =>  "Site Header",
        "footer"        =>  "Site Footer",
        "js"            =>  "Site JS",
  );

  $categories = $super_admin_db->get_results("SELECT tsc_id, tsc_name FROM theme_section_categories LEFT JOIN theme_sections ON ( tsc_id = ts_category and ts_theme_id = tsc_theme_id ) WHERE ts_theme_id = $theme_id GROUP BY tsc_id");

//To add webforms menu
$categories[] = array(
    "tsc_id"    =>  "web_forms",
    "tsc_name"  =>  "Web Forms"
);

//To add Static blocks menu
$categories[] = array(
    "tsc_id"    =>  "static_blocks",
    "tsc_name"  =>  "Static Blocks"
);

//To add Posts menu
$categories[] = array(
    "tsc_id"    =>  "blog_posts",
    "tsc_name"  =>  "Blog Posts"
);

//To add Events menu
$categories[] = array(
    "tsc_id"    =>  "events",
    "tsc_name"  =>  "Events"
);

//To add Promotions menu
$categories[] = array(
    "tsc_id"    =>  "promotions",
    "tsc_name"  =>  "Promotions"
);

//To add Slider menu
$categories[] = array(
    "tsc_id"    =>  "sliders",
    "tsc_name"  =>  "Sliders"
);

$page[0]['page_restore_point'] = $page[0]['page_restore_point'] ? $page[0]['page_restore_point'] : 0;
$forward_restore_point = 0;
$last_restore_point = 0;

$check_last_restore_point = $db->get_row("SELECT pr_id FROM `page_restore_point` WHERE org_id = {$org_id} AND location = '{$pagename}' AND pr_id < {$page[0]['page_restore_point']} ORDER BY pr_id DESC");
if( count($check_last_restore_point) ) $last_restore_point = $check_last_restore_point[0];

$check_forward_restore_point = $db->get_row("SELECT pr_id FROM `page_restore_point` WHERE org_id = {$org_id} AND location = '{$pagename}' AND pr_id > {$page[0]['page_restore_point']}  ORDER BY pr_id");
if( count($check_forward_restore_point) ) $forward_restore_point = $check_forward_restore_point[0];

$_SESSION['custom_html'] = array(
    'dynamic_menu'  =>  array()
);


$aviary_defaults_config = array(
    'apiKey'     => $api['aviary']['apiKey'],
    'language'   => $api['aviary']['language'],
    'theme'      => $api['aviary']['theme'],
    'tools'      => 'crop,resize',
    'maxSize'    => $api['aviary']['maxSize']
);
$elements = array();
$cat_count = 0;
foreach( $categories as $cat ){
	$element = array();
	$cat_count++;
	$new_page_url = '';
	$title = '';

	if( is_numeric($cat['tsc_id']) ){
	    $sections = $super_admin_db->get_results("SELECT *, 'theme_section' as block_type FROM  theme_sections where ts_theme_id = $theme_id AND ts_category = ". $cat['tsc_id'] );
	} else {
	    if( $cat['tsc_id'] == 'web_forms' ){
	        $query = "SELECT wf_id as ts_id, wf_title as ts_title, '/admin/assets/img/shortcode.png' as ts_preview_image, '' as ts_height, 'webform' as block_type  FROM web_forms where org_id = {$org_id}";  
	        $new_page_url = $admin_url.'webformNew/dynamicForm.php?page_view=iframe';
	        $title = 'New Webform';
	    }elseif( $cat['tsc_id'] == 'static_blocks' ){
	        $query = "SELECT sb_id as ts_id, sb_title as ts_title, '/admin/assets/img/shortcode.png' as ts_preview_image, '' as ts_height, 'static_block' as block_type  FROM static_blocks where org_id = {$org_id}";  
	        $new_page_url = $admin_url.'static_blocks/create.php?page_view=iframe';
	        $title = 'New Static Block';
	    }elseif( $cat['tsc_id'] == 'blog_posts' ){
	        $query = "SELECT post_id as ts_id, post_title as ts_title, '/admin/assets/img/blog_posts.png' as ts_preview_image, '' as ts_height, 'blog_post' as block_type  FROM posts where org_id = {$org_id} AND is_blog = 1";   
	        $new_page_url = $admin_url.'posts/create_post.php?page_view=iframe';
	        $title = 'New Blog Post';
	    }elseif( $cat['tsc_id'] == 'events' ){
	        $query = "SELECT post_id as ts_id, post_title as ts_title, '/admin/assets/img/events.png' as ts_preview_image, '' as ts_height, 'event' as block_type  FROM posts where org_id = {$org_id} AND is_event = 1";  
	        $new_page_url = $admin_url.'posts/create_post.php?type=event&page_view=iframe';
	        $title = 'New Event';
	    }elseif( $cat['tsc_id'] == 'promotions' ){
	        $query = "SELECT post_id as ts_id, post_title as ts_title, '/admin/assets/img/promotions.png' as ts_preview_image, '' as ts_height, 'promotion' as block_type  FROM posts where org_id = {$org_id} AND is_promotion = 1";  
	        $new_page_url = $admin_url.'posts/create_post.php?type=promotion&page_view=iframe';
	        $title = 'New Promotion';
	    }elseif( $cat['tsc_id'] == 'sliders' ){
	        $query = "SELECT sl_id as ts_id, sl_title as ts_title, '/admin/assets/img/sliders.png' as ts_preview_image, '' as ts_height, 'slider' as block_type  FROM sliders where org_id = {$org_id} AND (sl_slider_type = 'Slider' OR sl_slider_type = '')";  
	    }
	    $sections = $db->get_results($query);

	}
	
    if( count($sections) ){
    	foreach ( $sections as $sec ){
    		$item = array();
            if( $sec['block_type'] == 'theme_section' ){
                $sec['ts_preview_image'] = !empty($sec['ts_preview_image']) ? ($section_cat_img_path . $sec['ts_preview_image']) : '';
            }
            if( empty($sec['ts_preview_image']) ){
                $sec['ts_preview_image'] = "/assets/images/digilogo.png";
            }
            $height = !empty($sec['ts_height']) ? $sec['ts_height'] : 150;

            $sec['ts_title']    =   str_ireplace('"', '\"', $sec['ts_title']);
        	$item['url'] = $vb_url.'section-html.php?pagename='.$pagename.'&section_id='.$sec['ts_id'].'&block_type='.$sec['block_type'];
        	$item['height'] = $height;
        	$item['thumbnail'] = $sec['ts_preview_image'];
        	$item['title'] = $sec['ts_title'];
        	$element[] = $item;
        }
    }
    if( !empty($new_page_url) ){
    	$item = array();
		$item['url'] = $new_page_url;
		$item['height'] = '';
		$item['thumbnail'] = '';
		$item['title'] = $title;
		$element[] = $item;
    }
	$elements[$cat['tsc_name']] = $element;
 }
$value['elements'] = $elements;
echo json_encode($value);

