<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require_once APPPATH . '/libraries/REST_Controller.php';

class Services extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url_helper');
	}

	public function login_post()
	{
		$this->load->model('User_model');
		$username = $this->post('username');
		$password = $this->post('password');

		if($username != NULL && $password != NULL)
		{
			$user = $this->User_model->login($username, $password);

			if($user)
			{
				$this->response([[
					'status' => TRUE,
					'message' => 'Login succeeded'
					]], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
				}
				else
				{
					$this->response([[
						'status' => FALSE,
						'message' => 'Wrong username or password'
						]]);
					}
				}
				else
				{
					$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
				}
			}

<<<<<<< HEAD
        public function penghasilan_get(){
        $this->load->model('User_model');
        $username = $this->post('username');
        $penghasilan = $this->post('penghasilan');
        $responses = $this->User_model->updatePenghasilan($username, $penghasilan);   
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);    
        }

	// public function outlet_get()
	// {
	// 	$id = $this->get('id');
 //        $lat = $this->get('lat');
 //        $lon = $this->get('lon');

	// 	if($id === NULL)
 //        {
 //            if($lat != NULL && $lon != NULL)
 //            {
 //                $outlets = $this->Services_model->getOutlet(0, $lat, $lon);
 //            }
 //            else
 //            {
 //                $outlets = $this->Services_model->getOutlet();
 //            }

	// 		if($outlets)
	// 		{
 //                // $this->output->set_content_type('application/json');
 //                // $this->output->set_output(json_encode($outlets, 16));
 //                // return $this->output;
	// 			$this->response($outlets, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	// 		}
	// 		else
 //            {
 //                $this->response([[
 //                    'status' => FALSE,
 //                    'message' => 'No outlets were found'
 //                ]]);
 //            }
	// 	}

	// 	$id = (int) $id;

 //        // Validate the id.
 //        if ($id <= 0)
 //        {
 //            // Invalid id, set the response and exit.
 //            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
 //        }
 //        else
 //        {
 //        	$outlet = $this->Services_model->getOutlet($id);

 //        	if($outlet)
	// 		{
	// 			$this->response($outlet, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	// 		}
	// 		else
 //            {
 //                $this->response([[
 //                    'status' => FALSE,
 //                    'message' => 'The specified outlet were not found'
 //                ]], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
 //            }
 //        }

	// }

 //    public function SN_post()
 //    {
 //        $IDCR = $this->post('CR');
 //        $SN = $this->post('SN');
 //        $IDOutlet = $this->post('outlet');

 //        if($IDCR != NULL && $SN != NULL && $IDOutlet != NULL){
 //            $data = array(
 //                'IDCR' => $IDCR,
 //                'SN' => $SN,
 //                'IDOutlet' => $IDOutlet
 //            );

 //            $result = $this->Services_model->postSN($data);
=======
		public function register_post()
		{
			$this->load->model('User_model');
			$username = $this->post('username');
			$password = $this->post('password');
			$name = $this->post('nama_user');
			if($username != NULL && $password != NULL && $name != NULL)
			{
				$post = array(
					'username' => $username,
					'password' => md5($password),
					'nama_user' => $name
				);
				if($this->User_model->register($post))
				{
					$this->response([[
				                     'status' => TRUE,
				                     'message' => 'User created'
				                 ]], REST_Controller::HTTP_CREATED);
				}
				else {
					$this->response([[
				                     'status' => FALSE,
				                     'message' => 'Username already taken'
				                 ]], REST_Controller::HTTP_BAD_REQUEST);
											 }
			}
			else {
				$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}
>>>>>>> 2487d08bfba194e7946d119e7c9197eb246e8f7f

		}

		public function newTarget_post()
		{
			$this->load->model('Target_model');
			$this->load->model('HistoryTarget_model');
			$desc = $this->post('target_desc');
			$amount = $this->post('target_amount');
			$startDate = $this->post('target_startdate');
			$dueDate = $this->post('target_duedate');
			$normalExpense = $this->post('normal_expense');
			$username = $this->post('username');
			if($username != NULL && $desc != NULL && $amount != NULL && $startDate != NULL && $dueDate != NULL && $normalExpense != NULL)
			{
				$args = array(
					'target_desc' => $desc,
					'target_amount' => $amount,
					'target_startdate' => $startDate,
					'target_duedate' => $dueDate,
					'normal_expense' => $normalExpense
				);
				$idTarget = $this->Target_model->insert_target($args);
				$post = array(
					'id_target' => $idTarget,
				);
				$this->Target_model->update_targetUser($username, $post);
				$history = array(
					'username' => $username,
					'id_target' => $idTarget
				);
				$this->HistoryTarget_model->insert_historyTarget($history);
				$this->response([[
													 'status' => TRUE,
													 'message' => 'Target created'
											 ]], REST_Controller::HTTP_CREATED);
			}
			else {
				$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}
		}

		public function updateTarget_post()
		{
			$this->load->model('Target_model');
			$id = $this->post('id_target');
			$desc = $this->post('target_desc');
			$amount = $this->post('target_amount');
			$startDate = $this->post('target_startdate');
			$dueDate = $this->post('target_duedate');
			$normalExpense = $this->post('normal_expense');
			if($id != NULL && $desc != NULL && $amount != NULL && $startDate != NULL && $dueDate != NULL && $normalExpense != NULL)
			{
				$args = array(
					'target_desc' => $desc,
					'target_amount' => $amount,
					'target_startdate' => $startDate,
					'target_duedate' => $dueDate,
					'normal_expense' => $normalExpense
				);
				$idTarget = $this->Target_model->update_target($id, $args);
				$this->response([[
													 'status' => TRUE,
													 'message' => 'Target updated'
											 ]], REST_Controller::HTTP_OK);
			}
			else {
				$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}

		}

		public function deleteTarget_post()
		{
			$this->load->model('Target_model');
			$this->load->model('HistoryTarget_model');
			$id = $this->post('id_target');
			if($id != NULL)
			{
				$this->HistoryTarget_model->delete_history($id);
				$this->Target_model->delete_target($id);
				$this->response([[
													 'status' => TRUE,
													 'message' => 'Target deleted'
											 ]], REST_Controller::HTTP_OK);
			}
			else {
				$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}

		}

		public function User_get()
		{
			$this->load->model('User_model');
			$username = $this->get('username');
			if($username != NULL)
			{
				$user = $this->User_model->detail_user($username);
				if($user)
				{
					$this->response($user, REST_Controller::HTTP_OK);
				}
				else {
					$this->response([[
														 'status' => FALSE,
														 'message' => 'Username not found.'
												 ]], REST_Controller::HTTP_BAD_REQUEST);
				}
			}
			else {
				$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}
		}

		public function Target_get()
		{
			$this->load->model('Target_model');
			$id = $this->get('id_target');
			if($id != NULL)
			{
				$target = $this->Target_model->detail_target($id);
				if($target)
				{
					$this->response($target, REST_Controller::HTTP_OK);
				}
				else {
					$this->response([[
														 'status' => FALSE,
														 'message' => 'Target not found.'
												 ]], REST_Controller::HTTP_BAD_REQUEST);
				}
			}
			else {
				$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}
		}

}
