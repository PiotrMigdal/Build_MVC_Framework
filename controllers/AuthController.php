<?php

namespace app\controllers;

use app\core\Request;
use app\models\RegisterModel;

class AuthController extends Controller
{
    public function login()
    {
        return $this->render('login');
    }

    public function register(Request $request)
    {
        $registerModel = new RegisterModel();
        if($request->isPost()) {
            $registerModel->loadData($request->getBody());

            // Register is dump for now, n
            if($registerModel->validate() && $registerModel->register()) {
                return 'Success';
            }
            // this will return errors, it can be used in php or JS
            var_dump($registerModel->errors);
            return $this->render('register', [
                'model' => $registerModel
            ]);
        }
        return $this->render('register', [
            'model' => $registerModel
        ]);
    }
}