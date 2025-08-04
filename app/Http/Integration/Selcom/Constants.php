<?php


namespace App\Http\Integration\Selcom;


class Constants
{ 
    // test
    //production
    const ENDPOINT_VALUATION_PAYMENT_CALLBACK_URI = 'https://thamani.co.tz/api/selcom/payment-callback';
    const ENDPOINT_CHECKOUT_REQUEST = 'https://apigw.selcommobile.com/v1/checkout/create-order-minimal';
    const ENDPOINT_CANCELED_PAYMENT = 'https://thamani.co.tz/';
    const ENDPOINT_ALL_ORDERS = 'http://apigw.selcommobile.com/v1/checkout/list-orders?fromdate={from_date}&todate={to_date}';
    const ENDPOINT_WALLET_PAYMENT = 'https://apigw.selcommobile.com/v1/checkout/wallet-payment';


      const VENDOR_ID = 'TILL60611001';

       const API_KEY = 'MACHO-dt3gtc5sQgbCv8pA'; //Production
       const API_SECRET = '2944a8e6-c981-48e3-9572-66dcc5167245'; //Production

    const PAYMENT_EXPIRY = 24 * 60 * 10;
}

