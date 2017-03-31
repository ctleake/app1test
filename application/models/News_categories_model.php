<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 29/03/17
 * Time: 17:49
 */
class News_categories_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function link_news_to_category($news_id = 0, $categories_id = 0)
    {
        if ($news_id == 0 || $categories_id == 0)
        {
            $query = $this->db->get('categories');
            return $query->result_array();
        }

        $data = array(
            'news_id' => $news_id,
            'categories_id' => $categories_id,
        );

        $query = $this->db->get_where('news_categories', array('news_id' => $news_id, 'categories_id' => $categories_id));
        $result = $query->result_array();

        if (empty($result)) {
            return $this->db->insert('news_categories', $data);
        } /* else {
            $this->db->where('id', $id);
            return $this->db->update('news_categories', $data);
        }
        */
    }

    public function delete_news($id)
    {
        $this->db->where('news_id', $id);
        return $this->db->delete('news_categories');
    }

    public function delete_categories($id)
    {
        $this->db->where('categories_id', $id);
        return $this->db->delete('news_categories');
    }

}