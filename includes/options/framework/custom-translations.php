<?php

$default_text_arr = [
    'Now showing',
    'Latest episode',
    'Genres',
];

$default_text = json_encode(apply_filters('halim_custom_translation_text_default', array_combine($default_text_arr, $default_text_arr)), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// ----------------------------------------
// a option section for options overview  -
// ----------------------------------------
$options[]      = array(
    'name'        => 'custom_translation',
    'title'       => 'Custom Translation',
    'icon'        => 'fa fa-language',

    // begin: fields
    'fields'      => array(

      array(
        'type'    => 'notice',
        'class'   => 'info',
        'content' => 'This tab contains common setting options which will be applied to the whole theme.',
      ),

      array(
        'id'    => 'enable_custom_translation',
        'type'  => 'switcher',
        'title' => 'Enable Custom Translation',
        'default' => true,
      ),

      array(
        'id'      => 'custom_translation',
        'type'    => 'textarea',
        'title'   => 'Custom Translation',
        'sanitize' => true,
        'default' => $default_text,
        'desc'    => 'Custom Translation...',
        'before'   => '<p class="cs-text-warning"><pre><strong>Default configuration:</strong>'."\n".$default_text.'</pre></p>',
        'attributes'    => array(
          'rows'        => 35,
          // 'placeholder' => '// Do Stuff',
          'style'       => 'border: 1px solid #0073aa; color: #0073aa;',
        ),
      ),

    ), // end: fields
  );
