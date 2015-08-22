<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 19:01
 */

namespace app\models\Form\Game;

use \app\components\FormFacade;


class MainParams extends FormFacade
{
    public $id;
    public $textId;
    public $title;

    private $_gameModel;

    public function __construct($game)
    {
        if ($game->getIsNewRecord()) {
            $scenario = self::SCENARIO_CREATE;
        } else {
            $scenario = self::SCENARIO_UPDATE;
        }

        $this->setScenario($scenario);
        $this->_gameModel = $game;

        parent::__construct($scenario);
    }

    public function init()
    {
        if ($this->getScenario() === self::SCENARIO_UPDATE) {
            $this->_setAttributesByGameModel();
        }
    }

    public function rules()
    {
        return array(
            array('textId, title', 'required'),
            array('textId', 'length', 'max' => 10),
            array('textId', 'validateUniqueInDatabase', 'className' => '\app\models\Game', 'attributeName' => 'text_id'),
            array('title', 'validateUniqueInDatabase', 'className' => '\app\models\Game'),
            array('textId', 'match', 'pattern' => '/^\s*[a-z][a-z0-9_]+\s*$/',),
            array('title', 'length', 'max' => 50),
            array('id', 'required', 'safe' => false, 'on' => self::SCENARIO_UPDATE),
        );
    }

    public function getParamsKeys()
    {
        return $this->getSafeAttributeNames();
    }

    protected function _create()
    {
        $game = $this->_gameModel;
        $game->setAttributes($this->getAttributes());

        if (!$game->save()) {
            throw new CException($game->getFirstErrorMessage());
        }
    }

    protected function _update()
    {
        $this->_create();
    }

    private function _setAttributesByGameModel()
    {
        // safeOnly = false - чтобы установить значение id
        $this->setAttributes($this->_gameModel->getAttributes(), false);
    }
}
