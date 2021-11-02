<?php
require_once('config.php');

$filename = 'http://www.cbr.ru/scripts/XML_daily.asp';

$data = simplexml_load_file($filename);

$value = $data->Valute[0];

    $index = 0;
    $length = count($data);
    var_dump($length);
    while($index < $length)
    {
        $value = $data->Valute[$index];
        
        $values_array=(array)$value;
        // AMD RUB USD BRL BGN
        $name = $values_array['CharCode'];
        // ammount of money
        $rate=$values_array['Value'];
        //ID
        $id = $values_array["@attributes"]['ID'];

        var_dump($name);
        var_dump($rate);
        var_dump($id);

        $index++;

    }