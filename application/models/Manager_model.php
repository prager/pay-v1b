<?php
class Manager_model extends CI_Model {
	
    function __construct() {
		parent::__construct();
		$this->load->database();
	}

    public function process_payment($param) {
        $retval['status'] = true;
        $retval['cur_yr'] = 0;
        $retval['pay_type'] = 0;

            $mem_arr = $this->get_member($param['email']);

            $cur_yr = $mem_arr['cur_year'];

            if($cur_yr < date('Y', time())) {
                if( intval(date('m', time())) > 9 && intval(date('m', time())) <= 12) {
                    $cur_yr = intval(date('Y', time())) + 1;
                }
                else {
                    $cur_yr = intval(date('Y', time()));
                }
            }
            else  {
                $cur_yr++;
            } 
            
            $retval['cur_yr'] = $cur_yr;
            $retval['mem'] = $mem_arr;

            $paydata = $this->get_paydata();
            $valstr = $this->guid();
            $time_stamp = time() - (3 * 3600);
            $retval['time_stamp'] = $time_stamp;
            $carr_paid = 0;
            $mem_paid = 0;
            $don_paid = 0;
            $don_rep_paid = 0;
            $total_fee = number_format($param['total'] * $paydata['trans_per'] + $paydata['trans_fee'], 2);

            $trans_arr = array('id_member' => $mem_arr['id_members'], 'total_amt' => $param['total'], 'fee_amt' => $total_fee, 'date' => $time_stamp);
            $this->db->insert('transactions', $trans_arr);

            $this->db->select_max('id_transactions');
            $last_trans = $this->db->get('transactions')->row()->id_transactions;


            if($param['carrier'] == 'carrier') {
                $dbdata = array(
                    'id_member' => $mem_arr['id_members'],
                    'id_payaction' => 10,
                    'id_entity' => 2,
                    'amount' => $paydata['carrier'],
                    'paydate' => time(),
                    'result' => 'success',
                    'val_string' => $valstr,
                    'flag' => 0,
                    'for_year' => $cur_yr,
                    'id_transaction' => $last_trans
                );
                $this->db->insert('mem_payments', $dbdata);
                $carr_paid = $paydata['carrier'];
            }

            if($param['membership'] == 'mem') {
                
                $idpay = 0;
                if($param['student'] == 'on') {
                    $mem_paid = $paydata['student_amt'];
                    $idpay = 16;
                    $retval['pay_type'] = 16;
                }
                else {
                    $mem_paid = $paydata['membership'];
                    $idpay = 1;
                    $retval['pay_type'] = 1;
                }
                
                $dbdata = array(
                    'id_member' => $mem_arr['id_members'],
                    'id_payaction' => $idpay,
                    'id_entity' => 2,
                    'amount' => $mem_paid,
                    'paydate' => time(),
                    'result' => 'success',
                    'val_string' => $valstr,
                    'flag' => 0,
                    'for_year' => $cur_yr,
                    'id_transaction' => $last_trans
                );
                $this->db->insert('mem_payments', $dbdata);

                $dbdata2 = array('paym_date' => $time_stamp, 'cur_year' => $cur_yr);
                $this->db->reset_query();
                $this->db->where('id_members', $mem_arr['id_members']);
                $this->db->update('tMembers', $dbdata2);

                $this->db->reset_query();
                $this->db->where('parent_primary', $mem_arr['id_members']);
                $this->db->update('tMembers', $dbdata2);
                
            }

            //echo 'don in model - before if: ' . $param['donation'] . '<br>';
            if(intval($param['donation']) > 0) {
                //$don_paid = $param['total'] - ($mem_paid + $paydata['carrier']);
                $don_paid = $param['donation'];
                //echo 'don in model - in if: ' . $don_paid . '<br>';
                $dbdata = array(
                    'id_member' => $mem_arr['id_members'],
                    'id_payaction' => 5,
                    'id_entity' => 2,
                    'amount' => $don_paid,
                    'paydate' => time(),
                    'result' => 'success',
                    'val_string' => $valstr,
                    'flag' => 0,
                    'for_year' => $cur_yr,
                    'id_transaction' => $last_trans
                );
                $this->db->insert('mem_payments', $dbdata);
            }

            //echo '<br><br>total: ' . $param['total'] . ' fee: ' . number_format($param['total'] * 0.029 + .3, 2, '.', ',') ;
            //$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
            //echo '<br><br>total: ' . $param['total'] . ' fee: ' . floatval(number_format($param['total'] * 0.029 + .3, 2));
            
            $to      = 'jkulisek.us@gmail.com, jan_kulisek@hotmail.com, mdarc-memberships@arrleb.org';
            //$to      = 'jan_kulisek@hotmail.com, jkulisek.us@gmail.com, bwhysong@gmail.com, mdarc-memberships@arrleb.org';
            $subject = 'MDARC Payment';

            $message = "Payment to MDARC Stripe account was just made on: " . date('F j, Y, g:i a', $time_stamp) . "\nPayment for MDARC member " . $mem_arr['fname'] . " ". $mem_arr['lname'] . "\nEmail: " . $param['email'] . "\nMembership amount: $" . number_format($mem_paid, 2, '.', ',') . " (Current year " . $cur_yr . ' )' . "\nDonation amount: $" . number_format($don_paid, 2, '.', ',') . "\nThe Carrier amount: $" . number_format($carr_paid, 2, '.', ',') .  "\nTotal amount: $" . number_format($param['total'], 2, '.', ',') . "\nEmail generated by MDARC Payment Gateway - Stand-Alone App at https://pay-v1b.jlkconsulting.info/index.php/mdarc";

            $headers = array(
                'From' => 'webmaster@jlkconsulting.info',
                'Reply-To' => 'webmaster@jlkconsulting.info',
                'X-Mailer' => 'PHP/' . phpversion()
            );

            mail($to, $subject, $message, $headers);

            $to      = $param['email'];
            $subject = 'MDARC Payment: Thank You!';

            $message = "You made a payment to MDARC on: " . date('F j, Y, g:i a', $time_stamp) . "\nPayment for MDARC Member " . $mem_arr['fname'] . " ". $mem_arr['lname'] . "\nMembership amount: $" . number_format($mem_paid, 2, '.', ',') . " (Current year " . $cur_yr . ' )' . "\nDonation amount: $" . number_format($don_paid, 2, '.', ',') . "\nThe Carrier amount: $" . number_format($carr_paid, 2, '.', ',') .  "\nTotal amount: $" . number_format($param['total'], 2, '.', ',') . "\nThank you for being a loyal MDARC member!\nEmail generated by MDARC Payment Gateway - Stand-Alone App at https://pay-v1b.jlkconsulting.info/index.php/mdarc";

            $headers = array(
                'From' => 'webmaster@jlkconsulting.info',
                'Reply-To' => 'webmaster@jlkconsulting.info',
                'X-Mailer' => 'PHP/' . phpversion()
            );

            mail($to, $subject, $message, $headers);
            
            $retval['mem_amount'] = $mem_paid;
            $retval['don_amount'] = $don_paid;
            $retval['carr_amount'] = $carr_paid;
            $retval['total'] = $param['total'];

        
        return $retval;
    }

    public function get_paydata() {
        $retarr = array();
        $this->db->select('amount');
        $this->db->where('id_payaction', 1);
        $res = $this->db->get('payactions')->row();
        $retarr['membership'] = $res->amount;

        $this->db->reset_query();
        $this->db->select('amount');
        $this->db->where('id_payaction', 10);
        $res = $this->db->get('payactions')->row();
        $retarr['carrier'] = $res->amount;

        $this->db->reset_query();
        $this->db->select('amount');
        $this->db->where('id_payaction', 16);
        $res = $this->db->get('payactions')->row();
        $retarr['student_amt'] = $res->amount;

        $this->db->reset_query();
        $this->db->select('amount');
        $this->db->where('id_payaction', 17);
        $res = $this->db->get('payactions')->row();
        $retarr['trans_fee'] = $res->amount;

        $this->db->reset_query();
        $this->db->select('amount');
        $this->db->where('id_payaction', 18);
        $res = $this->db->get('payactions')->row();
        $retarr['trans_per'] = $res->amount;

        return $retarr;
    }

    public function check_email($email) {
        $retval = true;
        $this->db->select('email');
        $this->db->where('email', $email);
        $this->db->from('tMembers');
        if($this->db->count_all_results() == 0) $retval = false;

        return $retval;
    }

    public function get_member($email) {
        $this->db->select('*');
        $this->db->where('email', $email);
        $res = $this->db->get('tMembers')->row();
        $retarr['id_members'] = $res->id_members;
        $retarr['fname'] = $res->fname;
        $retarr['lname'] = $res->lname;
        $retarr['callsign'] = $res->callsign;
        $retarr['email'] = $email;
        $retarr['cur_year'] = $res->cur_year;
        return $retarr;
    }

    public function check_student($email) {
        $retval = false;

        $this->db->select('*');
        $this->db->where('email', $email);
        $this->db->where('id_mem_types', 5);
        $this->db->from('tMembers');
        if($this->db->count_all_results() == 0) $retval = true;

        return $retval;
    }

    private function guid() {
        if (function_exists('com_create_guid') === true)
            return trim(com_create_guid(), '{}');
        
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        }

}