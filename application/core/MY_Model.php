<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $table = NULL;
    protected $alias = NULL;

    function __construct() {
        parent::__construct();
        
        if($this->alias == NULL) {
            $this->alias = $this->table;
        }
    }
    public function get(array $where = array())
    {
        if(count($where) !== 0) {
            foreach ($where as $key => $value) {
                if(is_array($value)) {
                    $this->db->where_in($this->alias . '.' . $key, $value);
                }else{
                    $this->db->where($this->alias . '.' . $key, $value);
                }
            }
        }
        return $this->db->get($this->table . ' AS ' . $this->alias);
    }
    public function insert(array $data, $insert_id = FALSE) {
        $this->db->insert($this->table, $data);
        if($insert_id === TRUE) {
            return $this->db->insert_id();
        }
    }
    public function update(array $where, array $data) {
        if(count($where) !== 0) {
            foreach ($where as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->update($this->table, $data); 
    }
    public function delete(array $where) {
        $this->db->delete($this->table, $where);
        $data = $this->get($where)->result();
        return count($data) === 0; 
    }
}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */