<?php

namespace frontend\controllers;

use common\models\Session;
use common\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

/**
 * Session controller
 */
class SessionController extends ActiveController
{
    public $modelClass = Session::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function ($email, $password) {
                $user = User::findByEmail($email);
                if (!is_null($user)) {
                    if ($user->validatePassword($password)) {
                        return $user;
                    }
                }
                return null;
            },
            'only' => ['create', 'update', 'delete']
        ];
        return $behaviors;
    }
}
