<!DOCTYPE html>
<html>
<head>
    <title>MDARC Payments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="<?php echo base_url() ;?>assets/img/mdarc-icon.ico" type="image/x-icon" />
    <style type="text/css">

        .panel-title {
        display: inline;
        font-weight: bold;
        }

        .display-table {
            display: table;
        }

        .display-tr {
            display: table-row;
        }

        .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 61%;
        }
    </style>
</head>
<body>

<!-- Modals: https://getbootstrap.com/docs/3.3/javascript/#modals -->

<div class="container">
	<div class="row">
		<div class="col co-md-offset-3 text-center">
			<h1>MDARC Payments</h1>
		</div>
	</div>
	<div class="row">
		<div class="col">&nbsp;</div>
	</div>
    <div class="row mt-3">
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
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p><?php echo $this->session->flashdata('success'); ?></p>
                        </div>
                    <?php } ?>

                    <form role="form" action="<?php echo base_url(); ?>index.php/mdarc-post" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="<?php echo $this->config->item('mdarc_key') ?>" id="payment-form">
					
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name on Card</label> 
                                <input class='form-control' size='4' type='text' id="cc_name" name="cc_name" >
                            </div>
                        </div>

						<div class='form-row row'>
                            <div class='col-xs-8 form-group'>
                                <label class='control-label'>MDARC Email</label> 
                                <input class='form-control' size='4' type='text' id="email" name="email">
                            </div>
                        </div>
						<div class='row'>
                            <div class='col-xs-12'>
                                <hr>
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-xs-4 form-group'>
                                <label class='control-label'>Membership</label> 
                                <input type="checkbox" id="mem" name="mem" value="mem" onclick="set_pay()" checked>
                                <input class='form-control' size='4' type='text' id="memamount" name="memamount" value="$45.00" disabled>
                            </div>
                            <div class='col-xs-4 form-group'>
                                <label class='control-label'>The Carrier ($18.00)</label> 
                                <input type="checkbox" id="carrier" name="carrier" value="carrier" onclick="set_pay()">
                                <input class='form-control' size='4' type='text' id="carramnt" name="carramnt" value="$0.00" disabled>
                            </div>
                            <div class='col-xs-4 form-group'>
                                <label class='control-label'>Donation</label> 
                                <input type="checkbox" id="donation" name="donation" value="donation" onclick="set_pay()" disabled>
                                <input class='form-control' size='4' type='text' id="donamnt" name="donamnt" value="$0.00" onclick="en_check()">
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-2'>&nbsp;</div>
                            <div class='col-xs-10'>(The $18.00 is for The Carrier hardcopy via USPS)</div>
                            <input type='hidden' id='proc_total' name='proc_total' value = '45'>
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
                                <label class='control-label'>Expiration Year</label> <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                            </div>
                        </div>
                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger alert'>Please correct the errors and try again.</div>
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now <span id="tot_btn">$45.00</span></button>
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
            <a href="https://stripe.com/docs/testing#cards" target="_blank" class="text-decoration-none">Testing Mode</a> | <a href="<?php echo base_url();?>index.php/about" target="_blank">About</a>
        </div>
    </div>
    <div class="row" style="height: 60px; ">
        <div class="col">
            &nbsp;
        </div>
    </div>

</div>
</body> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">

function set_pay() {
    var memb = 0;
    var carr = 0;
    var tot = 0;
    var don = 0;
    if(document.getElementById("mem").checked == true) {
        document.getElementById("memamount").defaultValue = "$45.00";
        memb += 45;
    }
    else {
        document.getElementById("memamount").defaultValue = "$0.00";
        if(memb > 44)
            memb -= 45;
    }

    if(document.getElementById("carrier").checked == true) {
        document.getElementById("carramnt").defaultValue = "$18.00";
        carr += 18;
    }
    else {
        document.getElementById("carramnt").defaultValue = "$0.00";
        if(carr > 17)
            carr -= 18;
    }

    if(document.getElementById("donation").checked == true) {
        var donStr = document.getElementById("donamnt").value;
        var dolSign = donStr.substring(0, 1);
        if(dolSign == "$")  {
            don = donStr.substring(1, donStr.length - 1);
        }
        else {
            don = donStr;
        }
        if(parseFloat(don) < 5) {
            alert("Donation must be at least $5.00");
            document.getElementById("donation").checked = false;
            document.getElementById("donamnt").defaultValue = "$0.00";
            don = 0;
        }
    }

    if(document.getElementById("donation").checked == false) {
        document.getElementById("donamnt").defaultValue = "$0.00";
        don = 0;
    }

    tot = memb + carr + parseFloat(don);
    document.getElementById("tot_btn").textContent="$" + tot.toFixed(2);
    document.getElementById("proc_total").value = tot;
}

function en_check() {
    document.getElementById("donation").disabled = false;
}

$(function() {
	var $form = $(".require-validation");
  $('form.require-validation').bind('submit', function(e) {
    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('hide');
        e.preventDefault();
      }
    });

    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  });

  function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            var token = response['id'];
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
});
</script>
</html>
