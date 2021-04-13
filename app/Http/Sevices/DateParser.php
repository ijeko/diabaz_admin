<?php


namespace App\Http\Sevices;


class DateParser
{
public static function Parse($date)
{
    $time = strtotime($date);
    $targetDay = date('d', $time);
    $targetMonth = date('m', $time);
    $targetYear = date('Y', $time);
    return [
        'day' => $targetDay,
        'month' => $targetMonth,
        'year' => $targetYear
    ];
}
}
