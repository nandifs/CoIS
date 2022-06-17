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

        $level = $selMenu['menu_level'];
        if ($level == 2) {
            $topMenu = $menuModel->getMenu($parent_menu);
            $parent_top_menu = $topMenu['parent_id'];
        } else {
            $parent_top_menu = 0;
        }

        $selectedMenu = [
            'menu_id' => $idMenu,
            'menu_parent' => $parent_menu,
            'menu_parent_top' => $parent_top_menu,
        ];

        session()->set('selected_menu', $selectedMenu);

        return redirect()->to("/$page");
    }

    //--------------------------------------------------------------------

}
