<?php
namespace app\controllers;

use app\core\Application;
use app\core\Request;

class ContactController extends Controller
{
    public function home()
    {
        $params = [
            'name' => 'Piotr'
        ];
        return $this->render('home', $params);
    }
    public function show()
    {
        return $this->render('contact');
    }
    public function create(Request $request)
    {
        $body = $request->getBody();
        return 'Subject: ' . $body['subject'] . '<br> Email: ' . $body['email'] . '<br> Body: ' . $body['body'];
    }

}