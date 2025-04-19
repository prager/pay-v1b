<!DOCTYPE html>
<html>
<head>
    <title>MDARC Payments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ;?>/assets/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="<?php echo base_url() ;?>/assets/img/mdarc-icon.ico" type="image/x-icon" />
</head>
<body>
<ol class="breadcrumb text-center">
  <li class="active"><a href="<?php echo base_url(); ?>index.php/mdarc">Home</a></li>
  <li><a href="https://www.mdarc.org" target="_blank">MDARC</a></li>
  <li><a href="https://mdarc.jlkconsulting.info">Member Portal</a></li>
  <li><a href="<?php echo base_url();?>index.php/about" target="_blank">About</a></li>
</ol>
<div class="container">

	<div class="row">
		<div class="col text-center">
			<h1>MDARC Payments</h1>            
		</div>
	</div>
	
    <div class="row" style="padding-top: 15px;">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                        <h3 class="panel-title display-td">Payment Details</h3>
                        <div class="display-td" >
                            <img class="img-responsive pull-right" src="https://files.kulisek.org/cc.png">
                        </div>
                    </div> 
                </div>

                <div class="panel-body">
                    <?php if($this->session->flashdata('success')){ ?>
                    <div class="alert alert-success text-center">
                            <a href="<?php echo base_url(); ?>index.php/mdarc" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p><?php echo $this->session->flashdata('success'); ?></p>
                        </div>
                    <?php } ?>

                    <form role="form" action="<?php echo base_url(); ?>index.php/mdarc-post" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="<?php echo $this->config->item('mdarc_key') ?>" id="payment-form">
					
                    <input type='hidden' id='mem_val' name='mem_val' value = <?php echo $membership; ?> >

                        <div class='form-row row'>
                            <div class='col-xs-12 form-group name required'>
                                <label class='control-label'>Name on Card</label> 
                                <input class='form-control' size='4' type='text' id="cc_name" name="cc_name" >
                            </div>
                        </div>

						<div class='form-row row'>
                            <div class='col-xs-6 form-group required'>
                                <label class='control-label'>Your MDARC Listed Email</label> 
                                <input class='form-control' size='4' type='email' id="email" name="email">
                            </div>
                            <div class="col-xs-6 form-group">
                            <br />
                                <input type="checkbox" id="student" name="student" value="studentval" onchange="set_pay(<?php echo $membership; ?>, <?php echo $carrier; ?>)">
                                <label>Student in MDARC records?</label>
                                
                            </div>
                        </div>
                        <?php if(strlen($val_msg) > 0) { ?>
                            <div class="row" style="padding-bottom: 10px; color: red;">
                                <div class="col text-center"><?php echo $val_msg; ?></div>
                            </div>
                        <?php } ?>
						<div class='row'>
                            <div class='col-xs-12'>
                                <hr>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom: 7px; color: #e69f65;">
                            <div class="col-xs-12 text-center">
                                <p class="control-label"><strong>If amount is to be processed then checkbox must be checked</strong></p>
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-xs-1'>&nbsp;</div>
                            <div class='col-xs-5 form-group'>
                                <label class='control-label'>Membership</label> 
                                <input type="checkbox" id="mem" name="mem" value="mem" onclick="set_pay(45, <?php echo $carrier; ?>)" checked>
                                <input class='form-control' size='4' type='text' id="memamount" name="memamount" value="$<?php echo $membership; ?>.00" disabled>
                            </div>
                            <div class='col-xs-5 form-group'>
                                <label class='control-label'>The Carrier $(<?php echo $carrier; ?>.00)</label> 
                                <input type="checkbox" id="carrier" name="carrier" value="carrier" onclick="set_pay(45, <?php echo $carrier; ?>)">
                                <input class='form-control' size='4' type='text' id="carramnt" name="carramnt" value="$0.00" disabled>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-2'>&nbsp;</div>
                            <div class='col-xs-10'>(The $18.00 is for The Carrier hardcopy via USPS)</div>
                            
                        </div>
                        <div class="form-row row" style="padding-top: 10px;">
                            <div class="col-xs-1">&nbsp;</div>
                            <div class='col-xs-5 form-group'>
                                <label class='control-label'>Donation MDARC</label> 
                                <input type="checkbox" id="donation" name="donation" value="donation" onclick="set_pay(45, <?php echo $carrier; ?>)" disabled>
                                <input class='form-control' size='4' type='text' id="donamnt" name="donamnt" value="$0.00" onclick="en_check()" onfocus="this.select();">
                            </div>
                            <div class='col-xs-5 form-group'>
                            <label class='control-label'>Donation Repeater</label> 
                                <input type="checkbox" id="don_rep" name="don_rep" value="don_rep" onclick="set_pay(45, <?php echo $carrier; ?>)" disabled>
                                <input class='form-control' size='4' type='text' id="repamnt" name="repamnt" value="$0.00" onclick="en_check_rep()" onfocus="this.select();">
                            </div>
                        </div>

                        <div class="row">&nbsp;</div>
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Card Number</label> <input autocomplete='off' class='form-control card-number' size='20' type='text'>
							</div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> 
                                <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                                <input type='hidden' id='proc_total' name='proc_total' value = '45'>
                                <input type='hidden' id='don_val' name='don_val' value = '' >
                                <input type='hidden' id='don_rep_val' name='don_rep_val' value = '' >
                                
                                <input type='hidden' id='car_val' name='car_val' value = <?php echo $carrier; ?> >
                            </div>
                        </div>
                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger alert'>Please correct the errors and try again.</div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-12'>
                                <hr>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 10px; padding-bottom: 15px;">
                            <div class="col-xs-12 text-center">
                                <input type="checkbox" id="ensubmit" name="ensubmit" value="ensubmit" onchange="document.getElementById('btnsubmit').disabled = !this.checked">
                                <label>Check the total and agree with <a href="<?php echo base_url();?>index.php/terms" target="_blank">Terms and Conditions</a> to submit</label> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button id="btnsubmit" class="btn btn-primary btn-lg btn-block" type="submit" disabled>Pay Now Total = <span id="tot_btn">$45.00</span></button>
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>
                    </form>
                </div>
            </div> 
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?php //echo phpinfo(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            &nbsp;
        </div>
    </div>
    <div class="row">
        <div class="col-ms-10 col-md-offset-1">
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?php //echo phpinfo(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-md-offset-2">
            &copy; <a href="https://jlkconsulting.info" target="_blank">JLK Consulting</a>
        </div>
        <div class="col-sm-4 text-right">
            <a href="https://stripe.com/docs/testing#cards" target="_blank" class="text-decoration-none">Testing Mode</a> | <a href="<?php echo base_url();?>index.php/terms" target="_blank">Terms & Conditions</a>
        </div>
    </div>
    <div class="row" style="height: 60px; ">
        <div class="col">
            &nbsp;
        </div>
    </div>
</div>
</body> 
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="<?php echo base_url() ;?>/assets/js/main.js"></script>
<script>
    const button = document.getElementById('btnsubmit');
 
    button.addEventListener('click', function(event) {
        //alert('Payment is being submitted! Thank you!')
		setTimeout(function () { 
            event.target.disabled = true;
        }, 0); 
    });
</script>
</html>