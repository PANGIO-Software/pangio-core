<?php
namespace App\Controllers;

use Pangio\Core\Infrastructure\Logger;
use Pangio\Core\Application\View;
use Pangio\Core\System\Session;
use Pangio\Core\System\Config;
use Pangio\Core\Http\Response;
use Pangio\Core\Http\Request;

class Base {
    protected Response $response;
    protected Session $session;
    protected Request $request;
    protected Config $config;
    protected Logger $logger;
    protected View $view;

    public function __construct() {
        $this->response = new Response();
        $this->session = new Session();
        $this->request = new Request();
        $this->config = new Config();
        $this->logger = new Logger();
        $this->view = new View();
    }
}