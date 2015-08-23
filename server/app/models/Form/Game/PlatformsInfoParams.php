<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 19:02
 */

namespace app\models\Form\Game;

use \Yii;
use \CHtml;
use \CActiveForm;
use \app\components\FormCollection;
use \app\models\AR\Game;
use \app\helpers\Data as DataHelper;


class PlatformsInfoParams extends Params
{
    public $items;
    
    public function init()
    {
        $this->items = new FormCollection;
        $this->items[] = $this->createItem();

        parent::init();
    }

    public function rules()
    {
        return array(
            array('items', '\app\components\validators\ModelsValidator'),
        );
    }

    public function setAttributesByPost($postData = array())
    {
        $postData = Yii::app()->getRequest()->getPost($this->_getPostKey());

        if ($postData) {
            $this->items->clear();
            foreach ($postData as $n => $data) {
                $item = $this->createItem();
                $item->setAttributes(DataHelper::trimRecursive($data));
                // Важно сохранить номер, чтобы правильно сработала ajax валидация
                $this->items[$n] = $item;
            }
        }
    }

    public function getFormKeys()
    {
        return $this->items->getFirstItem()->getSafeAttributeNames();
    }

    public function getAjaxValidationResponseContent()
    {
        return CActiveForm::validateTabular($this->items->toArray(), null, false);
    }

    public function createItem()
    {
        return new PlatformsInfoParamsItem($this->getScenario());
    }

    private function _getPostKey()
    {
        return CHtml::modelName($this->items->getFirstItem());
    }

    protected function _setAttributesByGameModel()
    {
        $platformsInfo = $this->_gameModel->platformsInfo;
        if ($platformsInfo) {
            $this->items->clear();
            foreach ($platformsInfo as $platformInfo) {
                $item = $this->createItem();
                $item->setAttributes($platformInfo->getAttributes());
                $this->items[] = $item;
            }
        }
    }
}