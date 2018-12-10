<?php
namespace app\common\helpers;

use Yii;
use app\common\helpers\DateBase;

/**
 * 梅花易数
 * @author jlb
 */
class Meihuayishu
{
	/**
	 * 梅花易数-时间起卦
	 */
	public static function dateZhanbu($date = null, $hours = null)
	{
		$dates = DateBase::get($date);

		if (!$hours) {
			$hours = date('H:i');
		}

		// 获取年-地支
		// 获取月-地支
		// 获取日-地支
		$yearText = mb_substr($dates['cyclicalYear'], 1);

		$yearNum = array_search($yearText, ZhanbuBase::DIZHI);
		$monthNum = $dates['lunarMonth'];
		$dayNum = $dates['lunarDay'];

		$hoursNum = self::hoursMapDizhiNum($hours);

		// 上卦
		$up = ZhanbuBase::BAGUA[($yearNum+$monthNum+$dayNum)%8];
		// 下卦
		$down = ZhanbuBase::BAGUA[($yearNum+$monthNum+$dayNum+$hoursNum)%8];
		// 动爻
		$yao = ($yearNum+$monthNum+$dayNum+$hoursNum)%6;

		if ($yao == 0) {
			$yao == 6;
		}
		
		$upGua = ZhanbuBase::GUA[$up];
		$downGua = ZhanbuBase::GUA[$down];

		// 算出变卦
		$yaos = array_reverse(explode('|', $upGua . '|' . $downGua));

		// 主卦
		$zhuGua = $upGua . '|' . $downGua;
		$zhuGuaName = ZhanbuBase::GUA64[$zhuGua];

		// 互卦
		$huGuaCode = implode('|', [$yaos[4], $yaos[3], $yaos[2], $yaos[3], $yaos[2], $yaos[1]]);

		$yaos[$yao-1] = $yaos[$yao-1] == 0 ? '1' : '0';
		$bianGua      = implode('|', array_reverse($yaos));
		$bianGuaName  = ZhanbuBase::GUA64[$bianGua];

		return ['zhu' => $zhuGuaName, 'hu' => ZhanbuBase::GUA64[$huGuaCode], 'bian' => $bianGuaName, 'yao' => $yao];
	}

	/**
	 * 时分转成时辰
	 * @param $hours
	 */
	public static function hoursMapDizhiNum($hours = null)
	{

		$num = null;
		list($hour, $min) = explode(':', $hours);

		if (in_array($hour, ['23', '00'])) {
			$num = 1;
		}

		if (in_array($hour, ['01', '02'])) {
			$num = 2;
		}

		if (in_array($hour, ['03', '04'])) {
			$num = 3;
		}

		if (in_array($hour, ['05', '06'])) {
			$num = 4;
		}

		if (in_array($hour, ['07', '08'])) {
			$num = 5;
		}

		if (in_array($hour, ['09', '10'])) {
			$num = 6;
		}

		if (in_array($hour, ['11', '12'])) {
			$num = 7;
		}

		if (in_array($hour, ['13', '14'])) {
			$num = 8;
		}

		if (in_array($hour, ['15', '16'])) {
			$num = 9;
		}

		if (in_array($hour, ['17', '18'])) {
			$num = 10;
		}

		if (in_array($hour, ['19', '20'])) {
			$num = 11;
		}

		if (in_array($hour, ['21', '22'])) {
			$num = 12;
		}

		return $num;
	}

}