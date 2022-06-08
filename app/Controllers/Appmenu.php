<?php

namespace App\Controllers;

use App\Models\M_menu;

class Appmenu extends BaseController
{
    public function Menu($idMenu)
    {
        $menuModel = new M_menu;

        $selMenu = $menuModel->getMenu($idMenu);
        $parent_menu = $selMenu['parent_id'];
        $page = $selMenu['menu_link'];

        $selectedMenu = [
            'menu_id' => $idMenu,
            'menu_parent' => $parent_menu
        ];

        session()->set('selected_menu', $selectedMenu);

        return redirect()->to("/$page");
    }

    //--------------------------------------------------------------------

}
