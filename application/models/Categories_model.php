<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 29/03/17
 * Time: 17:49
 */
class Categories_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_categories($slug = FALSE)
    {
        if ($slug === FALSE)
        {
            $query = $this->db->get('categories');
            return $query->result_array();
        }

        $query = $this->db->get_where('categories', array('slug' => $slug));
        return $query->row_array();
    }

    public function get_categories_by_id($id = 0)
    {
        if ($id === 0)
        {
            $query = $this->db->get('categories');
            return $query->result_array();
        }

        $query = $this->db->get_where('categories', array('id' => $id));
        return $query->row_array();
    }

    public function set_categories($id = 0)
    {
        $this->load->helper('url');

        $slug = url_title($this->input->post('category'), 'dash', TRUE);

        $data = array(
            'category' => $this->input->post('category'),
            'slug' => $slug,
        );

        if ($id == 0) {
            return $this->db->insert('categories', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('categories', $data);
        }
    }

    public function delete_categories($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('categories');
    }
}