<?php

    /**
     * Get information about the blog.
     * 
     * Calls the built-in WP function get_bloginfo() with all possible arguments to return a populated structure.
     * 
     * @return stdClass Returns a class with properties matching the get_bloginfo() parameter names.
     */
    function get_blog_info() {
        $info = new stdClass();
    
        $info->name                 = get_bloginfo("name");
        $info->description          = get_bloginfo("description");
        $info->wpurl                = get_bloginfo("wpurl");
        $info->url                  = get_bloginfo("url");
        $info->admin_email          = get_bloginfo("admin_email");
        $info->charset              = get_bloginfo("charset");
        $info->version              = get_bloginfo("version");
        $info->html_type            = get_bloginfo("html_type");
        $info->text_direction       = get_bloginfo("text_direction");
        $info->language             = get_bloginfo("language");
        $info->stylesheet_url       = get_bloginfo("stylesheet_url");
        $info->stylesheet_directory = get_bloginfo("stylesheet_directory");
        $info->template_url         = get_bloginfo("template_url");
        $info->template_directory   = get_bloginfo("template_url");
        $info->pingback_url         = get_bloginfo("pingback_url");
        $info->atom_url             = get_bloginfo("atom_url");
        $info->rdf_url              = get_bloginfo("rdf_url");
        $info->rss_url              = get_bloginfo("rss_url");
        $info->rss2_url             = get_bloginfo("rss2_url");
        $info->comments_atom_url    = get_bloginfo("comments_atom_url");
        $info->comments_rss2_url    = get_bloginfo("comments_rss2_url");
        $info->siteurl              = home_url();
        $info->siteicon             = get_site_icon_url();
    
        return $info;
    }

?>