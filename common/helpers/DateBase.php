<?php
namespace app\common\helpers;

use Yii;

/**
 * 农历api类
 * @author jlb
 */
class DateBase
{
	private static $host = 'https://www.sojson.com/open/api/lunar/json.shtml';

	public static function get($date = null)
	{
		if (is_null($date)) {
			$date = date('Y-m-d');
		}

		$cache = Yii::$app->cache;

		$queryData = http_build_query(['date' => $date]);

		$opts = [
			'http'   => [
				'method' =>	"GET",
				'header' =>	"user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36\r\n"
		  	]
		];

		$context = stream_context_create($opts);

		$url = self::$host . '?' . $queryData;

		if ($cache->get($url)) {
			return $cache->get($url);
		}

		$content = file_get_contents($url, false, $context);

		$ret = json_decode($content, true);

		if ($ret['status'] == 200) {
			$cache->set($url, $ret['data']);
			return $ret['data'];
		}

		return false;
	}


}
