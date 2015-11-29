<?php
namespace Anax\Content;
use \Datetime;
/* ==== TIME FUNCTIONS ===== */

class CTime
{
        use \Anax\TConfigure,
        \Anax\DI\TInjectionAware;

    
/* ==== GET TIME AGO ===== */
    
    function timeago($time){
        
        $start_date = new DateTime('');
        $since_start = $start_date->diff(new DateTime($time));
        
        if($since_start->y >= 1){
            echo $since_start->y.' år';
            echo $since_start->m.' månader';
        }
        elseif($since_start->m >= 1){
            echo $since_start->m.' månader';
        }
//        elseif($since_start->m = 1){
//            echo $since_start->m.' månad';
//        }
        elseif($since_start->d > 1) {
            echo $since_start->d.' dagar sedan';
        }
        elseif($since_start->d = 1){
            echo $since_start->d.' dag sedan';
        }
        elseif($since_start->h >=1){
            echo $since_start->h.' timmar';
        }
        elseif($since_start->i >=1){
            echo ' alldeles nyss';
        }
            
    }
    

}