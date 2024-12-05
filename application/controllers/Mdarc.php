<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*  
* Inspired by:
* https://www.itsolutionstuff.com/post/stripe-payment-gateway-integration-in-codeigniter-exampleexample.html
*
* Search for: Stripe Payment Gateway Integration in CodeIgniter
* 
*/

class Mdarc extends CI_Controller {

    /**
     * Get All Data from this method.
	 * 
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->library("session");
       $this->load->helper('url');
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index() {
		$paydata = $this->Manager_model->get_paydata();
		$data['membership'] = $paydata['membership'];
		$data['carrier'] = $paydata['carrier'];
		$data['val_msg'] = '';
        $this->load->view('mdarc_view', $data);
		//$this->load->view('my_stripe');
    }

	public function about() {
		$this->load->view('readme');
	}

	public function terms() {
		$this->load->view('terms');
	}

	public function paym_ok() {

		// $param['email'] = $emailPost;
		// $param['name'] = $namePost;
		// $param['total'] = $totalSum;
		// $param['membership'] = $this->input->post('mem');
		// $param['carrier'] = 18;
		// $param['donation'] = 20.05;

		$data['mem_amount'] = 45;
		$data['carr_amount'] = 18;
		$data['don_amount'] = 5;
		$data['total'] = 68;
		$data['cur_yr'] = 2025;
		$data['time_stamp'] = time() - (3 * 3600);

		$data['mem'] = $this->Manager_model->get_member('leho@email.com');
		$this->load->view('paymok_view', $data);
	}

    /**
     * Get All Data from this method.
     * @return Response
    */
    public function stripePost() {
		$emailPost = $this->input->post('email');
		$namePost = $this->input->post('cc_name');
		$totalSum = floatval($this->input->post('proc_total'));
		$student = $this->input->post('student');

		$frmFlag = false;
		$nameErr = '';
		$emailErr = '';
		$studentErr = '';
		$mem_arr = array();

		if (empty($namePost)) {
			$nameErr = "Name is required!";
			$frmFlag = true;
		} else {
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z-' ]*$/",$namePost)) {
			$nameErr = "Name is not valid!";
			$frmFlag = true;
			}
		}

		if($student == 'studentval' && $this->Manager_model->check_student($emailPost)) {
			$studentErr = 'Unfortunately, you are not registered for student discount with MDARC.';
			$frmFlag = true;
		}

		if (empty($emailPost)) {
			$emailErr = "Email is required!";
			$frmFlag = true;
		} 
		else {
			// check if e-mail address is well-formed
			if (!filter_var($emailPost, FILTER_VALIDATE_EMAIL)) {
				$emailErr = "Invalid email!";
				$frmFlag = true;
			}
			else if(!$this->Manager_model->check_email($emailPost)){
				$emailErr = "Email is not on file!";
				$frmFlag = true;
			}
		}

		if($frmFlag){
			$paydata = $this->Manager_model->get_paydata();
			$data['membership'] = $paydata['membership'];
			$data['carrier'] = $paydata['carrier'];
			$data['val_msg'] = $studentErr . ' ' . $nameErr . ' ' . $emailErr . ' Please, try again...';
			$this->load->view('mdarc_view', $data);
		}
		else {
			$param['email'] = $emailPost;
			$param['name'] = $namePost;
			$param['total'] = $totalSum;
			$param['membership'] = $this->input->post('mem');
			$param['carrier'] = $this->input->post('carrier');
			$don_checked = $this->input->post('donation');
			$don_rep_checked = $this->input->post('don_rep');

			if($this->input->post('donation') == 'donation') {
				$param['donation'] = $this->input->post('donamnt');
			}
			else {
				$param['donation'] = 0;
			}

			if($this->input->post('don_rep') == 'don_rep') {
				$param['don_rep'] = $this->input->post('repamnt');
			}
			else {
				$param['don_rep'] = 0;
			}

			$mem_arr = $this->Manager_model->get_member($emailPost);
			$param['student'] = $student; 
				try {
					require_once('application/libraries/stripe-php/init.php');
					\Stripe\Stripe::setApiKey($this->config->item('mdarc_secret'));
					\Stripe\Customer::create([
						"description" => "MDARC Member or donor",
						"name" => $namePost,
						"email" => $emailPost,
						"address" => array("line1" => $mem_arr['line1'], 'city' => $mem_arr['city'], "state" => $mem_arr['state'], "country" => "US", "postal_code" => $mem_arr['postal_code'])
					]);
					\Stripe\Charge::create ([
							"amount" => $totalSum * 100,
							"currency" => "usd",
							"source" => $this->input->post('stripeToken'),
							"description" => "Payment by: " . $namePost . " via SA",
					]);

					$retarr = $this->Manager_model->process_payment($param);

					$this->load->view('paymok_view.php', $retarr);
				}
				catch (\Stripe\Exception\CardException $e) {
					// Since it's a decline, \Stripe\Exception\CardException will be caught
					$stat = "Status is: " . $e->getHttpStatus() . "<br />";
					$type = 'Type is: ' . $e->getError()->type . '<br />';
					$code = 'Code is: ' . $e->getError()->code . '<br />';
					// param is '' in this case
					$param = 'Param is: ' . $e->getError()->param . '<br />';
					$msg = 'Message is: ' . $e->getError()->message . '<br />';
					//echo $msg;
					$paydata = $this->Manager_model->get_paydata();
					$data['membership'] = $paydata['membership'];
					$data['carrier'] = $paydata['carrier'];
					$data['val_msg'] = $msg;
					$this->load->view('mdarc_view', $data);
					//$this->load->view('mdarc_view', array('val_msg' => $stat . $type . $code . $param . $msg . '<br />' .  ' Please, try again...'));
				} 
				catch (\Stripe\Exception\RateLimitException $e) {
					// Too many requests made to the API too quickly
					$msg = 'Too many requests!';
					echo $msg;
					//$this->load->view('mdarc_view', array('val_msg' => $msg . ' Please, try again...'));
				} 
				catch (\Stripe\Exception\InvalidRequestException $e) {
					// Invalid parameters were supplied to Stripe's API
					$paydata = $this->Manager_model->get_paydata();
					$data['membership'] = $paydata['membership'];
					$data['carrier'] = $paydata['carrier'];
					$data['val_msg'] = 'Payment data not correct! Please, try again...';
					$this->load->view('mdarc_view', $data);
				} 
				catch (\Stripe\Exception\AuthenticationException $e) {
					// Authentication with Stripe's API failed
					// (maybe you changed API keys recently)
					$msg =  'Authentication error!';
					echo $msg;
					//$this->load->view('mdarc_view', array('val_msg' => $msg . ' Please, try again...'));
				} 
				catch (\Stripe\Exception\ApiConnectionException $e) {
					// Network communication with Stripe failed
					$msg =  'Network connection failed!';
					echo $msg;
					//$this->load->view('mdarc_view', array('val_msg' => $msg . ' Please, try again...'));
				} 
				catch (\Stripe\Exception\ApiErrorException $e) {
					// Display a very generic error to the user, and maybe send
					// yourself an email
					$msg =  'Very generic error. Who knows what is this!';
					echo $msg;
					//$this->load->view('mdarc_view', array('val_msg' => $msg . ' Please, try again...'));
				} 
				catch (Exception $e) {
					// Something else happened, completely unrelated to Stripe
					$msg =  'An error that is completely unrelated to Stripe.';
					echo $msg;
					//$this->load->view('mdarc_view', array('val_msg' => $msg . ' Please, try again...'));
				}
			
		}
		
	}
}