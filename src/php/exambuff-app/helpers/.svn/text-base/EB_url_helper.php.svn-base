<?php 
function app_base() {
	$CI =& get_instance();
	return $CI->config->item('app_base');
}
function site_url($uri = '', $ssl = FALSE)
    {
        $CI =& get_instance();
        return $CI->config->site_url($uri, $ssl);
    }
function anchor($uri = '', $title = '', $attributes = '', $ssl = FALSE)
    {
        $title = (string) $title;

        if ( ! is_array($uri))
        {
            if ($ssl)
            {
                $site_url = ( ! preg_match('!^\w+://!i', $uri)) ? site_url($uri, TRUE) : $uri;
            }
            else
            {
                $site_url = ( ! preg_match('!^\w+://!i', $uri)) ? site_url($uri) : $uri;
            }
        }
        else
        {
            if ($ssl)
            {
                $site_url = site_url($uri, TRUE);
            }
            else
            {
                $site_url = site_url($uri);
            }

        }

        if ($title == '')
        {
            $title = $site_url;
        }

        if ($attributes == '')
        {
            $attributes = ' title="'.$title.'"';
        }
        else
        {
            $attributes = _parse_attributes($attributes);
        }
        return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
    }
function prep_url($str = '', $ssl = FALSE)
    {
        if ($str == 'http://' OR $str == '')
        {
            return '';
        }

        if (substr($str, 0, 7) != 'http://' && substr($str, 0, 8) != 'https://')
        {
            if ($ssl)
            {
                $str = 'https://'.$str;
            }
            else
            {
                $str = 'http://'.$str;
            }
        }

        return $str;
    }
function redirect($uri = '', $method = 'location', $ssl = FALSE)
    {
        switch($method)
        {
            case 'refresh':
                header("Refresh:0;url=".site_url($uri, $ssl));
                break;
            default:
                header("Location: ".site_url($uri, $ssl));
                break;
        }
        exit;
    }
function base_url_ssl()
    {
        $CI =& get_instance();
        return $CI->config->slash_item('base_url_ssl');
    } 
