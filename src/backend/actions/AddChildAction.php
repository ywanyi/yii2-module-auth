<?php

namespace ywanyi\auth\backend\actions;

class AddChildAction extends \yii\base\Action
{
    public $view = '@ywanyi\auth\backend\views\item\add-child';

    public function run()
    {
        $name = \Yii::$app->request->getQueryParam('name');

        return $this->controller->render($this->view);
    }
}
