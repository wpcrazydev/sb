<?php
function dynamicHash($value1, $value2) {
    $hash = hash( 'sha256', $value1 . $value2 );
    return $hash;
}