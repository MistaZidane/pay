Seven Pay PHP Sdk
=======================

This is a payment sdk developed by the Seven Group


Requirements
============

* PHP >= 7
* Latest cURL Extension


Installation
============

        composer require mista/pay


Usage
=====

Add the PayUnit Namespace in your desired controller 

        use SevenPay\PayUnit\PayUnit

Create a new instance of the PayUnit class and pass in all the required attributes

        $myPayment = New PayUnit("your_api_key","your_api_password","your_api_username","your_end_url","product_price");

Call the MakePayment method

        $myPayment->MakePayment();

Recomentdations
=======

Please for security reasons make sure you read your Api key, Api password and Api user from the config file