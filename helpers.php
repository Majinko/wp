<?php

/**
 * Show nice data
 * @param $data
 */
function showData($data): void
{
    echo '<pre>';
    print_r($data);
    echo '<pre/>';

    die();
}