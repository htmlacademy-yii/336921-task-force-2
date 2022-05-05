<?php

namespace nerodemiurgo\services;

use app\models\City;
use DateTime;
use DateInterval;
use yii\helpers\ArrayHelper;

class TaskService
{
    /* @var $tasks array of Task */
    private array $tasks;
    /* @var $categories array of Category */
    private array $categories;

    public function __construct(array $tasks, array $categories)
    {
        $this->tasks = $tasks;
        $this->categories = $categories;
    }


    /**
     * Вычисляет разницу между двумя датами
     **/
    public static function diff(DateTime $dateTime): DateInterval
    {
        $currentDate = new DateTime();
        return $currentDate->diff($dateTime);
    }

    /**
     * Генерирует удобочитаемую форму для расчетных существительных
     **/
    private function convertTimeToRelativeTime(string $created): string
    {
        $interval = $this->diff(new DateTime($created));
        if ($year = $interval->format('%y')) {
            return $this->getPluralNoun($year, 'год', 'года', 'лет');
        }
        if ($month = $interval->format('%m')) {
            return $this->getPluralNoun($month, 'месяц', 'месяца', 'месяцев');
        }
        if ($day = $interval->format('%d')) {
            return $this->getPluralNoun($day, 'день', 'дня', 'дней');
        }
        if ($hour = $interval->format('%h')) {
            return $this->getPluralNoun($hour, 'час', 'часа', 'часов');
        }
        if ($minute = $interval->format('%i')) {
            return $this->getPluralNoun($minute, 'минута', 'минуты', 'минут');
        }
        return 'только что';
    }

    public static function getPluralNoun(int $amount, string $singular, string $plural, string $other): string
    {
        $noun = $amount % 10 == 1 && $amount % 100 != 11 ? $singular : ($amount % 10 >= 2 && $amount % 10 <= 4 && ($amount % 100 < 10 || $amount % 100 >= 20) ? $plural : $other);
        return $amount . ' ' . $noun;
    }

    public function getListPeriods(): array
    {
        return [
            '0' => 'Любой',
            '1 hour' => '1 час',
            '12 hours' => '12 часов',
            '24 hours' => '24 часа',
            '1 week' => '1 неделя',
            '2 weeks' => '2 недели',
            '3 weeks' => '3 недели',
        ];
    }

    public function getListTasks(): array
    {
        $cityIds = array_map(function ($task) {
            return $task['city_id'];
        }, $this->tasks);
        $cities = ArrayHelper::index(City::findAll(array_unique($cityIds)), 'id');

        $result = [];
        foreach ($this->tasks as $task) {
            $result[$task['id']] = [
                'task_id' => $task['id'],
                'name' => $task['name'],
                'description' => $task['description'],
                'budget' => $task['budget'],
                'category_name' => $this->categories[$task['category_id']]->name,
                'city_name' => $cities[$task['city_id']]->name,
                'relative_time' => $this->convertTimeToRelativeTime($task['created_at']),
                'created' => $task['created_at'],
            ];
        }
        return $result;
    }
}
