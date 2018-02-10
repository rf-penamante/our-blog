<?php

function theme_uri($file=null){
	$that=&get_instance();
	return $that->app->theme_uri($file);
}

function title(){
	$that=&get_instance();
	return $that->app->cdata('title');
}

function content(){
	$that=&get_instance();
	$theme_uri = $that->app->theme_uri();
	$content = $that->app->cdata('content');
	$content = str_ireplace('[base_url]', base_url(),$content);
	$content = str_ireplace('[theme_uri]', $theme_uri,$content);
	return $content;
}

function page_header(){
	$that=&get_instance();
	return $that->app->cdata('header');
}

function footer_copyright(){
	$that=&get_instance();
	return $that->config_model->get('footer_copyright');
}

function render_meta_tags(){
	$that=&get_instance();
	return $that->app->render_meta_tags();
}



function state_cities($state_abbr){
	$that =& get_instance();
	$that->load->model('city_model');
	return $that->city_model->get_all(array('state'=>$state_abbr));
}

function get_city_zip($state, $city){
	$that =& get_instance();
	$that->load->model('city_model');
	$zips = $that->city_model->get_zip($state, $city);
	$city;
	foreach($zips as $zip){
		$city = $zip;	
	}
	$zip_codes = explode(', ', $city->zip_code);
	return $zip_codes;
}


function get_cities_by_zipcode($zip_code){
	$that =& get_instance();
	$that->load->model('city_model');
	return $that->city_model->get_by_zip_code($zip_code);
}




/*
 * New
 */

 /**
 * get_option
 *
 * Gets data to the configuration options in the database
 *
 * @param (string) (name) about this param
 * @return (type) (name)
 */
 function get_option($key){
	$that =& get_instance();
	$that->load->model('config_model');
	$value = $that->config_model->get($key);
	preg_match_all('/%\w*%/', $value, $matches);
	
	if(isset($matches[0]) && count($matches[0])){
		foreach($matches[0] as $keyword){
			$newValue = get_option(str_replace("%","",$keyword));
			
			if($newValue){
				$value = str_replace($keyword, $newValue, $value);
			}
			
		}
	}
	return $value;
 }


function cityPageHeadline(){
	$headline = get_option('city_page_headline_format');
	
	$that =& get_instance();
	
	$city = $that->app->cdata('raw');
	
	$headline = str_replace("%city_name%", $city->name, $headline);
	$headline = str_replace("%state%", strtoupper($city->state), $headline);
	
	return $headline;
}

 /**
 * function name
 *
 * What the function does
 *
 * @param (string) (name) about this param
 * @return (type) (name)
 */ 
 function get_all_options(){
 	$that =& get_instance();
	$that->load->model('config_model');
	return $that->config_model->get_all();
 }

 /**
 * function name
 *
 * What the function does
 *
 * @param (string) (name) about this param
 * @return (type) (name)
 */ 
 function load_header($filename=null,$data=null){
 	$that=&get_instance();
	$prefix = 'header';
 	if(isset($filename)){
 		$view=$prefix.'-'.$filename;
 	}else{
 		$view=$prefix;
 	}
 	$that->template->phtml($view,$data);
 }
 
 /**
 * function name
 *
 * What the function does
 *
 * @param (string) (name) about this param
 * @return (type) (name)
 */ 
 function load_footer($filename=null,$data=null){
 	$that=&get_instance();
	$prefix = 'footer';
 	if(isset($filename)){
 		$view=$prefix.'-'.$filename;
 	}else{
 		$view=$prefix;
 	}
 	$that->template->phtml($view,$data);
 }
 
  /**
 * function name
 *
 * What the function does
 *
 * @param (string) (name) about this param
 * @return (type) (name)
 */ 
 function load_sidebar($filename=null,$data=null){
 	$that=&get_instance();
	$prefix = 'sidebar';
 	if(isset($filename)){
 		$view=$prefix.'-'.$filename;
 	}else{
 		$view=$prefix;
 	}
 	$that->template->phtml($view,$data);
 }
 
  /**
 * function name
 *
 * What the function does
 *
 * @param (string) (name) about this param
 * @return (type) (name)
 */ 
 function load_phtml($filename=null,$data=null){
 	$that=&get_instance();
 	$that->template->phtml($filename,$data);
 }
 
 /**
 * function name
 *
 * What the function does
 *
 * @param (string) (name) about this param
 * @return (type) (name)
 */ 
 function load_block($filename=null,$data=null){
 	$that=&get_instance();
 	$that->template->block($filename,$data);
 }
 
  /**
 * function name
 *
 * What the function does
 *
 * @param (string) (name) about this param
 * @return (type) (name)
 */ 
 function load_form($filename=null,$data=null){
 	$that=&get_instance();
 	$that->template->form($filename,$data);
 }
 
 /**
 *
 * What the function does
 *
 * @param (string) (name) about this param
 * @return (type) (name)
 */ 
 function get_pages($options=null){
 	$that =& get_instance();
	$that->load->model('state_model');
	
	if(isset($options)){extract($options);}
	
	$options = array(
		'fields'=>'*'
	);
	extract($options,EXTR_SKIP);
 }
 
 /**
 *
 * What the function does
 *
 * @param (string) (name) about this param
 * @return (type) (name)
 */ 
 function get_all_states($options=null){
	$that =& get_instance();
	$that->load->model('state_model');
	
	if(isset($options)){extract($options);}
	
	$options = array(
		'fields'=>'*',
		'inc_content'=>FALSE,
		'exc_fields'=>'content',
		'return_type'=>'object'
	);
	extract($options,EXTR_SKIP);
	
	//inc_content
	if($inc_content==FALSE){//if include content is set to false it will get all meta-data of table then remove `content` field
		$state_fields = $that->db->field_data('states');
		$fields = "";
		foreach($state_fields as $key=>$field){
			if($field->name != 'content'){
				$fields[] = $field->name;
			}
		}
		$fields = implode(',',$fields);
	}
	
	$state_options = array(
		'order_by'=>'name ASC',
		'fields'=>$fields
	);
	
	if($states = $that->state_model->get_all($state_options)){//check first if $states is not empty
		if($return_type == 'object'){
			return $states;
		}else{
			return object_to_array($states);
		}
	}else{
		return "";
	}
}
 
  
 /**
 *
 * What the function does
 *
 * @param (string) (name) about this param
 * @return (type) (name)
 */ 
 function contact_form($options=null){
 	$that =& get_instance();
	if(isset($options)){extract($options);}
	$options = array(
		'fields'=>'*'
	);
	extract($options,EXTR_SKIP);
 }
 
 
function search_form($options=null){
	$that =& get_instance();
	if(isset($options)){extract($options);}
	$options = array(
		'form'=>null
	);
	$action_url = base_url('search');
	extract($options,EXTR_SKIP);
	$response = "";
	if(isset($form)){
		load_form($form);
	}else{
		$response = "
		<form action='$action_url' method='get' >
			<input type='text' placeholder='search' name='q' />
			<input type='submit' value='Search' />
		</form>
		";
		return $response;
	}
}

function get_search_query(){
	if(isset($_GET['q'])){
		return $_GET['q'];
	}else{
		return "";
	}
}

function send_email($success_message="Message sent"){
	$that =& get_instance();
	if(isset($_POST['send_email'])){
		$ip = $_SERVER['REMOTE_ADDR'];
		$challengeField = $that->input->post('recaptcha_challenge_field');
		$responseField = $that->input->post('recaptcha_response_field');
		$that->recaptcha->recaptcha_check_answer($ip,$challengeField,$responseField);
		if($that->recaptcha->getIsValid()){
			$that =& get_instance();
			$that->load->library('form_validation');
			$that->form_validation->set_rules('name', 'Name', 'trim|required');
			$that->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$that->form_validation->set_rules('subject', 'Subject', 'trim|required');
			$that->form_validation->set_rules('content', 'Content', 'trim|required|xss_clean');
		
			if($that->form_validation->run() == FALSE) {
					return validation_errors();
			} else {
					$that->load->library('email');
					$that->email->from($that->input->post('email'), $that->input->post('name'));
					$that->email->to(get_option('email_admin'));
					$that->email->subject($that->input->post('subject'));
					$that->email->message($that->input->post('content'));
					$that->email->send();
					return $success_message;
			}
		}else{
			return 'Invalid Captcha!';
		}
	}
}

function isFrontpage(){
	$that =& get_instance();
	
	if($that->uri->segment(1)){
		return 0;
	}else{
		return 1;
	}
}


