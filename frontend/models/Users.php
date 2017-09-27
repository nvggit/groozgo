<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $surname
 * @property string $name
 * @property string $birthdate
 * @property integer $male
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['surname', 'name', 'birthdate', 'male'], 'required'],
            [['birthdate'], 'safe'],
            [['male'], 'integer'],
            [['surname', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'birthdate' => 'Дата рожд.',
            'male' => 'Пол',
        ];
    }

	public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['user' => 'id']);
    }
}
