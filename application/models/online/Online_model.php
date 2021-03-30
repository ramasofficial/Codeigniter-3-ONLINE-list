<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Online_model extends CI_Model
{        
    /**
     * db - DB variable
     *
     * @var object
     */
    private $db;
    
    /**
     * table - Online table
     *
     * @var string
     */
    private $table;
    
    /**
     * tableMaxOnline - Max online table
     *
     * @var string
     */
    private $tableMaxOnline;
    
    /**
     * trackMaxOnline - Enable or disable max online tracking from config file
     *
     * @var bool
     */
    private $trackMaxOnline;

    /**
     * __construct
     *
     * @author Ramas
     */
    public function __construct()
    {
        parent::__construct();

        // Load databases
        $this->db = $this->load->database('default', true);
        $this->table = 'ionauth_online';
        $this->tableMaxOnline = 'ionauth_online_max';
        $this->trackMaxOnline = $this->config->item('track_max_online', 'online');
    }
    
    /**
     * checkOnlineList - Checks online list and deleting not active users
     *
     * @param  int $loginTime
     * @return bool
     */
    public function checkOnlineList($loginTime)
    {
        $dateNow = date('Y-m-d H:i:s');
        $query = $this->db->select('id, username')->where('time <=', $dateNow)->get($this->table)->result_array();

        if($this->trackMaxOnline) {
            $this->trackMaxOnline();
        }

        $deleteUsers = [];
        if(!empty($query)) {
            foreach($query as $value) {
                $deleteUsers[] = $value['id'];
            }

            $this->db->where_in('id', $deleteUsers);
            $this->db->delete($this->table);
        }

        return true;
    }
    
    /**
     * addUser - Add users to online list
     *
     * @param  object $user
     * @param  array $place
     * @param  int $addTime
     * @return bool
     */
    public function addUser($user, $place, $addTime)
    {
        $query = $this->db->select('id')->where('user_id', $user->user_id)->get($this->table);

        $newTime = date('Y-m-d H:i:s', strtotime('+'.$addTime.' sec'));

        $data = [
            'user_id' => $user->user_id,
            'username' => $user->username,
            'classname' => $place['class'],
            'method' => $place['method'],
            'time' => $newTime,
        ];

        if($query->num_rows() <= 0) {

            $this->db->insert($this->table, $data);

        } else {

            $row = $query->row_array();
            $this->db->where('id', $row['id']);
            $this->db->update($this->table, $data);

        }

        return true;
    }
    
    /**
     * getOnlineCount - Shows users which in this moment are online
     *
     * @return int
     */
    public function getOnlineCount()
    {
        $query = $this->db->select('COUNT(id) as number')->get($this->table)->row_array();
        return $query['number'];
    }
    
    /**
     * trackMaxOnline - This function tracking users max online every day
     *
     * @return bool
     */
    private function trackMaxOnline()
    {
        $onlineNow = $this->getOnlineCount();

        $today = date('Y-m-d');

        $query = $this->db->select('id, max_online')->where('date', $today)->get($this->tableMaxOnline);

        $data = [
            'date' => $today,
            'max_online' => $onlineNow,
        ];

        if($query->num_rows() <= 0) {
            $this->db->insert($this->tableMaxOnline, $data);
        } else {
            $row = $query->row_array();

            if($row['max_online'] < $onlineNow) {
                $this->db->where('id', $row['id']);
                $this->db->update($this->tableMaxOnline, $data);
            }
        }

        return true;
    }
    
    /**
     * getMaxOnline - This function returns today max online users
     *
     * @return int
     */
    public function getMaxOnline()
    {
        $query = $this->db->select('max_online')->where('date', date('Y-m-d'))->get($this->tableMaxOnline)->row_array();

        if(empty($query)) {
            return false;
        }

        return $query['max_online'];
    }
}
