<?php

namespace frontend\controllers;


use common\models\LoginForm;
use common\models\User;
use frontend\models\SignupForm;
use Yii;
use yii\rest\ActiveController;

/**
 * Authentication controller
 */
class AuthenticationController extends ActiveController
{
    public $modelClass = User::class;


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $params = Yii::$app->request->post();
        $model->name = $params['name'];
        $model->email = $params['email'];
        $model->password = $params['password'];
        if ($model->signup()) {
            $response = [
                'code' => 200,
                'status' => 'Success',
                'message' => 'Thank you for registration.',
                'data' => User::findByEmail($model->email)
            ];

            return $response;
        } else {
            $response = [
                'hasErrors' => $model->hasErrors(),
                'errors' => $model->getErrors()
            ];
            return $response;
        }
    }
    /**
     * Login user .
     *
     * @return mixed
     */

    public function actionLogin()
    {

        $model = new LoginForm();
        $params = Yii::$app->request->post();
        $model->email = $params['email'];
        $model->password = $params['password'];
        if ($model->login()) {
            $response = [
                'status' => 'success',
                'message' => 'User successfully login',
                'data' => User::findByEmail($model->email)
            ];
            return $response;
        } else {
            $response = [
                'status' => 'failed',
                'message' => 'Wrong email or password',
            ];

            return $response;
        }
    }
}
