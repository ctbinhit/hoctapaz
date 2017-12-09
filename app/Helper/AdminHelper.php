<?php

function check_formInputResult($pInputType, $pInputValue) {
    if ($pInputType == null)
        return false;
    switch ($pInputType) {
        case 'checkbox':
            if ($pInputValue === null)
                $r = 0;
            else if ($pInputValue == 'on')
                $r = 1;
            else
                $r = 0;
            break;
        default:

            break;
    }
    return $r;
}


