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

	public function newHistoryDaily_post()
	{
		if($this->post())
		{
			$this->load->model('User_model');
			$this->load->model('Target_model');
			$normalExpense = $this->Target_model->detail_target($this->post('id_target'))->normal_expense;
			$offset = $this->Target_model->detail_target($this->post('id_target'))->offset;
			$targetData = $this->User_model->detail_user($this->post('username'));
			$data = [];
			$save = 0;
			$expense = 0;
			foreach($this->post() as $key => $value) {
				$data[$key] = $value;
				if($key != 'username' && $key != 'id_target' && $key != 'date')
				{
					$expense += intval($value);
				}
			}
			$save = floor($targetData->penghasilan/30) - $expense;
			$data['save'] = $save;
			$data['expense'] = $expense;
			$offset = $offset+($normalExpense - $expense);
			$this->Target_model->update_offset_target($this->post('id_target'),$offset);
			$inp = file_get_contents(base_url().'json/history.json');
			$tempArray = json_decode($inp);
			array_push($tempArray, $data);
			$jsonData = json_encode($tempArray);
			file_put_contents('././json/history.json', $jsonData);
			$this->response([[
					'status' => TRUE,
					'message' => 'Pengeluaran Daily added'
			]], REST_Controller::HTTP_CREATED); // OK (200) being the HTTP response code
		}
		else {
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
		}
	}

	public function newHistoryDailyV1_post()
	{
		if($this->post())
		{
			$this->load->model('User_model');
			$this->load->model('Target_model');
			$normalExpense = $this->Target_model->detail_target($this->post('id_target'))->normal_expense;
			$offset = $this->Target_model->detail_target($this->post('id_target'))->offset;
			$targetData = $this->User_model->detail_user($this->post('username'));
			$data = [];
			$save = 0;
			$expense = 0;
			foreach($this->post() as $key => $value) {
				$data[$key] = $value;
				if($key != 'username' && $key != 'id_target' && $key != 'date')
				{
					$expense += intval($value);
				}
			}
			$save = floor($targetData->penghasilan/30) - $expense;
			$data['save'] = $save;
			$data['expense'] = $expense;
			$offset = $offset+($normalExpense - $expense);
			$this->Target_model->update_offset_target($this->post('id_target'),$offset);
			$inp = file_get_contents(base_url().'json/history.json');
			$tempArray = json_decode($inp);
			array_push($tempArray, $data);
			$jsonData = json_encode($tempArray);
			file_put_contents('././json/history.json', $jsonData);
			$this->response([[
					'status' => TRUE,
					'message' => 'Pengeluaran Daily added'
			]], REST_Controller::HTTP_CREATED); // OK (200) being the HTTP response code
		}
		else {
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
		}
	}

	public function updateHistoryDaily_post()
	{
		$this->load->model('Target_model');
		$normalExpense = $this->Target_model->detail_target($this->post('id_target'))->normal_expense;
		$offset = $this->Target_model->detail_target($this->post('id_target'))->offset;
		$amountKeys = [];
		$keys = [];
		foreach($this->post() as $key => $value)
		{
			if(substr($key,0,7) == 'amount_')
			{
				$datum = [];
				$datum['key'] = $key;
				$datum['value'] = $value;
				array_push($amountKeys,$datum);
			}
			else if($key != 'username' && $key != 'id_target' && $key != 'date'){
				$datum = [];
				$datum['key'] = $key;
				$datum['value'] = $value;
				array_push($keys,$datum);
			}

		}
		$inp = file_get_contents(base_url().'json/history.json');
		$tempArray = json_decode($inp);
		$i = 0;
		foreach($tempArray as $temp)
		{
			if ($temp->username == $this->post('username') && $temp->id_target == $this->post('id_target') && $temp->date == $this->post('date'))
			{
				$tempExpense = $temp->expense;
				foreach($amountKeys as $amountKey)
				{
					$tempKey = substr($amountKey['key'],7);
					$diff = $temp->$tempKey - $amountKey['value'];
					$temp->$tempKey = $amountKey['value'];
					$temp->save = $temp->save + $diff;
					$temp->expense = $temp->expense - $diff;
				}
				$endExpense = $tempExpense - $temp->expense;
				$offset = $offset+$endExpense;
				$this->Target_model->update_offset_target($this->post('id_target'),$offset);
				foreach($keys as $k)
				{
						if($k['value'] != $k['key'])
						{
							$tempArray[$i]->$k['value'] = $tempArray[$i]->$k['key'];
							unset($tempArray[$i]->$k['key']);
						}
				}

			}
			$i = $i+1;
		}
		$jsonData = json_encode($tempArray);
		file_put_contents('././json/history.json', $jsonData);
		$this->response([[
				'status' => TRUE,
				'message' => 'Pengeluaran Daily updated'
		]], REST_Controller::HTTP_CREATED); // OK (200) being the HTTP response code
	}

	public function updateHistoryDailyAmount_post()
	{
		$this->load->model('Target_model');
		$normalExpense = $this->Target_model->detail_target($this->post('id_target'))->normal_expense;
		$offset = $this->Target_model->detail_target($this->post('id_target'))->offset;
		foreach($this->post() as $key => $value)
		{
			if($key != 'username' && $key != 'id_target' && $key != 'date')
			{
				$field = $key;
			}
		}
		$inp = file_get_contents(base_url().'json/history.json');
		$tempArray = json_decode($inp);
		foreach($tempArray as $temp)
		{
			if ($temp->username == $this->post('username') && $temp->id_target == $this->post('id_target') && $temp->date == $this->post('date'))
			{
				foreach($temp as $key => $value)
				{
					if($key == $field)
					{
						$diff = $temp->$field - $this->post($field);
						$temp->$field = $this->post($field);
					}
				}
				$temp->save = $temp->save + $diff;
				$offset = $offset+$diff;
				$temp->expense = $temp->expense - $diff;
				$this->Target_model->update_offset_target($this->post('id_target'),$offset);
			}
		}
		$jsonData = json_encode($tempArray);
		file_put_contents('././json/history.json', $jsonData);
		$this->response([[
				'status' => TRUE,
				'message' => 'Pengeluaran Daily updated'
		]], REST_Controller::HTTP_CREATED); // OK (200) being the HTTP response code
	}

	public function deleteHistoryDaily_post() {
		$this->load->model('Target_model');
		$normalExpense = $this->Target_model->detail_target($this->post('id_target'))->normal_expense;
		$offset = $this->Target_model->detail_target($this->post('id_target'))->offset;
		foreach($this->post() as $key => $value)
		{
			if($key != 'username' && $key != 'id_target' && $key != 'date')
			{
				$field = $key;
			}
		}
		$inp = file_get_contents(base_url().'json/history.json');
		$tempArray = json_decode($inp, true);
		$i = 0;
		foreach($tempArray as $temp)
		{
			if ($temp['username'] == $this->post('username') && $temp['id_target'] == $this->post('id_target') && $temp['date'] == $this->post('date'))
			{
				foreach($temp as $key => $value)
				{
					if($key == $field)
					{

						$diff = $temp[$field];
						unset($temp[$field]);
						$tempArray[$i] = $temp;
					}
				}
				$tempArray[$i]['save'] = $tempArray[$i]['save'] + $diff;
				$offset = $offset+$diff;
				$this->Target_model->update_offset_target($this->post('id_target'),$offset);
				$tempArray[$i]['expense'] = $tempArray[$i]['expense'] - $diff;
			}
			$i=$i+1;
		}
//		var_dump($temp);
		$jsonData = json_encode($tempArray);
		file_put_contents('././json/history.json', $jsonData);
		$this->response([[
				'status' => TRUE,
				'message' => 'Pengeluaran Daily updated'
		]], REST_Controller::HTTP_CREATED); // OK (200) being the HTTP response code
	}

	public function getHistoryDaily_get() {
		$response = array();
		$inp = file_get_contents(base_url().'json/history.json');
		$tempArray = json_decode($inp);
		foreach($tempArray as $temp)
		{
			if ($temp->username == $this->get('username') && $temp->id_target == $this->get('id_target'))
			{
				$response = array_push($response, $temp);
			}
		}
		$this->response($response, REST_Controller::HTTP_OK);
	}

	public function login_post()
	{
		$this->load->model('User_model');
		$username = $this->post('username');
		$password = $this->post('password');

		if($username != NULL && $password != NULL)
		{
			$user = $this->User_model->login($username, md5($password));
			if($user)
			{
				$this->response([[
					'status' => TRUE,
					'message' => 'Login succeeded',
					'username' => $user->username,
					'nama_user' => $user->nama_user
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

			public function penghasilan_post(){
	        $this->load->model('User_model');
	        $username = $this->post('username');
	        $penghasilan = $this->post('penghasilan');
	        $responses = $this->User_model->updatePenghasilan($username, $penghasilan);
	        $this->response(NULL, REST_Controller::HTTP_OK);
	    }

			public function pengeluaran_get() {
	    	$this->load->model('Pengeluaran_model');
	    	$username = $this->get('username');
				if($username != NULL)
				{
					$responses = $this->Pengeluaran_model->getPengeluaranDefault($username);
					$this->response($responses, REST_Controller::HTTP_OK);
				}
				else {
					$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
				}

			}

			public function historyTarget_get() {
				$this->load->model('HistoryTarget_model');
				$username = $this->get('username');
				$response = $this->HistoryTarget_model->getHistoryTarget($username);
				$this->response($response, REST_Controller::HTTP_OK);
			}

	    public function newPengeluaran_post() {
	        $this->load->model('Pengeluaran_model');
	        $username = $this->post('username');
	        $desc = $this->post('description');
	        $amount = $this->post('amount');
	        $response = $this->Pengeluaran_model->newPengeluaranDefault($username, $desc, $amount);

	        if($response)
	            {
	                $this->response([[
	                    'status' => TRUE,
	                    'message' => 'Pengeluaran added'
	                ]], REST_Controller::HTTP_CREATED); // OK (200) being the HTTP response code
	            }
	            else
	            {
	                $this->response([[
	                    'status' => FALSE,
	                    'message' => 'Pengeluaran failed'
	                    ]]);
	            }
	    }

			public function updatePengeluaran_post() {
		$this->load->model('Pengeluaran_model');
		$username = $this->post('username');
		$desc = $this->post('description');
		$amount = $this->post('amount');
		$response = $this->Pengeluaran_model->updatePengeluaranDefault($username, $desc, $amount);

		if($response)
		{
			$this->response([[
				'status' => TRUE,
				'message' => 'Pengeluaran modified'
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

	public function deletePengeluaran_post() {
		$this->load->model('Pengeluaran_model');
		$username = $this->post('username');
		$desc = $this->post('description');
		$response = $this->Pengeluaran_model->deletePengeluaranDefault($username, $desc);

		if($response)
		{
			$this->response([[
				'status' => TRUE,
				'message' => 'Pengeluaran deleted'
			]], REST_Controller::HTTP_CREATED); // OK (200) being the HTTP response code
		}
		else
		{
			$this->response([[
				'status' => FALSE,
				'message' => 'Wrong username or password'
			]]);
		}
	}


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

		public function updateStatusTarget_post()
		{
			$this->load->model('Target_model');
			$id = $this->post('id_target');
			if($id != NULL)
			{
				$args = array(
					'status' => 0,
				);
				$idTarget = $this->Target_model->update_status_target($id, $args);
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
