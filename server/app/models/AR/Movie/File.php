<?php

namespace app\models\AR\Movie;
use \app\components\ActiveRecord;


class File extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{movies_files}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('movie_id, type', 'numerical', 'integerOnly'=>true),
            array('description', 'length', 'max'=>500),
            array('md5', 'length', 'max'=>32),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, movie_id, type, description, md5', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'movie' => array(self::BELONGS_TO, '\app\models\AR\Movie', 'movie_id'),
            'audioParams' => array(self::HAS_MANY, '\app\models\AR\Movie\File\AudioParams', 'movie_file_id'),
            'mainParams' => array(self::HAS_MANY, '\app\models\AR\Movie\File\MainParams', 'movie_file_id'),
            'mediaInfo' => array(self::HAS_MANY, '\app\models\AR\Movie\File\MediaInfo', 'movie_file_id'),
            'sourcesInfo' => array(self::HAS_MANY, '\app\models\AR\Movie\File\SourceInfo', 'movie_file_id'),
            'storages' => array(self::HAS_MANY, '\app\models\AR\Movie\File\Storage', 'movie_file_id'),
            'videoParams' => array(self::HAS_MANY, '\app\models\AR\Movie\File\VideoParams', 'movie_file_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'movie_id' => 'Movie',
            'type' => 'Type',
            'description' => 'Description',
            'md5' => 'Md5',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('movie_id',$this->movie_id);
        $criteria->compare('type',$this->type);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('md5',$this->md5,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}