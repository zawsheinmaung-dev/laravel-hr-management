<?php

return[
    
'attendance_rules' => [
    ['minutes' => 60, 'type' => 'half_day', 'deduction' => 0],
    ['minutes' => 30, 'type' => 'fixed', 'deduction' => 20000],
    ['minutes' => 15, 'type' => 'fixed', 'deduction' => 10000],
],
];