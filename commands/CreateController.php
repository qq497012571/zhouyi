<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\common\helpers\ZhanbuBase;
use app\common\helpers\Meihuayishu;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CreateController extends Controller
{

    const IMG_PATH = './web/images/gua64/';

    /**
     * 创建64卦图
     * @return 
     */
    public function actionImg()
    {
        foreach (ZhanbuBase::GUA64 as $code => $name) {
            $text = ZhanbuBase::get64GuaString($name);
            self::saveImg($name, $text, 76, 12*14);
            for ($i=1; $i <= 6; $i++) { 
                $text = ZhanbuBase::get64GuaString($name, $i);
                self::saveImg($name . '-' . $i, $text, 95, 12*14);
            }
        }
        return ExitCode::OK;
    }

    public static function saveImg($name, $content, $width, $height, $size = 13)
    {
        $font_file ="C:\WINDOWS\Fonts\SIMFANG.TTF";
        $img = imagecreate($width, $height);//创建一个长为500高为16的空白图片
        imagecolorallocate($img,0xff,0xff,0xff);//设置图片背景颜色，这里背景颜色为#ffffff，也就是白色
        $black = imagecolorallocate($img,0x00,0x00,0x00);//设置字体颜色，这里为#000000，也就是黑色
        imagettftext($img, $size, 0, 10, 16, $black,  $font_file, $content);//将ttf文字写到图片中
        //输出图片，输出png使用imagepng方法，输出gif使用imagegif方法
        // print_r(DateBase::get());
        ob_start();
        imagepng($img);
        $image_data = ob_get_contents();
        $saveName = self::IMG_PATH . "/{$name}.png";
        file_put_contents($saveName, $image_data);
        ob_end_clean();
        imagedestroy($img);
        return $saveName;
    }

}
