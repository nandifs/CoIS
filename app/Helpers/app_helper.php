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

/**
 * Convert string to array
 *  
 * @param string $text text after add zero
 * @param string|null $delimiter for separate array 
 * 
 * @return mixed
 */
function stringToArray($text, $delimiter = ',')
{
    $text = strtr($text, array("\r\n" => "", "\r" => "", "\n" => "", " " => ""));
    $text = explode($delimiter, $text);
    return $text;
}

/**
 * Format coloum value for table
 * 
 *  
 * @param string $colName text title of coloum with format saparator
 * @param array $coldata row data
 * @param references $realValue row data
 * @return array
 */
function coloumFormat($colName, $colData)
{
    $colValue = array();
    if (strpos($colName, "|")) {
        $afrmt = explode("|", $colName);
        if ($afrmt[0] == "c") {
            $colfield = $afrmt[1];
            $realValue = $colData->$colfield;
            $colValue[] = number_format((float) $realValue, 2);
            $colValue[] = $realValue;
        } else {
            $colValue[] = $colData->$colName;
            $colValue[] = $colData->$colName;
        }
    } else {
        $colValue[] = $colData->$colName;
        $colValue[] = $colData->$colName;
    }
    return $colValue;
}

function validasiNilaiRupiah($svalue)
{
    $rvalue = 0;

    $cdec = substr($svalue, -3, 1); //cek delimiter decimal
    if ($cdec == '.' || $cdec == ',') {
        if ($cdec == '.') {
            $rvalue = str_replace(',', "", $svalue);
        } else {
            $rvalue = str_replace(',', '.', str_replace('.', "", $svalue));
        }
    } else {
        $cribuan = substr($svalue, -4, 1); //cek delimiter ribuan
        if ($cribuan == ',') {
            $rvalue = str_replace(',', "", $svalue);
        } else {
            $rvalue = str_replace('.', "", $svalue);
        }
    }
    return $rvalue;
}

function createMenuItem($title, $menu_id, $icon)
{
    echo "<li class='nav-item'>
            <a href='/menu/" . $menu_id . "' class='nav-link'>
                <i class='nav-icon $icon'></i>
                <p>$title</p>
            </a>
          </li>";
}

function createMenuHeader($title)
{
    echo "<li class='nav-header'>$title</li>";
}
function createMenuTree($title, $link, $icon, $arr_menu, $parent_id, $sel_menu)
{
    echo "<li class='nav-item " . (($sel_menu['menu_parent'] == $parent_id || $sel_menu['menu_parent_top'] == $parent_id) ? "menu-open" : "") . "'>";
    echo "  <a href='$link' class='nav-link'>
                <i class='nav-icon $icon'></i>
                <p>
                    $title
                    <i class='right fas fa-angle-left'></i>
                </p>
            </a>";
    echo "  <ul class='nav nav-treeview'>";
    foreach ($arr_menu as $item) {
        if ($item['parent_id'] == $parent_id) {
            if ($item['menu_link'] != "#" && $item['menu_level'] == 1) {
                echo "<li class='nav-item'>
                        <a href='/menu/" . $item["id"] . "' class='nav-link " . (($sel_menu['menu_id'] == $item['id']) ? " active" : "") . "'>
                            <i class='nav-icon " .  (($sel_menu['menu_id'] == $item['id']) ? "far fa-dot-circle" : $item["menu_icon"]) . "'></i>
                            <p>" . $item["menu_title"] . "</p>
                        </a>
                      </li>";
            } else {
                $sub_parent_id = $item['id'];
                createMenuTree_lv2($item['menu_title'], $item['menu_link'], $arr_menu, $sub_parent_id, $sel_menu);
            }
        }
    }
    echo "  </ul>";
    echo "</li>";
}

function createMenuTree_lv2($title, $link, $arr_menu, $parent_id, $sel_menu)
{
    echo "<li class='nav-item  " . (($sel_menu['menu_parent'] == $parent_id) ? "menu-open" : "") . "'>";
    echo "  <a href='$link' class='nav-link'>
                <i class='nav-icon fas fa-circle'></i>
                <p>
                    $title
                    <i class='right fas fa-angle-left'></i>
                </p>
            </a>";
    echo "  <ul class='nav nav-treeview'>";
    foreach ($arr_menu as $item) {
        //dd("MENU_ID : " . $sel_menu['menu_id'] . " VS " . $item['id']);
        if ($item['parent_id'] == $parent_id) {
            echo "<li class='nav-item'>                    
                    <a href='/menu/" . $item["id"] . "' class='nav-link " . (($sel_menu['menu_id'] == $item['id']) ? " active" : "") . "'>
                        &nbsp;&nbsp;&nbsp;
                        <i class='nav-icon " .  (($sel_menu['menu_id'] == $item['id']) ? "far fa-dot-circle" : $item["menu_icon"]) . "'></i>
                        <p>" . $item["menu_title"] . "</p>
                    </a>
                    </li>";
        }
    }
    echo "  </ul>";
    echo "</li>";
}
