<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
   
   public function is_unique($str, $field) {

        $field = explode('.', $field);

        if(isset($field[2]) === TRUE && isset($field[3]) === TRUE) {
            $this->CI->db->where($field[2] . ' != ', $field[3]);
        }
        $query = $this->CI->db->limit(1)->get_where($field[0], array($field[1] => $str));

        return $query->num_rows() === 0;
    }
  
}
// END MY Form Validation Class

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */ 