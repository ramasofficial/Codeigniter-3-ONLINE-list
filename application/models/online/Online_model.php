<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Online_model extends CI_Model
{    
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
        $this->table = 'ionauth_online'; // Enter table name ex.: online_register
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
}
