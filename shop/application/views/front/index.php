<?php
	// Turn TRUE when working in CSS and JS files
	$css_development =  TRUE;
	
	// Trun TRUE once worked with CSS and JS. 
	// Again turn FALSE to rebuiled minified faster loading CSS and JS
	$rebuild		 =	FALSE;
	
	$vendor_system	 =  $this->db->get_where('general_settings',array('type' => 'vendor_system'))->row()->value;
	$description	 =  $this->db->get_where('general_settings',array('type' => 'meta_description'))->row()->value;
	$keywords		 =  $this->db->get_where('general_settings',array('type' => 'meta_keywords'))->row()->value;
	$author			 =  $this->db->get_where('general_settings',array('type' => 'meta_author'))->row()->value;
	$system_name	 =  $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
	$system_title	 =  $this->db->get_where('general_settings',array('type' => 'system_title'))->row()->value;
	$revisit_after	 =  $this->db->get_where('general_settings',array('type' => 'revisit_after'))->row()->value;
	$slider	 =  $this->db->get_where('general_settings',array('type' => 'slider'))->row()->value;
	$page_title		 =  ucfirst(str_replace('_',' ',$page_title));
	$this->crud_model->check_vendor_mambership();
	if($page_name == 'product_view'){
		$keywords	 .= $product_tags;
	}
	if($css_development == TRUE){
		include 'includes_top.php';
	} else {
		include 'includes_top_n.php';
	}
	include 'preloader.php';
	include 'header.php';

	if($page_name=="home" && $slider == 'ok')
	{
		include 'slider.php';
	}
	include $page_name.'.php';

	//include 'chat.php';
	include 'footer.php';
	include 'script_texts.php';
	
	if($css_development == TRUE){
		include 'includes_bottom.php';
	} else {
		include 'includes_bottom_n.php';
	}
	
?>