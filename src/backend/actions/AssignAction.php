<?php

namespace ywanyi\auth\backend\actions;

class AssignAction extends \yii\base\Action
{
    public $view = '@ywanyi\auth\backend\views\item\assign';

    public function run()
    {
        $name = \Yii::$app->request->getQueryParam('name');

        return $this->controller->render($this->view);
    }
}
