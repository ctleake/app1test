<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 29/03/17
 * Time: 17:45
 */
class News extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');
        $this->load->helper('url_helper');
    }

    public function index()
    {
        $data['news'] = $this->news_model->get_news();
        $data['title'] = 'News archive';

        $this->load->view('templates/header', $data);
        $this->load->view('news/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($slug = NULL)
    {
        $data['news_item'] = $this->news_model->get_news($slug);

        if (empty($data['news_item']))
        {
            show_404();
        }

        $data['title'] = $data['news_item']['title'];

        $data['categories'] = $this->get_categories_of_news($slug);

        $this->load->view('templates/header', $data);
        $this->load->view('news/view', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Create a news item';

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('news/create');
            $this->load->view('templates/footer');

        }
        else
        {
            $this->news_model->set_news();
            $this->load->view('templates/header', $data);
            $this->load->view('news/success');
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

        $data['title'] = 'Edit a news item';
        $data['news_item'] = $this->news_model->get_news_by_id($id);

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('news/edit', $data);
            $this->load->view('templates/footer');

        }
        else
        {
            $this->news_model->set_news($id);
            //$this->load->view('news/success');
            redirect( base_url() . 'index.php/news');
        }
    }

    public function delete()
    {
        $id = $this->uri->segment(3);

        if (empty($id))
        {
            show_404();
        }

        $news_item = $this->news_model->get_news_by_id($id);

        $this->news_model->delete_news($id);

        $this->load->model('news_categories_model');
        $this->news_categories_model->delete_news($id);

        redirect( base_url() . 'index.php/news');
    }

    public function categorize()
    {
        $id = $this->uri->segment(3);

        if (empty($id))
        {
            show_404();
        }

        $data['news'] = $this->news_model->get_news_by_id($id);

        if (empty($data['news']))
        {
            show_404();
        }

        $this->load->model('categories_model');

        $data['categories'] = $this->categories_model->get_categories();
        $data['title'] = 'Select a Category for News item: ' . $data['news']['title'];

        $this->load->view('templates/header', $data);
        $this->load->view('news/categorize', $data);
        $this->load->view('templates/footer');

    }

    public function add_news_to_category()
    {
        $news_id = $this->uri->segment(3);

        if (empty($news_id))
        {
            show_404();
        }

        $categories_id = $this->uri->segment(4);

        if (empty($categories_id))
        {
            show_404();
        }

        $this->load->model('news_categories_model');

        $this->load->model('news_categories_model');
        $result = $this->news_categories_model->link_news_to_category($news_id, $categories_id);

        $this->load->model('categories_model');

        $data['news'] = $this->news_model->get_news_by_id($news_id);
        $data['categories'] = $this->categories_model->get_categories_by_id($categories_id);

        $this->load->view('templates/header');

        if ($result)
        {
            $this->load->view('news/link_success', $data);
        }
        else
        {
            $this->load->view('news/link_failure', $data);
        }
        $this->load->view('templates/footer');

    }

    public function get_categories_of_news($slug = FALSE)
    {
        $this->load->model('categories_model');
        $this->load->model('news_model');

        $this->db->select('*');
        $this->db->from('categories');
        $this->db->join('news_categories', 'categories.id = news_categories.categories_id');
        $this->db->join('news', 'news.id = news_categories.news_id');
        $this->db->where(array('news.slug' => $slug));

        $query = $this->db->get();
        $sql = $this->db->last_query();

        $categories = array();
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $categories[] = array(
                    'categories_id' => $row->categories_id,
                    'category' => $row->category,
                );
            }
        }

        return $categories;
    }
}
