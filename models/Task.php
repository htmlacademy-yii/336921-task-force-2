<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $created_at
 * @property string $name
 * @property string $description
 * @property int $category_id
 * @property int $budget
 * @property string|null $finished_at
 * @property string $status
 * @property float|null $lat
 * @property float|null $lng
 * @property int|null $city_id
 * @property int $customer_user_id
 * @property int|null $executor_user_id
 *
 * @property Category $category
 * @property City $city
 * @property User $customerUser
 * @property User $executorUser
 * @property Response[] $responses
 * @property Review[] $reviews
 * @property TaskFile[] $taskFiles
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'finished_at'], 'safe'],
            [['name', 'description', 'status', 'customer_user_id'], 'required'],
            [['description'], 'string'],
            [['category_id', 'budget', 'city_id', 'customer_user_id', 'executor_user_id'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['name'], 'string', 'max' => 128],
            [['status'], 'string', 'max' => 50],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['customer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_user_id' => 'id']],
            [['executor_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executor_user_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'name' => 'Name',
            'description' => 'Description',
            'category_id' => 'Category ID',
            'budget' => 'Budget',
            'finished_at' => 'Finished At',
            'status' => 'Status',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'city_id' => 'City ID',
            'customer_user_id' => 'Customer User ID',
            'executor_user_id' => 'Executor User ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id'])->inverseOf('tasks');
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id'])->inverseOf('tasks');
    }

    /**
     * Gets query for [[CustomerUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerUser()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_user_id'])->inverseOf('tasks');
    }

    /**
     * Gets query for [[ExecutorUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorUser()
    {
        return $this->hasOne(User::className(), ['id' => 'executor_user_id'])->inverseOf('tasks0');
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::className(), ['task_id' => 'id'])->inverseOf('task');
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['task_id' => 'id'])->inverseOf('task');
    }

    /**
     * Gets query for [[TaskFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFile::className(), ['task_id' => 'id'])->inverseOf('task');
    }
}
