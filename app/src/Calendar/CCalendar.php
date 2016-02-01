<?php

namespace Mos\Calendar;

use \DateTime;

/**
 * Class for calendar function
 */
class CCalendar
{

    /**
    * Properties
    *
    */
    private $today;
    private $firstDayInWeekOfMonth;
    private $lastDayInLastWeek;
    private $lastDayInMonth;
    private $thisMonth;
    private $prevMonth;
    private $nextMonth;

    /**
    * Constructor
    *
    * @param string date in month to display. Format yyyy-mm-dd
    *
    */
    public function __construct($displayDate = null)
    {
        setlocale(LC_TIME, "Swedish");
        define("CHARSET", "iso-8859-1");

        if (null == $displayDate) {
            $date = new DateTime();
        } else {
            $date = new DateTime($displayDate);
        }
        $this->today = new DateTime();
        // Remove time, only keep date when we compare later.
        $this->today->setTime(0, 0);

        // Find first week and day in month and first day in that week
        $year = $date->format('Y');
        $month = $date->format('m');
        $this->firstDayInMonth = new DateTime();
        $this->firstDayInMonth->setTime(0, 0);
        $this->firstDayInMonth->setDate($year, $month, 1);
        $dayOfWeek = $this->firstDayInMonth->format('N');
        $subtractDays = $dayOfWeek - 1;
        $this->firstDayInWeekOfMonth = new DateTime($this->firstDayInMonth->format('Y-m-d'));
        $this->firstDayInWeekOfMonth->modify("-{$subtractDays} day");

        // Find last week and day in month and last day in that week
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $this->lastDayInMonth = new DateTime("$year-$month-$daysInMonth");
        $this->lastDayInMonth->setTime(0, 0);
        $dayOfWeek = $this->lastDayInMonth->format('N');
        $addDays = 7 - $dayOfWeek;
        $this->lastDayInLastWeek = new DateTime($this->lastDayInMonth->format('Y-m-d'));
        $this->lastDayInLastWeek->modify("+$addDays day");

        $this->thisMonth = new DateTime($this->firstDayInMonth->format('Y-m-d'));
        $this->prevMonth = new DateTime($this->firstDayInMonth->format('Y-m-d'));
        $this->prevMonth->modify('-1 month');
        $this->nextMonth = new DateTime($this->firstDayInMonth->format('Y-m-d'));
        $this->nextMonth->modify('+1 month');


    }


    public function today()
    {
        $today = new DateTime();
        $out = utf8_encode(strftime("%A %d %B %Y", strtotime($today->format('Y-m-d'))));
        return $out;
    }

    /**
    * Get current month with month and year
    */
    public function thisMonth()
    {
        return utf8_encode(strftime("%B %Y", strtotime($this->thisMonth->format('Y-m-d'))));
    }

    /**
    * Get previous month in text format
    */
    public function prevMonth()
    {
        return utf8_encode(strftime("%B", strtotime($this->prevMonth->format('Y-m-d'))));
    }

    /**
    * Get previous month in format yyyy-mm-dd
    */
    public function prevMonthDate()
    {
        return $this->prevMonth->format('Y-m-d');
    }

    /**
    * Get next month in text format
    */
    public function nextMonth()
    {
        return utf8_encode(strftime("%B", strtotime($this->nextMonth->format('Y-m-d'))));
    }

    /**
    * Get next month in format yyyy-mm-dd
    */
    public function nextMonthDate()
    {
        return $this->nextMonth->format('Y-m-d');
    }

    /**
    * Get all dates in month with additional days in first and last week.
    *
    */
    public function datesInMonth()
    {
        $date = $this->firstDayInWeekOfMonth;
        while ($date <= $this->lastDayInLastWeek) {
            $w = ltrim($date->format('W'), 0);
            for ($d=1; $d < 8; $d++) {
                // $dateText = utf8_encode(strftime("%A %e %B", strtotime($date->format('Y-m-d'))));
                // %e does not work on windows, use %d instead
                $dateText = utf8_encode(strftime("%A %#d %B", strtotime($date->format('Y-m-d'))));
                $dateText = $date->format('d M');
                // $dateText = $date->format('D d M');
                $redDay = (7==$d) ? "red-day" : "";
                $classToday = ($date == $this->today) ? "today" : "";
                $classThisMonth = ($date < $this->firstDayInMonth || $date > $this->lastDayInMonth) ? "class-outside-month" : "class-inside-month";
                $date->modify("+1 day");
                $dates[] = array(
                    'week' => $w,
                    'date' => $dateText,
                    'class-red' => $redDay,
                    'class-today' => $classToday,
                    'class-in-month' => $classThisMonth,
                );
            }
        }
        return $dates;
    }
}
