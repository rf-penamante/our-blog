<?php

function getPageShortContent($value,$numWords=null){
	if(is_numeric($value)){
		$options = array('fields'=>'id,content,slug,title');
	}else{
		$options = array('fields'=>'id,content,slug,title','key_by'=>'slug');
	}
	
	if(!isset($numWords)){ $numWords = get_option('num_page_short_content');}
	$that =& get_instance();
	$that->load->model('page_model');
	$page = $that->page_model->get($value,$options);
	//return word_limiter($page->content , $numWords);

	$content = substr($page->content, 0, $numWords).'...';
	return $content;
}