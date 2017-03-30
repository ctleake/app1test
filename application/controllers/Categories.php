<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 29/03/17
 * Time: 17:45
 */
class Categories extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('categories_model');
        $this->load->helper('url_helper');
    }

    public function index()
    {
        $data['categories'] = $this->categories_model->get_categories();
        $data['title'] = 'Category archive';

        $this->load->view('templates/header', $data);
        $this->load->view('categories/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($slug = NULL)
    {
        $data['categories_item'] = $this->categories_model->get_categories($slug);

        if (empty($data['categories_item']))
        {
            show_404();
        }

        $data['title'] = $data['categories_item']['category'];

        $data['news_items'] = $this->get_news_in_category($slug);

        $this->load->view('templates/header', $data);
        $this->load->view('categories/view', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Create a categories item';

        $this->form_validation->set_rules('category', 'Category', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('categories/create');
            $this->load->view('templates/footer');

        }
        else
        {
            $this->categories_model->set_categories();
            $this->load->view('templates/header', $data);
            $this->load->view('categories/success');
            $this->load->view('templates/footer');
        }
    }

    public function edit()
    {
        $id = $this->uri->segment(3);

        if (empty($id))
        {
            show_404();
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Edit a categories item';
        $data['categories_item'] = $this->categories_model->get_categories_by_id($id);

        $this->form_validation->set_rules('category', 'Category', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('categories/edit', $data);
            $this->load->view('templates/footer');

        }
        else
        {
            $this->categories_model->set_categories($id);
            //$this->load->view('categories/success');
            redirect( base_url() . 'index.php/categories');
        }
    }

    public function delete()
    {
        $id = $this->uri->segment(3);

        if (empty($id))
        {
            show_404();
        }

        $categories_item = $this->categories_model->get_categories_by_id($id);

        $this->categories_model->delete_categories($id);
        redirect( base_url() . 'index.php/categories');
    }

    public function get_news_in_category($slug = FALSE)
    {
        $this->load->model('categories_model');
        $this->load->model('news_model');

        $this->db->select('*');
        $this->db->from('news');
        $this->db->join('news_categories', 'news.id = news_categories.news_id');
        $this->db->join('categories', 'categories.id = news_categories.categories_id');
        $this->db->where(array('categories.slug' => $slug));

        $query = $this->db->get();
        $sql = $this->db->last_query();

        $news_items = array();
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $news_items[] = array(
                    'news_id' => $row->news_id,
                    'title' => $row->title,
                    'text' => $row->text
                );
            }
        }

        return $news_items;
    }

}
