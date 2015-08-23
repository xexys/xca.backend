<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23.08.15
 * Time: 0:30
 */

namespace app\models;

use \app\components\FacadeModel;
use app\models\GameFacade\ParamsCrudHelper;


class GameFacade extends FacadeModel
{
    public $mainParams;
    public $platformsInfoParams;

    private $_game;

    public function __construct($game)
    {
        $scenario = $game->getIsNewRecord() ? self::SCENARIO_CREATE : self::SCENARIO_UPDATE;
        $this->setScenario($scenario);
        $this->_game = $game;

        parent::__construct($scenario);
    }

    public function rules()
    {
        return array(
            array('mainParams', '\app\components\validators\ModelsValidator', 'on' => self::SCENARIO_CREATE),
            array('mainParams', '\app\components\validators\ModelsValidator', 'allowEmpty' => true, 'on' => self::SCENARIO_UPDATE),
            array('platformsInfoParams', '\app\components\validators\ModelsValidator', 'allowEmpty' => true),
        );
    }

// ----- PROTECTED ----------------------------------------------------------------------------------------------------

    protected function _create()
    {
        $this->_getParamsCrudHelper()->create();
    }

    protected function _update()
    {
        $this->_getParamsCrudHelper()->update();
    }

    protected function _delete()
    {
        $this->_getParamsCrudHelper()->delete();
    }

// ----- PRIVATE ------------------------------------------------------------------------------------------------------

    private function _getParamsCrudHelper()
    {
        return new ParamsCrudHelper($this->_game, $this->getAttributes());
    }

}