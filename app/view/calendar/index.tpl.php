<div class="card card-2">

<h1>Kalender</h1>

<div class="prev-month-nav"><a href='<?=$this->url->create("calendar?date=$prevMonthDate")?>'>&laquo;<?=$prevMonth?></a></div>
<div class="next-month-nav"><a href='<?=$this->url->create("calendar?date=$nextMonthDate")?>'><?=$nextMonth?>&raquo;</a></div>
<div class="month-year"><?=$thisMonth?></div>

<div class='calendar-table'><table>
    <tr>
        <th></th><th>Måndag</th><th>Tisdag</th><th>Onsdag</th><th>Torsdag</th><th>Fredag</th><th>Lördag</th><th>Söndag</th>
    </tr>
<?php
$length = sizeof($dates);
$i = 0;
while ($i < $length) {
    echo "<tr>";
    echo "<td class='week'>v.{$dates[$i]['week']}</td>";
    for ($d=1; $d < 8; $d++) {
        echo "<td class='day {$dates[$i]['class-red']} {$dates[$i]['class-today']} {$dates[$i]['class-in-month']}' >{$dates[$i]['date']}</td>";
        $i += 1;
    }
    echo "</tr>";
}
?>
</table>
</div>


</div>
