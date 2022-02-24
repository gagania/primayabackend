<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$config['protocol']    = 'smtp';
//$config['smtp_host']    = 'ssl://ezweb01.oncloud.co.id';
$config['smtp_host']    = 'smtp.hostinger.co.id';
$config['smtp_port']    = '587';
$config['smtp_timeout'] = '7';
$config['smtp_user']    = 'no-reply@qrlab.id';
$config['smtp_pass']    = 'QrLab2021!@#';
$config['charset']    = 'iso-8859-1';
$config['newline']    = "\r\n";
$config['mailtype'] = 'html'; // or html
$config['validation'] = TRUE; // bool whether to validate email or not    