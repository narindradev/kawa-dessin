<?php

if (!function_exists('get_menus_list')) {

    function get_menus_list($key = "")
    {
        /** Verical menu */
        $menu_vertical  = $menu_horizontal = [];

        $menu_vertical[] = ["title" => "Dashboard", 'path'  => 'index',  'icon'  => theme()->getSvgIcon("demo1/media/icons/duotune/art/art002.svg", "svg-icon-2")];

        $menu_vertical[] = ["classes" => ['content' => 'pt-8 pb-2'], 'content' => '<span class="menu-section text-muted text-uppercase fs-8 ls-1">Modules</span>',];


        $account_sub_items = [];
        $account_sub_items[]  = ["title" => "Overview", "path" => "account/overview", "bullet" => '<span class="bullet bullet-dot"></span>'];
        $account_sub_items[]  = ["title" => "Settings", "path" => "account/settings", "bullet" => '<span class="bullet bullet-dot"></span>'];
        $account_sub_items[]  = ["title" => "Security", "path" => "#", "bullet" => '<span class="bullet bullet-dot"></span>', "attributes" => ["tiltle" => "blabla"]];

        $menu_vertical[] = ["title" => "Account", "sub" => ["class" => "menu-sub-accordion menu-active-bg", "items" => $account_sub_items],  'attributes' => array("data-kt-menu-trigger" => "click"), 'classes'    => array('item' => 'menu-accordion'),  'icon' => ['svg'  => theme()->getSvgIcon("demo1/media/icons/duotune/communication/com006.svg", "svg-icon-2"), 'font' => '<i class="bi bi-person fs-2"></i>']];

        $system_sub_items = [];
        $system_sub_items[]  = ["title" => "Settings", "path" => '#', "bullet" => '<span class="bullet bullet-dot"></span>'];
        $system_sub_items[]  = ["title" => "Audit Log", "path" => "log/audit", "bullet" => '<span class="bullet bullet-dot"></span>'];
        $system_sub_items[]  = ["title" => "System Log", "path" => "log/system", "bullet" => '<span class="bullet bullet-dot"></span>', "attributes" => ["tiltle" => "blabla"]];




        $menu_vertical[] = ["title" => "System", "sub" => ["class" => "menu-sub-accordion menu-active-bg", "items" => $system_sub_items],  'attributes' => array("data-kt-menu-trigger" => "click"), 'classes'    => array('item' => 'menu-accordion'),  'icon' => ['svg'  => theme()->getSvgIcon("demo1/media/icons/duotune/general/gen025.svg", "svg-icon-2"), 'font' => '<i class="bi bi-layers fs-3"></i>']];

        $menu_vertical[] = ["classes" => ['content' => 'pt-8 pb-2'], 'content' => '<span class="menu-section text-muted text-uppercase fs-8 ls-1">Gerée</span>',];
        $menu_vertical[] = ["title" => __("lang.offers"), 'path'  => 'offer/index',  'icon'  => '<i class="fas fa-briefcase fs-3"></i>'];
        
        $menu_vertical[] =  ['content' => '<div class="separator mx-1 my-4"></div>'];
       
        $menu_vertical[] = ['title' => 'Changelog v' . theme()->getVersion(),'icon'  => theme()->getSvgIcon("demo1/media/icons/duotune/general/gen005.svg", "svg-icon-2"),'path'  => 'documentation/getting-started/changelog'];
        

        /**  Menu horizontal */
        $menu_horizontal[] =  ['title'   => 'Dashboard', 'path'    => 'index', 'classes' => array('item' => 'me-lg-1')];
        $resources_sub_items[] =  ["title" => "Documentation", "path" => 'documentation/getting-started/overview', 'icon'  => theme()->getSvgIcon("demo1/media/icons/duotune/abstract/abs027.svg", "svg-icon-2")];
        $resources_sub_items[] =  ["title" => "Changelog", "path" => 'documentation/getting-started/changelog', 'icon'  => theme()->getSvgIcon("demo1/media/icons/duotune/general/gen005.svg", "svg-icon-2")];

        $menu_horizontal[] =  ['title'   => 'Resources', 'path'    => 'index', "sub" => ["items" => $resources_sub_items, "class" => "menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px"], 'classes' => array('item' => 'menu-lg-down-accordion me-lg-1', 'arrow' => 'd-lg-none'), 'attributes' => array('data-kt-menu-trigger'   => "click", 'data-kt-menu-placement' => "bottom-start")];

        $menu = ["main" => $menu_vertical, "horizontal" => $menu_horizontal];
        if ($key) {
            return get_array_value($menu, $key);
        }
        return $menu;
    }
}
