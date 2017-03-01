<?php

class CacheCommand extends CConsoleCommand {
	public function actionIndex() {
		echo "Printing all cache";
		$cacheData =
	}
	public function actionFlush() {
		Yii::app()->cache->flush();
	}
	public function actionGet($cachename) {
		if (is_null(Yii::app()->cache->get($cachename))) {
			echo "Cache doesn't exists";
			die();
		} else {
			echo "Value of cache $cachename is : " .Yii::app()->cache->get($cachename);
			die();
		}
	}
}