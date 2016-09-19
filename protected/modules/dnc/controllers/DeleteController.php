<?php
class DeleteController extends Controller{

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            array('application.filters.IpAddressFilter'),
            array('application.filters.UnderConstructionFilter'),
        );
    }

	public function actionIndex(){
		if(isset($_GET['queue_id'])){
			$queue_id = intval($_GET['queue_id']);
			$model = WhitelistJobQueue::model()->findByPk($queue_id);
			if($model->delete()){
				Yii::app()->user->setFlash('success', '<strong>Record Deleted!</strong> You successfully deleted '.$model->queue_name);
			}else{	
				Yii::app()->user->setFlash('error', '<strong>Deletion Failed!</strong> Cant delete '.$model->queue_name);
			}
		}else{
			throw new CHttpException(500,"Incomplete parameter : Please provide queue_id");
		}

		$this->redirect(Yii::app()->request->urlReferrer);
	}

}

?>
