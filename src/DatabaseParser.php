<?php
namespace TanKode\A3L;

class DatabaseParser
{
    public function decodeLicenses($string)
    {
        $return = [];
        if (! empty($string)) {
            $string = str_replace('"', '', $string);
            $json = str_replace('`', '"', $string);
            $return = json_decode($json);
            if (is_null($return)) {
                throw new \InvalidArgumentException("The given string can not be decoded.");
            }
        }

        return $return;
    }

    public function encodeLicenses($array, $ints = false)
    {
        $licenses = [];
        foreach($array as $license => $state) {
            $licenses[] = [$license, $state];
        }
        sort($licenses);

        $return = null;
        if (is_array($array)):
            $string = json_encode($array);
            $string = str_replace('{', '[', $string);
            $string = str_replace('"', '`', $string);
            $string = str_replace(':', ',', $string);
            $string = str_replace('}', ']', $string);
            if ($ints == false) {
                $string = preg_replace("/`(\d+)`/", '$1', $string);
            }
            $return = '"'.$string.'"';
        endif;

        return $return;
    }
}