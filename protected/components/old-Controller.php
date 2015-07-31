<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function beforeAction($action)
    {
<<<<<<< HEAD
        $accessedUrl = Yii::app()->request->url;
        $urlParts = explode("/", $accessedUrl);
        $urlPart = (isset($urlParts[2])) ? $urlParts[2] : "";
        if (!empty($urlPart) && $urlPart != 'ip' || $urlPart != 'site') {
=======
        if (  ($this->getUniqueId()) != "ip"  && !Yii::app()->user->isGuest  ) {
>>>>>>> 48a4c92e15b7416cefeebca0e979ce052142be1d
            $ipAddress = Yii::app()->request->getUserHostAddress();
            $criteria = new CDbCriteria;
            $criteria->compare("ip_address", $ipAddress);
            $exists = Ip::model()->exists($criteria);
            if (!$exists) {
                throw new CHttpException(403, "You are not allowed to access these website ");
            }
        }
        parent::beforeAction($action);
        return true;
    }   
}