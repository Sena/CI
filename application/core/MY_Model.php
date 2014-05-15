<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $table = NULL;
    protected $alias = NULL;

    function __construct() {
        parent::__construct();
    }
    private function getTable()
    {
        if($this->table === NULL) {
            $this->table = get_called_class();
            $this->table = explode('_', $this->table);
            $this->table = current($this->table);
            $this->table = strtolower($this->table);
        }
        return $this->table;
    }
    public function get(array $where = array())
    {
        if($this->alias == NULL) {
            $this->alias = $this->getTable();
        }
        if(count($where) !== 0) {
            foreach ($where as $key => $value) {
                if(is_array($value)) {
                    $this->db->where_in($this->alias . '.' . $key, $value);
                }else{
                    $this->db->where($this->alias . '.' . $key, $value);
                }
            }
        }
        return $this->db->get($this->getTable() . ' AS ' . $this->alias);
    }
    public function insert(array $data, $insert_id = FALSE) {
        $this->db->insert($this->getTable(), $data);
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
        $this->db->update($this->getTable(), $data);
    }
    public function delete(array $where) {
        $this->db->delete($this->getTable(), $where);
        $data = $this->get($where)->result();
        return count($data) === 0; 
    }
}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */