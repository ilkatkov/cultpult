<?php

require_once '../../../vendor/autoload.php';
use Carbon\Carbon;

class DateParser
{
    function parseDate(string $month, string $year) : array
    {
        $actualDate = "{$year}-{$month}";

        $startDate = Carbon::parse($actualDate)->startOfMonth();
        $endDate = Carbon::parse($actualDate)->endOfMonth();

        $datesArray = [];
        while ($startDate->lte($endDate)) {
            $datesArray[] = $startDate->copy();
            $startDate->addDay();
        }
        $dates = array();
        foreach ($datesArray as $date) {
            array_push($dates, (string)$date->format('d.m.Y')); // Здесь выводятся все даты в формате d.m.Y, изменяй под проект
        }
        return $dates;
    }
}