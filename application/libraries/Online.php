<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Online
{
    protected $user;
    protected $place;
    public $loginTime;
    
    /**
     * __construct
     *
     * @author Ramas
     */
    public function __construct()
    {
        $this->config->load('online', true);
        $this->load->model('online/Online_model', 'online');
        $this->user = $this->ion_auth->user()->row();
        $this->place['class'] = $this->router->fetch_class();
        $this->place['method'] = $this->router->fetch_method();
        $this->loginTime = $this->config->item('login_time', 'online');


        $this->check();
    }

    /**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * I can't remember where I first saw this, so thank you if you are the original author. -Militis
	 *
	 * @access	public
	 * @param	$var
	 * @return	mixed
	 */
    public function __get($var)
	{
		return get_instance()->$var;
	}
    
    /**
     * check - Checks users online, and add users to online list
     *
     * @return void
     */
    public function check()
    {
        if(!empty($this->user)) {
            // If you need to check users online list in every page load, check this TRUE in config file
            if($this->config->item('check_users_on_page_load', 'online')) {
                $this->checkOnlineList();
            }

            $this->addUser();
        }
    }
    
    /**
     * checkOnlineList - Checks users online
     *
     * @return void
     */
    private function checkOnlineList()
    {
        $this->online->checkOnlineList($this->loginTime);
    }
    
    /**
     * addUser - Add user to online list
     *
     * @return void
     */
    private function addUser()
    {
        $this->online->addUser($this->user, $this->place, $this->loginTime);
    }
}
