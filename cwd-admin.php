<?php
/*
Plugin Name: Celtic Web Design - Admin
Description: Styling for admin login, plus admin related pages.
Plugin URI: http://www.celticwebdesign.net
Version: 1.0
Author: Darren Stevens
License: GPLv2 or later
*/

/* Start Adding Functions Below this Line */



    // DEVELOPER
    function dev_template_name()
    {
        global $template, $post;
        $template_array = explode('/', $template);

        echo '
            <style>
                .dev-template-name {position:fixed;bottom:100px;left:10px;background: rgba(255,0,0,0.6);color:#fff;padding:2px 4px;font-size:0.8em;z-index: 100;}
            </style>
            ';

        echo '
            <script>
                /*
                Finds the viewport width
                http://matanich.com/test/viewport-width/
                */

                (function ($, root, undefined) {

                    $(function () {

                        var width   = viewportSize.getWidth();
                        var height  = viewportSize.getHeight();

                        function displayWidth() {
                            $(".dev-page-width").text(width);
                            $(".dev-page-height").text(height);
                        }

                        displayWidth();

                        $( window ).resize(function() {
                            width = viewportSize.getWidth();
                            height = viewportSize.getHeight();
                            displayWidth();
                        });

                    });

                })(jQuery, this);
            </script>
            ';

        echo '<span class="dev-template-name">

                WPEngine Staging Env - Legacy Staging<br />';
        echo end($template_array).'<br />';
        echo 'ID: '.get_the_ID().'<br />
                <span class="dev-page-width"></span>px width<br />
                <span class="dev-page-height"></span>px height<br />';

        if (is_user_logged_in()) {
            echo 'Logged IN - ';
            global $current_user;
            $user = wp_get_current_user();
            echo $user->display_name."<br />";

            echo 'Member - ';
            $user_meta = get_userdata($user->ID);
            echo implode(', ', $user_meta->roles);
        } else {
            echo 'Logged OUT';
        }

        echo '</span>';
    }
    add_action('wp_footer', 'dev_template_name', 100);











    // Admin - remove Posts type and Comments
    // http://wordpress.org/support/topic/remove-pages-and-posts-from-dashboard-menu
    function remove_menus()
    {
        global $menu;
        $restricted = array(__('Comments'));
        end($menu);
        while (prev($menu)) {
            $value = explode(' ', $menu[key($menu)][0]);
            if (in_array($value[0] != null?$value[0]:"", $restricted)) {
                unset($menu[key($menu)]);
            }
        }
    } // __('Posts'),
    add_action('admin_menu', 'remove_menus');











    /* Login - Change log in screen logo */
    // function login_logo()
    // {
    //     echo '<style type="text/css">
    //             body.login {
    //                 background-color: #252525 !important;
    //                 // background-image: url('.get_stylesheet_directory_uri().'/img/skeleton.gif) !important;
    //                 background-position: 0 0 !important;
    //                 background-repeat: no-repeat !important;
    //                 background-size: cover;
    //             }
    //             #login {
    //                 padding: 5% 0 0;
    //             }
    //             .login form .input,
    //             .login form input[type="checkbox"],
    //             .login input[type="text"] {
    //                 border: 1px solid #aaa;
    //             }
    //             .login form {
    //                 background: none repeat scroll 0 0 rgba(0, 0, 0, 0.6);
    //                 border: 1px solid #888;
    //                 border-radius: 3px;
    //                 box-shadow: 0 1px 3px rgba(125, 125, 125, 0.13);
    //                 margin-top:40px;
    //             }
    //             .login label {
    //                 color: #fff;
    //             }
    //             .login #backtoblog a,
    //             .login #nav a {
    //                 color: #fff;
    //                 text-decoration: none;
    //             }
    //             .login #backtoblog a:hover,
    //             .login #nav a:hover {
    //                 color: #fff;
    //                 text-decoration: underline;
    //             }
    //             .login h1 {
    //                 width:      300px;
    //                 height:     113px;
    //                 left:       0;
    //                 position:   relative;
    //                 margin:     0 0 30px 10px;
    //             }
    //             .login h1 a {
    //                 background-size:    auto;
    //                 width:              300px;
    //                 height:             113px;
    //                 margin:             0 auto 15px;
    //             }
    //             .login h1 a {
    //                 background:url('.plugin_dir_url(__FILE__).'img/admin-logo-triskel-marine-300-113-1.png) no-repeat 0 0 transparent !important;
    //                 background-size: 100% !important;
    //             }
    //     </style>';
    // }
    function login_url()
    {
        return home_url('/');
    }
    function login_title()
    {
        return get_option('blogname');
    }
    // add_action('login_head', 'login_logo');
    add_filter('login_headerurl', 'login_url');
    add_filter('login_headertitle', 'login_title');











    // http://webcusp.com/how-to-add-custom-css-for-your-wordpress-admin-dashboard/
    function my_admin_theme_style()
    {
        wp_enqueue_style('my-admin-theme', plugins_url('/css/wp-admin.css', __FILE__));
    }
    add_action('admin_enqueue_scripts', 'my_admin_theme_style');
    add_action('login_enqueue_scripts', 'my_admin_theme_style');











    // http://www.wpbeginner.com/wp-themes/change-the-footer-in-your-wordpress-admin-panel/
    // Change the Footer in Your WordPress Admin Panel
    function remove_footer_admin()
    {
        echo 'Website by <a href="http://www.fastnetmarketing.co.uk/" target="_blank">Fast Net Marketing</a>';
    }
    add_filter('admin_footer_text', 'remove_footer_admin');











    // http://blog.interruptedreality.com/2011/wordpress-change-admin-footer/
    // WordPress: Remove/Change the Text and Version Number in the Admin Footer
    function my_footer_version()
    {
        return '';
    }
    add_filter('update_footer', 'my_footer_version', 11);











    /* Enter the full email address you want displayed */
    /* from http://miloguide.com/filter-hooks/wp_mail_from/ */
    // http://premium.wpmudev.org/blog/wordpress-email-settings/

    function send_wp_mail_from($email)
    {
        return "Email Address";
    }
    add_filter("wp_mail_from", "send_wp_mail_from");

    function send_wp_mail_from_name($email)
    {
        return "Company Name";
    }
    add_filter("wp_mail_from_name", "send_wp_mail_from_name");









    // https://www.wpfaster.org/code/how-to-remove-emoji-styles-scripts-wordpress
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); 
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' ); 
    remove_action( 'wp_print_styles', 'print_emoji_styles' ); 
    remove_action( 'admin_print_styles', 'print_emoji_styles' );




/* Stop Adding Functions Below this Line */
