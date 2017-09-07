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

 //            if($result)
 //            {
 //                $this->response([[
 //                    'status' => TRUE,
 //                    'message' => 'SN submitted'
 //                ]], REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
 //            }
 //            else
 //            {
 //                $this->response([[
 //                    'status' => FALSE,
 //                    'message' => 'Failed to submit SN'
 //                ]]);
 //            }
 //        }
 //        else
 //        {
 //            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
 //        }

 //    }

 //    }

}
