<?php

return array(
 
    'driver' => 'smtp',
 
    'host' => 'smtp.gmail.com',
 
    'port' => 587,
 
    'from' => array('address' => 'mail@gmail.com', 'name' => 'Müşteri Paneli'),
 
    'encryption' => 'tls',
 
    'username' => 'mail@gmail.com',
 
    'password' => 'password',
 
    'sendmail' => '/usr/sbin/sendmail -bs',
 
    'pretend' => false,
 
);