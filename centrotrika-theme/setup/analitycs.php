<?php

add_action(  
  'wp_head', 
  function () {
    ?>

      <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-15RZMM1QXB"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'G-15RZMM1QXB');
          gtag('config', 'AW-11480479572');
        </script>
      <!-- End Google tag (gtag.js) -->

    <?php
  }
);