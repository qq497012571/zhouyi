<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\common\helpers\DateBase;


class DemoController extends Controller
{
    public function actionMeihuaZhan()
    {
    	$ret = Meihuayishu::dateZhanbu();
    	return $this->render('meihua-zhan', ['gua' => $ret]);
    }

    
}
