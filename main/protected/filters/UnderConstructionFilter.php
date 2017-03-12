<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kevin
 * Date: 5/12/15
 * Time: 1:57 AM
 * To change this template use File | Settings | File Templates.
 */

class UnderConstructionFilter extends CFilter{
    protected function preFilter($filterChain)
    {
        if ( MessageBoard::isUnderConstruction()  && Yii::app()->getUser()->getId() !== 'administrator') {
            Yii::app()->request->redirect("/underconstruction");
            return false;
        }else{
            return true;
        }
    }


}