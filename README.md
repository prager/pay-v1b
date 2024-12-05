# Standalone Payment Processing Gateway

This program is intended to process payments for MDARC (Mount Diablo Diablo Amateur Radio Club) via major credit cards. MDARC is a non-profit organization. There are several types of payments that are processed by the Pay-v1 program:

- Membership fees
- Repeater donations
- Club donations
- Processing charge for hard copy of The Carrier newsletter

### Pacificon Ham Radio Convention

MDARC is hosting annual Pacificon Ham Radio Convention and Pay-v1 is also intended to process admission and vendor fees for the event

### Technology

It is a web application written in PHP using CodeIgniter 3 PHP framework with MySQL database on the back end. The URL is https://pay-v1b.jlkconsulting.info/index.php/mdarc

### Concept

The program is intended to be used as a component of other MDARC web portals such as the Membership Portal https://mdarc.jlkconsulting.info, main MDARC website at https://mdarc.org and Pacificon website at https://pacificon.org

### Main Component

Program is inspired by https://www.itsolutionstuff.com/post/stripe-payment-gateway-integration-in-codeigniter-exampleexample.html
Main component is Stripe PHP library downloaded from https://github.com/stripe/stripe-php

## CodeIgniter 3 Framework - What is CodeIgniter

CodeIgniter is an Application Development Framework - a toolkit - for people
who build web sites using PHP. Its goal is to enable you to develop projects
much faster than you could if you were writing code from scratch, by providing
a rich set of libraries for commonly needed tasks, as well as a simple
interface and logical structure to access these libraries. CodeIgniter lets
you creatively focus on your project by minimizing the amount of code needed
for a given task.

### Release Information

This repo contains in-development code for future releases. To download the
latest stable release please visit the `CodeIgniter Downloads
https://codeigniter.com/download

### Changelog and New Features

You can find a list of all changes for each release in the `user
guide change log https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/changelog.rst

### Server Requirements

PHP version 5.6 or newer is recommended.
It should work on 5.3.7 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

### Installation

Please see the installation section https://codeigniter.com/userguide3/installation/index.html>
of the CodeIgniter User Guide.

### License

Please see the `license
agreement https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/license.rst

### Resources

- User Guide https://codeigniter.com/docs
- Contributing Guide https://github.com/bcit-ci/CodeIgniter/blob/develop/contributing.md
- Language File Translations <https://github.com/bcit-ci/codeigniter3-translations
- Community Forums http://forum.codeigniter.com/
- Community Wiki https://github.com/bcit-ci/CodeIgniter/wiki
- Community Slack Channel <https://codeigniterchat.slack.com>

Report security issues to our Security Panel mailto:security@codeigniter.com>
or via our page on HackerOne https://hackerone.com/codeigniter thank you.

### Acknowledgement

The CodeIgniter team would like to thank EllisLab, all the
contributors to the CodeIgniter project and you, the CodeIgniter user.
