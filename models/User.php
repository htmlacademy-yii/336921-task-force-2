<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $registered_at
 * @property int $status
 * @property string $role
 * @property string $email
 * @property string $password
 * @property string $name
 * @property int|null $telephone
 * @property string|null $telegram
 * @property string|null $birthday
 * @property string|null $about
 * @property int|null $city_id
 * @property string|null $avatar
 * @property int|null $show_contact
 *
 * @property City $city
 * @property Response[] $responses
 * @property Review[] $reviews
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property Category[] $userCategories
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['registered_at', 'birthday'], 'safe'],
            [['status', 'role', 'password'], 'required'],
            [['status', 'telephone', 'city_id', 'show_contact'], 'integer'],
            [['about'], 'string'],
            [['role', 'telegram', 'avatar'], 'string', 'max' => 50],
            [['email', 'password', 'name'], 'string', 'max' => 128],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'registered_at' => 'Registered At',
            'status' => 'Status',
            'role' => 'Role',
            'email' => 'Email',
            'password' => 'Password',
            'name' => 'Name',
            'telephone' => 'Telephone',
            'telegram' => 'Telegram',
            'birthday' => 'Birthday',
            'about' => 'About',
            'city_id' => 'City ID',
            'avatar' => 'Avatar',
            'show_contact' => 'Show Contact',
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id'])->inverseOf('users');
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::className(), ['executor_id' => 'id'])->inverseOf('executor');
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['executor_id' => 'id'])->inverseOf('executor');
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksWhereIamCustomer()
    {
        return $this->hasMany(Task::className(), ['customer_user_id' => 'id'])->inverseOf('customerUser');
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksWhereIamExecutor()
    {
        return $this->hasMany(Task::className(), ['executor_user_id' => 'id'])->inverseOf('executorUser');
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(Category::className(), ['user_id' => 'id'])->inverseOf('user');
    }
}
