<?php
class DownloadController extends Controller
{
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin'),
                'users' => array('administrator'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

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

    public function actionIndex()
    {
        if (isset($_GET['queue_id'])) {
            Yii::import("application.modules.dnc.components.*");
            $queue_id = intval($_GET['queue_id']);
            $model = WhitelistJobQueue::model()->findByPk($queue_id);
            $fileName = $model->queue_name . '-cleaneddata';
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"$fileName.csv\";");
            header("Content-Transfer-Encoding: binary");
            echo "Mobile Number" . "\n";
            DncUtilities::printCleanMobileNumbers($model->queue_id);
            die();
        } else {
            throw new CHttpException(500, "Incomplete parameter : Please provide queue_id");
        }
        $this->redirect(Yii::app()->getBaseUrl(true) . "/dnc");


    }
}

?>
