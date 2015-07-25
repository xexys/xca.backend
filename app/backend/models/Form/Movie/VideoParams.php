<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 15:56
 */

namespace backend\models\Form\Movie;


class VideoParams extends \common\components\FormModel
{
    const FRAME_RATE_MODE_CONSTANT = 0;
    const FRAME_RATE_MODE_VARIABLE = 1;
    const FORMAT_ID_H264 = 3;

    public $formatId = self::FORMAT_ID_H264;
    public $width;
    public $height;
    public $bitRate;
    public $frameRate;
    public $frameRateMode = self::FRAME_RATE_MODE_CONSTANT;
    public $frameQuality;

    private static $_formatDictionary;

    public function rules()
    {
        return array(
            array('width, height, bitRate', 'required'),
            array('width, height, bitRate', 'numerical', 'integerOnly' => true),
            array('frameQuality', 'numerical'),
            array('frameRateMode', 'in', 'range' => array_keys($this->getFrameRateModeDictionary()), 'allowEmpty' => false),
            array('formatId', 'in', 'range' => array_keys($this->getFormatDictionary()), 'allowEmpty' => false),
            array('frameRate', 'in', 'range' => array_keys($this->getFrameRateDictionary()), 'allowEmpty' => false),
        );
    }

    public function getDictionary($key)
    {
        $data = array();

        switch ($key) {
            case 'formatId':
                $data = $this->getFormatDictionary();
                break;
            case 'frameRate':
                $data = $this->getFrameRateDictionary();
                break;
            case 'frameRateMode':
                $data = $this->getFrameRateModeDictionary();
                break;
        }

        return $data;
    }

    public function getFrameRateDictionary()
    {
        return array(
            '24',
            '29.97',
            '30',
        );
    }

    public function getFrameRateModeDictionary()
    {
        return array(
            self::FRAME_RATE_MODE_CONSTANT => 'CFR',
            self::FRAME_RATE_MODE_VARIABLE => 'VFR',
        );
    }

    public function getFormatDictionary()
    {
        if (self::$_formatDictionary === null) {
            self::$_formatDictionary = array();

            $data = \common\models\Dictionary\VideoFormat::model()->findAll(array(
                'order'=>'t.name ASC'
            ));

            foreach ($data as $item) {
                self::$_formatDictionary[$item->id] = $item->name;
            }
        }
        return self::$_formatDictionary;
    }
}