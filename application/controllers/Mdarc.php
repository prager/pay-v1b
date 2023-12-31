<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*  
* Inspired by:
* https://www.itsolutionstuff.com/post/stripe-payment-gateway-integration-in-codeigniter-exampleexample.html
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
        $this->load->view('mdarc_view');
    }

	public function about() {
		$this->load->view('readme');
	}

	public function terms() {
		$this->load->view('terms');
	}

    /**
     * Get All Data from this method.
     * @return Response
    */
    public function stripePost() {
		$totalSum = floatval($this->input->post('proc_total'));
		try {
			require_once('application/libraries/stripe-php/init.php');
			\Stripe\Stripe::setApiKey($this->config->item('mdarc_secret'));
			\Stripe\Customer::create([
				"description" => "the first customer",
			]);
			\Stripe\Charge::create ([
					"amount" => $totalSum * 100,
					"currency" => "usd",
					"source" => $this->input->post('stripeToken'),
					"description" => "Standalone gtwy test for MDARC" 
			]);
			$this->session->set_flashdata('success', 'Payment $' . number_format($totalSum, 2) . ' made successfully.');
			//redirect(base_url() . 'index.php/mdarc', 'refresh');
			header("Location: " . base_url() . "index.php/mdarc");
		}
		catch (\Stripe\Exception\CardException $e) {
			  // Since it's a decline, \Stripe\Exception\CardException will be caught
			echo "Status is: " . $e->getHttpStatus() . "<br />";
			echo 'Type is: ' . $e->getError()->type . '<br />';
			echo 'Code is: ' . $e->getError()->code . '<br />';
			// param is '' in this case
			echo 'Param is: ' . $e->getError()->param . '<br />';
			echo 'Message is: ' . $e->getError()->message . '<br />';
		} 
		catch (\Stripe\Exception\RateLimitException $e) {
			// Too many requests made to the API too quickly
			echo 'Too many requests!';
		} 
		catch (\Stripe\Exception\InvalidRequestException $e) {
			// Invalid parameters were supplied to Stripe's API
			echo 'Invalid parameters sent!';
		} 
		catch (\Stripe\Exception\AuthenticationException $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			echo 'Authentication error!';
		} 
		catch (\Stripe\Exception\ApiConnectionException $e) {
			// Network communication with Stripe failed
			echo 'Network connection failed!';
		} 
		catch (\Stripe\Exception\ApiErrorException $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email
			echo 'Very generic error. Who knows what is this!';
		} 
		catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			echo 'An error that is completely unrelated to Stripe.';
		}
	}
}
