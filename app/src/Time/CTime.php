<?php

namespace kalkih\Time;

/**
 * A Time class for time and date functions.
 *
 */
class CTime
{


    /**
     * Create a relative time string.
     * 
     * @param int $ts time in milliseconds
     *
     */
    public function getRelativeTime($ts)
    {
        if(!ctype_digit($ts))
            $ts = strtotime($ts);

        $diff = time() - $ts;
        if($diff == 0)
            return 'nyss'; // 'now';
        elseif($diff > 0)
        {
            $day_diff = floor($diff / 86400);
            if($day_diff == 0)
            {
                if($diff < 60) return 'nyss'; //'just now';
                if($diff < 120) return '1 minut sen'; //'1 minute ago';
                if($diff < 3600) return floor($diff / 60) . ' minuter sen'; // ' minutes ago';
                if($diff < 7200) return '1 timme sen'; // '1 hour sen';
                if($diff < 86400) return floor($diff / 3600) . ' timmar sen'; // ' hours ago';
            }
            if($day_diff == 1) return 'igår'; // 'Yesterday';
            if($day_diff < 7) return $day_diff . ' dagar sen'; // ' days ago';
            if($day_diff < 31) return ceil($day_diff / 7) . 'veckor sen'; // ' weeks ago';
            if($day_diff < 60) return ' förra månaden'; // 'last month';
            return date('F Y', $ts);
        }
        else
        {
            $diff = abs($diff);
            $day_diff = floor($diff / 86400);
            if($day_diff == 0)
            {
                if($diff < 120) return 'in a minute';
                if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
                if($diff < 7200) return 'in an hour';
                if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
            }
            if($day_diff == 1) return 'Tomorrow';
            if($day_diff < 4) return date('l', $ts);
            if($day_diff < 7 + (7 - date('w'))) return 'next week';
            if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
            if(date('n', $ts) == date('n') + 1) return 'next month';
            return date('F Y', $ts);
        }
    }
}
