<?php

function path_alte()
{
    return (base_url() . "/AdminLTE-3.1.0");
}

function getClassName($var = null)
{
    return (new \ReflectionClass($var))->getShortName();
}

function getControllerName()
{
    $request = \Config\Services::request();
    return $request->uri->getSegment(1);
}

/** LOAD CSS & JS */
function loadCSS($pathFileCSS, $absPath = null)
{
    if ($absPath == 'appcss') {
        return '<link rel="stylesheet" href="' . base_url() . '/apps/css/' . $pathFileCSS . '"/>' . PHP_EOL;
    } else if ($absPath == 'appplugins') {
        return '<link rel="stylesheet" href="' . base_url() . '/apps/plugins/' . $pathFileCSS . '"/>' . PHP_EOL;
    } else if ($absPath == 'adminlte_plugins') {
        return '<link rel="stylesheet" href="' . path_alte() . '/plugins/' . $pathFileCSS . '"/>' . PHP_EOL;
    } else {
        return '<link rel="stylesheet" href="' . $pathFileCSS . '"/>' . PHP_EOL;
    }
}

function loadJS($pathFileJS, $absPath = null)
{
    if ($absPath == 'appjs') {
        return '<script src="' . base_url() . '/apps/js/' . $pathFileJS . '"></script>' . PHP_EOL;
    } else if ($absPath == 'appplugins') {
        return '<script src="' . base_url() . '/apps/plugins/' . $pathFileJS . '"></script>' . PHP_EOL;
    } else if ($absPath == 'adminlte_plugins') {
        return '<script src="' . path_alte() . '/plugins/' . $pathFileJS . '"></script>' . PHP_EOL;
    } else {
        return '<script src="' . $pathFileJS . '"></script>' . PHP_EOL;
    }
}

function checkAndCreatePath($path)
{
    $status = false;
    if (!file_exists($path)) {
        $status = mkdir($path, 0755, TRUE);
    } else {
        $status = true;
    }
    return $status;
}

function checkUploadImgIfExist($path)
{
    $retPath = "";
    if (file_exists($path)) {
        $retPath = $path;
    } else {
        $retPath = base_url("uploads/noimage.jpg");
    }

    return $retPath;
}

/**
 * Add zero to text
 *  
 * @param string $text text after add zero
 * @param string|null $title text for first text
 * @param int $length of all text
 * 
 * @return mixed
 */
function addZeroSpaces($text, $title = null, $length = 0)
{
    if ($length == 0) {
        return $title . $text;
    } else {
        $lenoftext = strlen($text);
        $lenofchar = $length - $lenoftext;
        return $title . str_repeat("0", $lenofchar) . $text;
    }
}
