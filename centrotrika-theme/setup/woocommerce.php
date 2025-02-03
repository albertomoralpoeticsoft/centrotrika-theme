<?php

// Filtra los campos del checkout de WooCommerce para eliminar información innecesaria
add_filter(
  'woocommerce_checkout_fields', 
  function($fields) {
    // Se eliminan los campos de facturación relacionados con la empresa y dirección
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);

    // Se eliminan los comentarios de pedido
    unset($fields['order']['order_comments']);

    // Se eliminan los campos de cuenta para evitar que los usuarios creen una cuenta durante el checkout
    unset($fields['account']['account_username']);
    unset($fields['account']['account_password']);
    unset($fields['account']['account_password-2']);

    return $fields;
  }
);

// Agrega nuevos campos personalizados en el checkout (ahora "Experiencia previa" y "Motivo de reserva" son opcionales)
add_action(
  'woocommerce_after_order_notes', 
  function ($checkout) {
    // Campo para capturar la experiencia previa (ahora opcional)
    woocommerce_form_field(
      'experiencia_previa', 
      [
        'type' => 'textarea',
        'label' => __('Experiencia previa'),
        'placeholder' => __('Experiencia previa')
      ],
      $checkout->get_value('experiencia_previa')
    );

    // Campo para saber la motivación del usuario para reservar (ahora opcional)
    woocommerce_form_field(
      'motivo_reserva', 
      [
        'type' => 'textarea',
        'label' => __('¿Qué te motiva a probar nuestra propuesta?'),
        'placeholder' => __('¿Qué te motiva a probar nuestra propuesta?')
      ],
      $checkout->get_value('motivo_reserva')
    );
  }
);

// Agrega una casilla de aceptación de términos y condiciones
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

// Validar campos personalizados antes de procesar la orden (se eliminó la validación de "Experiencia previa" y "Motivo de reserva")
add_action(
  'woocommerce_checkout_process', 
  function () {
    // Se mantiene solo la validación de términos y condiciones
    if (!isset($_POST['terms_and_conditions'])) {
      wc_add_notice(
        __('Has de aceptar los términos y condiciones.'), 
        'error'
      );
    }
  }
);

// Guarda los valores de los campos personalizados en los metadatos del pedido
add_action( 
  'woocommerce_checkout_create_order', 
  function ($order, $data) {
    // Guarda "Experiencia previa" si se ingresó
    if (isset($_POST['experiencia_previa']) && !empty($_POST['experiencia_previa'])) {
      $order->update_meta_data( 
        'experiencia_previa', 
        sanitize_text_field($_POST['experiencia_previa']) 
      );
    } 

    // Guarda "Motivo de la reserva" si se ingresó
    if (isset($_POST['motivo_reserva']) && !empty($_POST['motivo_reserva'])) {
      $order->update_meta_data( 
        'motivo_reserva', 
        sanitize_text_field($_POST['motivo_reserva']) 
      );
    }  
  }, 
  10, 
  2 
);

// Muestra los valores de los campos personalizados en la página de administración de pedidos
add_action( 
  'woocommerce_admin_order_data_after_billing_address', 
  function($order) {
    echo '<p><strong>' . __('Información adicional') . '</strong></p>' . 
         '<p><strong>' . __('Experiencia Previa') . ':</strong> ' . esc_html($order->get_meta('experiencia_previa')) . '</p>' . 
         '<p><strong>' . __('Motivo Reserva') . ':</strong> ' . esc_html($order->get_meta('motivo_reserva')) . '</p>';
  }, 
  10, 
  1 
);

// Agrega la información personalizada en los correos electrónicos del pedido
add_action(
  'woocommerce_email_after_order_table', 
  function ($order, $sent_to_admin, $plain_text, $email) {
    if ($sent_to_admin) {
      echo '<p><strong>' . __('Información adicional') . '</strong></p>' . 
           '<p><strong>' . __('Experiencia Previa') . ':</strong> ' . esc_html($order->get_meta('experiencia_previa')) . '</p>' . 
           '<p><strong>' . __('Motivo Reserva') . ':</strong> ' . esc_html($order->get_meta('motivo_reserva')) . '</p>';
    }
  }, 
  10, 
  4 
);

// Agrega los metadatos personalizados al correo electrónico de pedidos
add_filter(
  'woocommerce_email_order_meta_fields', 
  function ($fields, $sent_to_admin, $order) {
    // Agrega el campo "Experiencia Previa" si existe
    $fields['experiencia_previa'] = [
      'label' => __('Experiencia previa'),
      'value' => $order->get_meta('experiencia_previa')
    ];

    // Agrega el campo "Motivo de la reserva" si existe
    $fields['motivo_reserva'] = [
      'label' => __('¿Qué te motiva a probar nuestra propuesta?'),
      'value' => $order->get_meta('motivo_reserva')
    ];

    return $fields;
  }, 
  10, 
  3
);
