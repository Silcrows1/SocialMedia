<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$autoload['packages'] = array();

$autoload['libraries'] = array('session', 'form_validation', 'database');

$autoload['drivers'] = array();

$autoload['helper'] = array('url', 'form', 'email', 'array');

$autoload['config'] = array();

$autoload['language'] = array();

$autoload['model'] = array('post_model', 'user_model', 'comment_model', 'message_model', 'admin_model');
