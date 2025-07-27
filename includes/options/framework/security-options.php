<?php

$options[]   = array(
    'name'     => 'security_section',
    'title'    => 'Security',
    'icon'     => 'fa fa-user-secret',
    'fields'   => array(

        // array(
        //     'type'    => 'notice',
        //     'class'   => 'info',
        //     'content' => 'Enable or disable social sharing buttons on single posts using these buttons.',
        // ),


        array(
          'id'    => 'display_errors',
          'type'  => 'switcher',
          'title' => 'Display All PHP Errors',
          'default' => false,
          'desc' => '<pre style="overflow: hidden;padding: 5px;">ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);</pre>'
        ),

        array(
          'id'    => 'halim_disable_xmlrpc',
          'type'  => 'switcher',
          'title' => 'Disable XML-RPC',
          'default' => true,
        ),

        array(
          'id'    => 'halim_disable_restapi',
          'type'  => 'switcher',
          'title' => 'Disable REST API',
          'default' => true,
        ),

        array(
          'id'    => 'halim_block_bad_query',
          'type'  => 'switcher',
          'title' => 'Block Bad Query',
          'default' => true,
        ),

        array(
          'id'    => 'disable_application_asswords',
          'type'  => 'switcher',
          'title' => 'Disable Application Passwords',
          'default' => true,
        ),


        array(
          'id'    => 'halim_disable_debug',
          'type'  => 'switcher',
          'title' => 'Disable F12 Key, Debug tools in Browser',
          'default' => false,
        ),
        array(
            'id'       => 'haim_debug_redirect_url',
            'type'     => 'text',
            'title'    => 'URL to redirect if debug tool is opened',
            'desc'     => 'URL will redirect to after pressing F12 (Default is: https://halimthemes.com)',
            'attributes' => array(
                'placeholder' => 'https://halimthemes.com',
            ),
            'default' => 'https://halimthemes.com'
        ),
    )
);