<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Confirmed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="<?php echo base_url() ;?>/assets/img/mdarc-icon.ico" type="image/x-icon" />
   
  </head>
  <body>
  <div class="container my-5">
        <div class="p-5 text-center bg-body-tertiary rounded-3">
            <h1 class="text-body-emphasis">Payment completed!</h1>
            <p class="lead">Thank you for supporting MDARC!</p>
            <a href="https://mdarc.jlkconsulting.info" class="btn btn-outline-secondary"> Go back to MDARC Membership Portal </a>
        </div>
    </div>
    <div class="container my-5">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <h4>Payment Details</h4>
          <small>(Details were emailed to <?php echo $mem['email'] . ' Make sure you check your spam folder'; ?>)</small>
        </div>
      </div>
      <div class="row mt-3">
      <div class="col-lg-8 offset-lg-2">
              Payment made on: <?php echo date('F j, Y  g:i a', $time_stamp); ?><br /><br />
              MDARC Members's name and callsign: <?php echo $mem['fname'] . ' ' . $mem['lname'] . ' ' . $mem['callsign']; ?><br /><br />
              Membership amount: <?php echo '$' . number_format($mem_amount, 2, '.', ',') . ' (current year - ' . $cur_yr . ' )'; ?><br /><br />
              Donation (MDARC) amount: <?php echo '$' . number_format($don_amount, 2, '.', ','); ?><br /><br />
              Donation (Repeater) amount: <?php echo '$' . number_format($don_rep_amount, 2, '.', ','); ?><br /><br />
              Hardcopy of The Carrier via USPS: <?php echo '$' . number_format($carr_amount, 2, '.', ','); ?><br /><br />
              -------------------------------------------------------------------<br />
              <strong>Total amount paid: <?php echo '$' . number_format($total, 2, '.', ','); ?></strong><br>
            </div>
      </div>
    </div>
  </body>
</html>