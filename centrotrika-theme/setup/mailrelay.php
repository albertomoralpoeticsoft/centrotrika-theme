<?php

add_action(
  'phpmailer_init', 
  function($phpmailer) {

    $phpmailer->isSMTP();
    $phpmailer->SMTPAuth = true;
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->Port = 587;    
    $phpmailer->isHTML(true);

    $phpmailer->Host = 'smtp1.s.ipzmarketing.com';
    $phpmailer->Username = 'dyjkxjqebrkl';
    $phpmailer->Password = '6bUUSuSvviEB-Q';

    $phpmailer->From = 'hola@vicenmontserrat.org';
    $phpmailer->FromName = 'Centro Trika';
  }
);

add_action(
  'wp_mail_failed',
  function ($wp_error) {

    error_log('wp_mail_failed');
    error_log(json_encode($wp_error));
  } ,
  10, 
  1 
);

function centrotrika_mail_sendtest( WP_REST_Request $req ) {
      
  $res = new WP_REST_Response();
  
  $process = [];

  $process[] = 'Intento de envio de mail';  

  try { 

    $process = [];

    $mailsent = wp_mail(
      'poeticsoft@gmail.com',
      'Mail test from Centro Trika',
      'Body'
    );

    $process[] = $mailsent ? 'sent' : 'not sent';      

    $res->set_data($process);
  
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

add_action(
  'rest_api_init',
  function () {

    register_rest_route(
      'centrotrika',
      'mail/sendtest',
      [
        'methods'  => 'GET',
        'callback' => 'centrotrika_mail_sendtest',
        'permission_callback' => '__return_true'
      ]
    );
  }
);
