<?php
class Posts extends CI_Controller
{

    //Create post function
    public function createPost()
    {
        $this->post_model->createPost();
        $posts['posts'] = $this->post_model->viewposts();

        //viewposts function checks posts through friends, if user has no friends, just viewownposts
        if ($posts['posts'] == NULL) {
            $posts['posts'] = $this->post_model->viewownposts();
        }
        //retrieve likes and comment counts for posts
        $posts['likes'] = $this->post_model->getLikes($posts);
        $posts['liked'] = $this->post_model->Liked($posts);
        $posts['comments'] = $this->comment_model->getCommentCount($posts);

        //View home page
        $this->load->view('templates/header');
        $this->load->view('pages/home', $posts);
        $this->load->view('templates/footer');
    }
    //Like post function
    public function like2()
    {
        $id = $this->input->post('id');

        //CSRF attached in array to prevent cross site forgery errors.
        $posts2['post'] = array(
            'post_id' => $id,
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        //like post
        $this->post_model->likePost($id);

        //Get likes
        $posts['likes'] = $this->post_model->getLikes2($posts2);

        $like = $posts['likes'][0]['Likes'];
        $id = $posts['likes'][0]['Post_id'];

        //Echo results (first row of array)
        echo json_encode(array($like, $id));
    }

    //Get likes function
    public function getLikes($post)
    {
        $posts['likes'] = $this->post_model->getLikes($post);

        $like = $posts['likes'][0]['Likes'];
        $id = $posts['likes'][0]['Post_id'];
        echo json_encode(array($like, $id));
    }

    //Delete post function
    public function deletePost($id)
    {
        $this->post_model->deletePost($id);
        redirect('Home');
    }
}
