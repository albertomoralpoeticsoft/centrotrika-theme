<?php

add_filter(
  'woocommerce_checkout_fields', 
  function($fields) {

    // unset($fields['billing']['billing_first_name']);
    // unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    // unset($fields['billing']['billing_phone']);
    unset($fields['order']['order_comments']);
    // unset($fields['billing']['billing_email']);
    unset($fields['account']['account_username']);
    unset($fields['account']['account_password']);
    unset($fields['account']['account_password-2']);

    return $fields;
  }
);

add_action(
  'woocommerce_after_order_notes', 
  function ($checkout) {

    woocommerce_form_field(
      'experiencia_previa', 
      [
        'type' => 'textarea',
	      'required' => 'true',
        'label' => __('Experiencia previa'),
        'placeholder' => __('Experiencia previa'),
        'required' => true
      ],
      $checkout->get_value('experiencia_previa')
    );

    woocommerce_form_field(
      'motivo_reserva', 
      [
        'type' => 'textarea',
	      'required' => 'true',
        'label' => __('¿Qué te motiva a probar nuestra propuesta?'),
        'placeholder' => __('¿Qué te motiva a probar nuestra propuesta?'),
        'required' => true
      ],
      $checkout->get_value('motivo_reserva')
    );

    woocommerce_form_field(
      'fecha_clase', 
      [
        'type' => 'date',
	      'required' => 'true',
        'label' => __('Fecha de la clase'),
        'required' => true
      ],
      $checkout->get_value('fecha_clase')
    );
  }
);

add_action( 
  'woocommerce_checkout_before_terms_and_conditions', 
  function () {

    $privacy_policy_page_id = wc_privacy_policy_page_id();
    $privacy_policy_url = $privacy_policy_page_id ? 
      get_permalink($privacy_policy_page_id) 
      : 
      '#';


    echo '<div class="woocommerce-terms-and-conditions">';
    woocommerce_form_field( 
      'terms_and_conditions', 
      array(
        'type'          => 'checkbox',
        'class'         => ['form-row terms'],
        'required'      => true,
        'label'         => __('He leído y acepto los <a href="' . esc_url($privacy_policy_url) . '">términos y condiciones</a>.'),
      ),  
      WC()->checkout->get_value( 'terms_and_conditions' )
    );
    echo '</div>';
  } 
);

add_action(
  'woocommerce_checkout_process', 
  function () {

    if (empty($_POST['experiencia_previa'])) {

      wc_add_notice(
        __(
          'El campo "Experiencia Previa" es obligatorio.', 
          'centrotrika'
        ), 
        'error'
      );
    }

    if (empty($_POST['motivo_reserva'])) {

      wc_add_notice(
        __('El campo "¿Qué te motiva a probar nuestra propuesta?" es obligatorio.'), 
        'error'
      );
    }

    if (empty($_POST['fecha_clase'])) {

      wc_add_notice(
        __('El campo "Fecha de la clase" es obligatorio.'), 
        'error'
      );
    }

    if(!$_POST['terms_and_conditions']) {

      wc_add_notice(
        __('Has de aceptar los términos y condiciones.'), 
        'error'
      );
    }
  }
);

add_action( 
  'woocommerce_checkout_create_order', 
  function ( 
    $order, 
    $data 
  ) {

    if(isset($_POST['experiencia_previa']) && !empty($_POST['experiencia_previa'])) {

      $order->update_meta_data( 
        'experiencia_previa', 
        sanitize_text_field($_POST['experiencia_previa']) 
      );
    } 

    if(isset($_POST['motivo_reserva']) && !empty($_POST['motivo_reserva'])) {

      $order->update_meta_data( 
        'motivo_reserva', 
        sanitize_text_field($_POST['motivo_reserva']) 
      );
    }  

    if(isset($_POST['fecha_clase']) && !empty($_POST['fecha_clase'])) {

      $order->update_meta_data( 
        'fecha_clase', 
        sanitize_text_field($_POST['fecha_clase']) 
      );
    } 
  }, 
  10, 
  2 
);

add_action( 
  'woocommerce_admin_order_data_after_billing_address', 
  function($order) {

    echo '<p><strong>' . __('Información adicional') . '</strong></p>' . 
         '<p><strong>' . __('Experiencia Previa') . ':</strong> ' . $order->get_meta('experiencia_previa') . '</p>' . 
         '<p><strong>' . __('Motivo Reserva') . ':</strong> ' . $order->get_meta('motivo_reserva') . '</p>' . 
         '<p><strong>' . __('Fecha Clase') . ':</strong> ' . $order->get_meta('fecha_clase') . '</p>' . 
         '<p>&nbsp;</p>';
  }, 
  10, 
  1 
);

add_action(
  'woocommerce_email_after_order_table', 
  function ( 
    $order, 
    $sent_to_admin, 
    $plain_text, 
    $email 
  ) {

    if($sent_to_admin) {

      echo '<p><strong>' . __('Información adicional') . '</strong></p>' . 
          '<p><strong>' . __('Experiencia Previa') . ':</strong> ' . $order->get_meta('experiencia_previa') . '</p>' . 
          '<p><strong>' . __('Motivo Reserva') . ':</strong> ' . $order->get_meta('motivo_reserva') . '</p>' . 
          '<p><strong>' . __('Fecha Clase') . ':</strong> ' . $order->get_meta('fecha_clase') . '</p>' .
          '<p>&nbsp;</p>';
    }
  }, 
  10, 
  4 
);

add_filter(
  'woocommerce_email_order_meta_fields', 
  function (
    $fields, 
    $sent_to_admin, 
    $order 
  ) {

    $fields['experiencia_previa'] = [
      'label' => __('Experiencia previa'),
      'value' => get_post_meta( 
        $order->id, 
        'experiencia_previa', 
        true 
      )
    ];

    $fields['motivo_reserva'] = [
      'label' => __('¿Qué te motiva a probar nuestra propuesta?'),
      'value' => get_post_meta( 
        $order->id, 
        'motivo_reserva', 
        true 
      ),
    ];

    $fields['fecha_clase'] = [
      'label' => __('Fecha de la clase'),
      'value' => get_post_meta( 
        $order->id, 
        'fecha_clase', 
        true 
      ),
    ];

    return $fields;
  }, 
  10, 
  3
);