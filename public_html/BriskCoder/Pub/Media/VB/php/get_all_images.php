<?php
	$directory = '../../../assets/images/';
	$allowed_types = array('image/jpeg', 'image/gif', 'image/png', 'image/svg');

	$handle = opendir($directory);
	$all_images = array();
	while (($file = readdir($handle)) !== false) {
		if ($file !== '.' && $file !== '..') {
			if (in_array(mime_content_type($directory . $file), $allowed_types)) {
				$all_images[] = '/assets/images/' . $file;
			}
		}
	}
	closedir($handle);

	// elements/images/uploads folder
	$handle = opendir($directory . 'uploads/');
	while (($file = readdir($handle)) !== false) {
		if ($file !== '.' && $file !== '..') {
			if (in_array(mime_content_type($directory . 'uploads/' . $file), $allowed_types)) {
				$all_images[] = '/assets/images/uploads/' . $file;
			}
		}
	}
	closedir($handle);

	echo json_encode($all_images);
?>