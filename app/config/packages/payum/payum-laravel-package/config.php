<?php

use Payum\Core\Storage\FilesystemStorage;
use Payum\Paypal\ExpressCheckout\Nvp\Api;
use Payum\Paypal\ExpressCheckout\Nvp\PaymentFactory as PaypalPaymentFactory;

$detailsClass = 'Payum\Core\Model\ArrayObject';
$tokenClass = 'Payum\Core\Model\Token';

$paypalPayment = PaypalPaymentFactory::create(new Api(array(
    'username' => 'mail-address',
    'password' => 'password',
    'signature' => 'signature',
    'sandbox' => false
)));

return array(
    'token_storage' => new FilesystemStorage(__DIR__.'/../../../../storage/payments', $tokenClass, 'hash'),
    'payments' => array(
        'paypal_es' => $paypalPayment,
    ),
    'storages' => array(
        $detailsClass => new FilesystemStorage(__DIR__.'/../../../../storage/payments', $detailsClass),
    )
);