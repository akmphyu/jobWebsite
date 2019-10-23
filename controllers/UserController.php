<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\User;

class UserController extends \yii\web\Controller
{
    public function actionLogin()
    {
        return $this->render('login');
    }

    public function actionRegister()
    {
        $user = new User();

    if ($user->load(Yii::$app->request->post())) {
        if ($user->validate()) {
            // form inputs are valid, do something here
            $user->save();
            yii::$app->getSession()->setFlash('success','User Registration succesful');
            return $this->redirect('index.php');
        }
    }

    return $this->render('register', [
        'user' => $user,
    ]);
    }

}
