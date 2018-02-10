<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){

		parent::__construct();

		$this->load->database();

		// $this->load->library('session');
		session_start();

		$this->load->library('app');

		$this->load->model('user_model');
		$this->load->model('post_model');
		$this->load->model('post_details_model');

		// $this->load->helper('frontend_helper');

		// $this->load->helper('post_helper');

		// $this->load->library('recaptcha');	

		

		// $this->app->set_cdata('isLocationCovered',FALSE);

	}
	public function index()
	{
		if(isset($_POST['submit'])){
			extract($_POST,EXTR_SKIP);
			$post_data['title'] = $title;		
			$post_data['user_id'] = 1;


			if( $post_id = $this->post_model->insert($post_data) ){
				$post_detail_data['rel_post_id'] = $post_id;
				$post_detail_data['post_text'] = $post_text;
				$this->post_details_model->insert($post_detail_data);
				redirect(base_url());	
			}
			
		}
		if(isset($_POST['login'])){
			extract($_POST,EXTR_SKIP);
			
			$user = $this->user_model->get_user( array('key'=>$username ,'filter'=> 'username', 'password'=>$password));
			if( $user ){
				$_SESSION["user_data"] = $user;
			}
		}
		$all_posts = $this->post_model->get_all(array( 'status' => 1));
		$this->app->set_cdata("all_posts",$all_posts);

		// d($all_posts); exit();
		$this->load->view('homepage');
	}
	public function signup()
	{

		if(isset($_POST['submit'])){
			extract($_POST,EXTR_SKIP);

			$data['username'] = $username;
			$data['email'] = $email;
			$data['password'] = $password;

			
			if( !$this->user_model->get_user( array('key'=>$username ,'filter'=> 'username')) ){

				if( $user_id = $this->user_model->insert($data) ){
					$user = $this->user_model->get($user_id);
					$_SESSION["user_data"] = $user;

					redirect(base_url());	
				}	
					redirect(base_url());	

			}

		}	
		$this->load->view('signup');
	}		
	public function profile()
	{

		if(isset($_SESSION["user_data"])){
			$user_ses = $_SESSION["user_data"];
			$user = $this->user_model->get($user_ses->id);
			$this->app->set_cdata("user",$user);
			// d($user); 
			if(isset($_POST['submit'])){
			extract($_POST,EXTR_SKIP);

				$data['username'] = $username;
				$data['email'] = $email;
				$data['password'] = $password;
				$this->user_model->update($user_id, $data);
			}
			$all_posts = $this->post_model->get_all(array( 'status' => 1,'user' => $user->id));
			$this->app->set_cdata("all_posts",$all_posts);

			$this->load->view('profile');

		}else{
			$this->logout();
		}
		// exit();
	}
	public function aboutus()
	{

		$this->load->view('about-us');
	}
	public function logout()
	{
		session_destroy(); 
		redirect(base_url());	

	}
	public function post()
	{
		$id = $this->uri->segment(2,0);

		$post = $this->post_model->get($id,array('status' => 1));
		// d($post);
		if(isset($_POST['submit'])){
			extract($_POST,EXTR_SKIP);

			$post_data['title'] = $title;
			$this->post_model->update($post->post_id, $post_data);

			$post_detailts['post_text'] = $post_text;
			$this->post_details_model->update($post->post_detail_id, $post_detailts);
			redirect(base_url().'post/'.$post->post_id);	

		}
		$post = $this->post_model->get($id,array('status' => 1));
		$this->app->set_cdata("post",$post);
		$this->load->view('post');
	}
	public function delete()
	{
		$id = $this->uri->segment(2,0);

		$post_data['status'] = 0;

		$this->post_model->update($id, $post_data);

		redirect(base_url());	

	}
}
