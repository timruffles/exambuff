<?php
class EB_Config extends CI_Config {

    private $is_ssl = null;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct();
        //2008-04-21 KUNIHARU Tsujioka
        $this->_is_ssl();
    }

    // --------------------------------------------------------------------

    /**
     * Site URL
     *
     * @access  public
     * @param   string  the URI string
     * @param   bool SSL true/false 2008-04-21 KUNIHARU Tsujioka updated
     * @return  string
     */
    public function site_url($uri = '', $ssl = FALSE)
    {
        if (is_array($uri))
        {
            $uri = implode('/', $uri);
        }

        if ($uri == '')
        {
            if ($ssl)
            {
                return $this->slash_item('base_url_ssl').$this->item('index_page');
            }
            else
            {
                return $this->slash_item('base_url').$this->item('index_page');
            }
        }
        else
        {
            $suffix = ($this->item('url_suffix') == FALSE) ? '' : $this->item('url_suffix');
            if ($ssl)
            {
                return $this->slash_item('base_url_ssl').$this->slash_item('index_page').preg_replace("|^/*(.+?)/*$|", "\\1", $uri).$suffix;
            }
            else
            {
                return $this->slash_item('base_url').$this->slash_item('index_page').preg_replace("|^/*(.+?)/*$|", "\\1", $uri).$suffix;
            }
        }
    }

    //2008-04-21 KUNIHARU Tsujioka update
    /**
     * check is ssl
      * @access plivate
     *
     * @return bool
     *
     */
    private function _is_ssl()
    {
        static $is_ssl;
        if (!isset($is_ssl)) {
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $is_ssl = true;
            } else {
                $is_ssl = false;
            }
        }
        $this->is_ssl = $is_ssl;
    }

    public function is_ssl()
    {
        return $this->is_ssl;
    }

} 