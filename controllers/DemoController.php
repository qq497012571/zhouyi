<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\common\helpers\DateBase;
use app\common\helpers\Meihuayishu;


class DemoController extends Controller
{
    public function actionMeihuaZhan()
    {
    	$ret = Meihuayishu::dateZhanbu();
    	return $this->render('meihua-zhan', ['gua' => $ret]);
    }

    
}
