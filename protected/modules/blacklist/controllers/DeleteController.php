<?php 
/**
* 
*/
class DeleteController extends Controller
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
			array('allow', 
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		if (isset($_GET['queue_id'])  && !empty($_GET['queue_id'])  ) {
			$criteria = new CDbCriteria;
			$criteria->compare("queue_id" , $_GET['queue_id']);
			BlackListedMobile::model()->deleteAll($criteria);
			Yii::app()->user->setFlash('error', '<strong><i class="fa fa-warning"></i> Black listed mobile numbers deleted!</strong>.Deleted mobile numbers can never be retrieved.');
			$this->redirect(Yii::app()->request->baseUrl . "/blacklist/default");
		}
	}
}