<?php 



/**
* ExportAllController
*/
class ExportAllController extends Controller
{

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
            array('application.filters.IpAddressFilter'),
            array('application.filters.UnderConstructionFilter'),
			'accessControl',
		);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index'),
				'users'=>array('administrator'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	
	public function actionIndex()
	{
		$fileName = 'blacklisted-mobile-add'.date("Y-m-d");
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: text/plain");
		header("Content-Disposition: attachment; filename=\"$fileName.txt\";" );
		header("Content-Transfer-Encoding: binary");
		$allBlackLIstedMObilecount = BlackListedMobile::model()->count();
		$offset = 0;
		$limit = 50000;
		do {
			$results = Yii::app()->db->createCommand("select mobile_number from black_listed_mobile LIMIT $limit OFFSET $offset")->queryAll();
			foreach ($results as $value) {
				echo $value['mobile_number'].PHP_EOL;
			}
			$offset = $offset + $limit;
		} while ($offset <= $allBlackLIstedMObilecount);
		die();
	}


}

?>