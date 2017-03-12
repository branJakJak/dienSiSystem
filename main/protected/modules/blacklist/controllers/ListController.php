<?php 

/**
* 	
*/
class ListController extends Controller
{
	public $layout='//layouts/column2';
    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            array('application.filters.IpAddressFilter'),
            array('application.filters.UnderConstructionFilter'),
        );
    }
	public function actionIndex()
	{
		$model=new BlackListedMobile('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BlackListedMobile']))
			$model->attributes=$_GET['BlackListedMobile'];

		$this->render('list',array(
			'model'=>$model,
		));		
	}
}