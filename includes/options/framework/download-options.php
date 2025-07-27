<?php

$options[]   = array(
    'name'     => 'download_section',
    'title'    => 'File download',
    'icon'     => 'fa fa-download',
    'fields'   => array(

        // array(
        //     'type'    => 'notice',
        //     'class'   => 'info',
        //     'content' => 'Enable or disable social sharing buttons on single posts using these buttons.',
        // ),


        array(
          'id'    => 'enable_download_fields',
          'type'  => 'switcher',
          'title' => 'Enable Download Metaboxes',
          'default' => true,
        ),


        array(
          'id'         => 'download_fields_display',
          'type'       => 'checkbox',
          'title'      => 'Select fields to display',
          'class'      => 'horizontal',
          'options'    => array(
            'language'     => 'File Language',
            'added'    => 'Date Added',
            'view'   => 'Clicks',
            'size'      => 'File size',
            'quality'    => 'File quality',
          ),
          'default'    => array( 'language', 'added', 'view', 'size', 'quality' )
        ),

      array(
          'id'       => 'dl_ads_countdown_time',
          'type'     => 'number',
          'title'    => 'Number of seconds countdown to show download button',
          'default' => '10',
          'after'   => ' <i class="cs-text-muted">(seconds)</i>',
      ),
      array(
        'id'      => 'dl_top_ads',
        'type'    => 'textarea',
        'title'   => 'Ad above the download page',
        'sanitize' => true,
        'desc'    => 'Use HTML, CSS, JS code',
        'default' => '<a href="https://www.vultr.com/?ref=6999872"><img src="https://www.vultr.com/media/banners/banner_468x60.png"></a>',
      ),

      array(
        'id'      => 'dl_bottom_ads',
        'type'    => 'textarea',
        'title'   => 'Ad below the download page',
        'sanitize' => true,
        'desc'    => 'Use HTML, CSS, JS code',
        'default' => '<a href="https://www.vultr.com/?ref=6999872" target="_blank"><img src="https://i.imgur.com/QBDFOlb.png"></a><hr><a href="https://www.vultr.com/?ref=6999872"><img src="https://www.vultr.com/media/banners/banner_468x60.png"></a>',
      ),



    )
);