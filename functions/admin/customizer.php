<?php

    /**
     * This file contains functionality specific to WP_ADMIN.
     * 
     * We create our own page on WP_ADMIN to manage settings and options.
     * 
     */

    function kitok2_register_wpadmin_page() {
        add_menu_page( 
            'KiTok 2.0', 
            'KiTok 2.0', 
            'manage_options', 
            'kitok2-options', 
            'create_admin_page', 
            'dashicons-admin-generic', 
            (is_network_admin() ? 26 : 81)
        );
    }
    add_action("admin_menu", "kitok2_register_wpadmin_page");


    function kitok2_render_wpadmin_page() {
        add_settings_section( 'kitok2_settings', 'Html generation options', 'kitok2_render_wpadmin_htmlgen', 'kitok2_settings_section_html' );
        add_settings_section( 'kitok2_settings', 'Post types', 'kitok2_render_wpadmin_post_types', 'kitok2_settings_section_post_types' );

        add_settings_field( 'kitok2_enable_auto_menus', null, null, 'kitok2_settings_section_html', 'kitok2_settings' );
        add_settings_field( 'kitok2_enable_handle_native_post_type', null, null, 'kitok2_settings_section_html', 'kitok2_settings' );
        add_settings_field( 'kitok2_enable_render_ogtags', null, null, 'kitok2_settings_section_html', 'kitok2_settings' );

        add_settings_field( 'kitok2_enable_post_type_book', null, null, 'kitok2_settings_section_post_types', 'kitok2_settings' );
        add_settings_field( 'kitok2_enable_post_type_podcast', null, null, 'kitok2_settings_section_post_types', 'kitok2_settings' );
        add_settings_field( 'kitok2_enable_post_type_video', null, null, 'kitok2_settings_section_post_types', 'kitok2_settings' );

        register_setting('kitok2_settings', 'kitok2_enable_auto_menus', array( 'default' => true ));
        register_setting('kitok2_settings', 'kitok2_enable_handle_native_post_type', array( 'default' => true ));
        register_setting('kitok2_settings', 'kitok2_enable_render_ogtags', array( 'default' => true ));

        register_setting('kitok2_settings', 'kitok2_enable_post_type_book_enable', array( 'default' => true ) );
        register_setting('kitok2_settings', 'kitok2_enable_post_type_book_name', array( 'default' => 'Chaptered Post' ) );
        register_setting('kitok2_settings', 'kitok2_enable_post_type_book_slug', array( 'default' => 'book' ) );
        
        register_setting('kitok2_settings', 'kitok2_enable_post_type_podcast_enable', array( 'default' => true ) );
        register_setting('kitok2_settings', 'kitok2_enable_post_type_podcast_name', array( 'default' => 'Audio Post' ) );
        register_setting('kitok2_settings', 'kitok2_enable_post_type_podcast_slug', array( 'default' => 'podcast' ) );
        
        register_setting('kitok2_settings', 'kitok2_enable_post_type_video_enable', array( 'default' => true ) );
        register_setting('kitok2_settings', 'kitok2_enable_post_type_video_name', array( 'default' => 'Video Post' ) );
        register_setting('kitok2_settings', 'kitok2_enable_post_type_video_slug', array( 'default' => 'video' ) );

    }
    add_action( 'admin_init', 'kitok2_render_wpadmin_page' );


    function kitok2_render_wpadmin_post_types() {
?>
<table class="table w-100">
    <thead>
        <tr>
            <th>Post type</th>
            <th>Enable post type?</th>
            <th>Display label name</th>
            <th>URL slug</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Chaptered post</td>
            <td>
                <input type="checkbox" name="kitok2_enable_post_type_book_enable" id="kitok2_enable_post_type_book_enable" style="margin-top: 2px !important; margin-right: 15px !important;" value="1" <?php checked(1, get_option('kitok2_enable_post_type_book_enable'), true); ?> />           
                <br /><i class="small">DEFAULT: yes</i>
            </td>
            <td>
                <input type="text" name="kitok2_enable_post_type_book_name" id="kitok2_enable_post_type_book_name" value="<?php echo get_option('kitok2_enable_post_type_book_name'); ?>" />
                <br /><i class="small">DEFAULT: &quot;Chaptered Post&quot;</i>
            </td>
            <td>
                <input type="text" name="kitok2_enable_post_type_book_slug" id="kitok2_enable_post_type_book_slug" value="<?php echo get_option('kitok2_enable_post_type_book_slug'); ?>" />
                <br /><i class="small">DEFAULT: &quot;book&quot;</i>
            </td>
        <tr>
        <tr>
            <td>Audio</td>
            <td>
                <input type="checkbox" name="kitok2_enable_post_type_podcast_enable" id="kitok2_enable_post_type_podcast_enable" style="margin-top: 2px !important; margin-right: 15px !important;" value="1" <?php checked(1, get_option('kitok2_enable_post_type_podcast_enable'), true); ?> />    
                <br /><i class="small">DEFAULT: yes</i>
            </td>
            <td>
                <input type="text" name="kitok2_enable_post_type_podcast_name" id="kitok2_enable_post_type_podcast_name" value="<?php echo get_option('kitok2_enable_post_type_podcast_name'); ?>" />
                <br /><i class="small">DEFAULT: &quot;Audio Post&quot;</i>
            </td>
            <td>
                <input type="text" name="kitok2_enable_post_type_podcast_slug" id="kitok2_enable_post_type_podcast_slug" value="<?php echo get_option('kitok2_enable_post_type_podcast_slug'); ?>" />
                <br /><i class="small">DEFAULT: &quot;podcast&quot;</i>
            </td>
        <tr>
        <tr>
            <td>Video</td>
            <td>
                <input type="checkbox" name="kitok2_enable_post_type_video_enable" id="kitok2_enable_post_type_video_enable" style="margin-top: 2px !important; margin-right: 15px !important;" value="1" <?php checked(1, get_option('kitok2_enable_post_type_video_enable'), true); ?> />             
                <br /><i class="small">DEFAULT: yes</i>
            </td>
            <td>
                <input type="text" name="kitok2_enable_post_type_video_name" id="kitok2_enable_post_type_video_name" value="<?php echo get_option('kitok2_enable_post_type_video_name'); ?>" />
                <br /><i class="small">DEFAULT: &quot;Video Post&quot;</i>
            </td>
            <td>
                <input type="text" name="kitok2_enable_post_type_video_slug" id="kitok2_enable_post_type_video_slug" value="<?php echo get_option('kitok2_enable_post_type_video_slug'); ?>" />
                <br /><i class="small">DEFAULT: &quot;video&quot;</i>
            </td>
        <tr>
    </tbody>
</table>
<?php
    }

    function kitok2_render_wpadmin_htmlgen() {
?>
<table class="table w-100">
    <thead>
    </thead>
    <tbody>
        <tr>
            <td class="border-0">
                <input type="checkbox" name="kitok2_enable_auto_menus" id="kitok2_enable_auto_menus" style="margin-top: 2px !important; margin-right: 15px !important;" value="1" <?php checked(1, get_option('kitok2_enable_auto_menus'), true); ?> />
            </td>
            <td class="border-0">
                <label for="kitok2_enable_auto_menus">Generate menus for KiTok 2 post types (Chaptered Posts, Podcasts and Videos).</label>
                <br/>
                <span class="dashicons dashicons-editor-help"></span>
                <i style="font-size: smaller;">
                    When enabled, KiTok will automatically generate top-level navigation menus for KiTok post types. These post types are: Chaptered Posts, Podcasts and Videos -- that you will find in the below &quot;Post types&quot; 
                    section. If you disable this option, then only the menus you define under <strong>Appearance &gt; Menus</strong> will appear, exactly, on the public website.
                </i>
            </td>
        </tr>
        <tr>
            <td class="border-0">
                <input type="checkbox" name="kitok2_enable_handle_native_post_type" id="kitok2_enable_handle_native_post_type" style="margin-top: 2px !important; margin-right: 15px !important;" value="1" <?php checked(1, get_option('kitok2_enable_handle_native_post_type'), true); ?> />
            </td>
            <td class="border-0">
                <label for="kitok2_enable_handle_native_post_type">Handle layout for WordPress's built in 'Post' type content.</label>
                <br/>
                <span class="dashicons dashicons-editor-help"></span>
                <i style="font-size: smaller;">
                    When enabled, KiTok will handle WordPress's built in &quot;Post&quot; post-type. This is the default way to write your blogs and content on WordPress. If you create posts under this type and this option is 
                    enabled, you will see your posts using the regular permalink structure. However, if you have DISABLED this option, such content will no longer be displayed -- in fact, KiTok will forcefully return HTTP 404 
                    (Not found) errors when you attempt to access such content..
                </i>
            </td>
        </tr>
        <tr>
            <td class="border-0">
                <input type="checkbox" name="kitok2_enable_render_ogtags" id="kitok2_enable_render_ogtags" style="margin-top: 2px !important; margin-right: 15px !important;" value="1" <?php checked(1, get_option('kitok2_enable_render_ogtags'), true); ?> />
            </td>
            <td class="border-0">
                <label for="kitok2_enable_render_ogtags">Enable to render page and view specific &quot;<strong>og:</strong>&quot; meta tags.</label>
                <br/>
                <span class="dashicons dashicons-editor-help"></span>
                <i style="font-size: smaller;">
                    Social media sites and apps (Facebook, Twitter, WhatsApp, Telegram and more...) using &quot;Open Graph API&quot; to detect and display content that you &quot;share&quot; from other websites, blogs, etc. You 
                    must have seen the little &quot;card&quot; style stuff with a picture, headline, etc, when you share your Facebook post or YouTube video. <strong>og:</strong> tags are an integral part of this experience. If you 
                    plan to allow your visitors (or yourself want to) share your content from this website to such social media, you should <strong>ENABLE</strong> this option to add the relevant HTTP META tags to your site 
                    and pages. KiTok will automatically add the correct <strong>og:</strong> tags for every page.
                </i>
            </td>
        </tr>
    </tbody>
</table>
<?php
    }


    function create_admin_page() {
?>
<div class="wrap">
    <h1>KiTok 2.0 settings</h1>
    <p>
        Settings for the KiTok 2.0 theme. If you have trouble understanding or using these options, please write to <code style="color: blue">sujay@sarma.in</code> and I will be happy to help you. This theme is not 
        available on the official WordPress Theme Store. To download this theme or get updates, please visit my website at: <a href="https://sujayvsarma.com/wordpress" target="_blank">https://sujayvsarma.com/wordpress</a>. 
        The theme is available 100% free of cost, along with personal support from me for installing, configuring, customizing and using the theme. You may also write in your feedback and provide feature requests 
        at the same e-mail address.
    </p>
    <hr />

    <form method="post" action="options.php">
<?php
        settings_fields( 'kitok2_settings' );
        do_settings_sections( 'kitok2_settings_section_html' );
        do_settings_sections( 'kitok2_settings_section_post_types' );
        submit_button( 'Save theme options' );
        
?>
    </form>
</div>
<style type="text/css">
    h2 {
        font-size: 20px;
    }

    th, td {
        font-size: 14px;
    }


</style>
<?php
    }

?>