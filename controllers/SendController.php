<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SendController extends Controller
{
    public function actionIndex()
    {
        $model = new \app\models\PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Поиск пользователя по введенному email
            $user = \app\models\User::findByEmail($model->email);

            if (!$user) {
                throw new NotFoundHttpException('Пользователь с таким email не найден.');
            }

            // Генерация временного токена подтверждения email и его сохранение
            $token = $user->generateEmailVerificationToken();

            var_dump($token);


            // Отправка письма с кодом подтверждения
            $this->sendVerificationEmail($user, $token);

            Yii::$app->session->setFlash('success', 'Код подтверждения отправлен на ваш email.');
            Yii::$app->session->set('emailUser', $model->email);

            return $this->refresh();
        }


        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionSend()
    {
        return $this->redirect(['email/index']);
    }

    protected function sendVerificationEmail($user, $token)
    {
        return Yii::$app->mailer
        ->compose('verificationEmail', ['user' => $user, 'token' => $token])
        ->setFrom('mathformul@gmail.com')
        ->setTo($user->email)
        ->setSubject('Подтверждение email')
        ->send();
    }
}