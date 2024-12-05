<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>About</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="shortcut icon" href="<?php echo base_url() ;?>assets/img/mdarc-icon.ico" type="image/x-icon" />
    </head>
    <body>
        <div class="container">
            <div class="row mt-5">
                <div class="col-sm-10 offset-sm-1">
                    <h2>About Pay-v1b</h2>
                    <p>This program is intended to process payments for MDARC (Mount Diablo Diablo Amateur Radio Club) via major credit cards. MDARC is a non-profit organization. There are several types of payments that are processed by the Pay-v1 program:</p>
                    <ul>
                        <li class="has-line-data" data-line-start="2" data-line-end="3">Membership fees</li>
                        <li class="has-line-data" data-line-start="3" data-line-end="4">Repeater donations</li>
                        <li class="has-line-data" data-line-start="5" data-line-end="6">Processing charge for hard copy of The Carrier newsletter</li>
                    </ul>
                    <h3>Pacificon Ham Radio Convention</h3>
                    <p>MDARC is hosting annual Pacificon Ham Radio Convention and Pay-v1 is also intended to process admission and vendor fees for the event</p>
                    <h3>Technology</h3>
                    <p class="has-line-data" data-line-start="9" data-line-end="10">It is a web application written in PHP using CodeIgniter 3 PHP framework with MySQL database on the back end.</p>
                    <p>Inspired by <a href="https://www.itsolutionstuff.com/post/stripe-payment-gateway-integration-in-codeigniter-exampleexample.html" target="_blank">Hardik Savani</a> and using stripe-php library <a href="https://github.com/stripe/stripe-php" target="_blank">https://github.com/stripe/stripe-php</a></p>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col offset-sm-1">
                    <hr>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col offset-sm-1">
                    Provided by <a href="https://jlkconsulting.info">JLK Consulting</a>
                </div>
            </div>
        </div>
    </body>
</html>