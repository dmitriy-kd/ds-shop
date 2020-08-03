<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class TestController extends Controller
{
    /**

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $x = "1,2,3,";
        $x = substr($x, 0, strlen($x) - 1);
        echo $x;die;
        return $this->render('index');
    }

}