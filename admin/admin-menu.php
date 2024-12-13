<?php

// 确保 WordPress 加载环境
if (!defined('ABSPATH')) {
    exit; // 避免直接访问插件文件
}

// 添加后台菜单和子菜单
function zkml_toolbox_menu() {
    // 添加主菜单项
    add_menu_page(
        'ZKML-helper',                           // 顶级菜单的页面标题
        'ZKML-helper',                           // 顶级菜单的名称
        'manage_options',                        // 用户权限要求
        'zkml_helper',                           // 菜单标识
        '',                                      // 回调函数（不需要页面，留空）
        'dashicons-superhero-alt',               // 使用 WordPress 图标，你可以根据需要更改
        20                                       // 设置菜单项位置
    );

    // 添加第一个子菜单 - 后台优化
    add_submenu_page(
        'zkml_helper',                           // 父菜单标识
        '后台优化',                               // 子菜单的页面标题
        '后台优化',                               // 子菜单的名称
        'manage_options',                        // 用户权限要求
        'zkml_rear_end',                         // 子菜单标识
        'zkml_rear_end_page'                     // 回调函数，用于显示后台优化页面内容
    );

add_submenu_page(
        'zkml_helper',                           // 父菜单标识
        '数据库管理',                           // 子菜单的页面标题
        '数据库管理',                           // 子菜单的名称
        'manage_options',                        // 用户权限要求
        'zkml_Db_Optimizer',              // 子菜单标识
        'zkml_Db_Optimizer_page'          // 回调函数，用于显示数据库管理页面内容
    );

    // 添加第二个子菜单 - 站点信息仪表盘
    add_submenu_page(
        'zkml_helper',                           // 父菜单标识
        '站点信息仪表盘',                           // 子菜单的页面标题
        '站点信息仪表盘',                           // 子菜单的名称
        'manage_options',                        // 用户权限要求
        'zkml_site_info_dashboard',              // 子菜单标识
        'zkml_site_info_dashboard_page'          // 回调函数，用于显示站点信息仪表盘页面内容
    );

    // 移除与顶级菜单相同的子菜单项
    remove_submenu_page('zkml_helper', 'zkml_helper');
}

// 后台优化子菜单回调函数
function zkml_rear_end_page() {
    // 后台优化设置页面内容
    include_once(plugin_dir_path(__FILE__) . 'RearEnd-page.php');
}

// Db_Optimizer子菜单回调函数
function zkml_Db_Optimizer_page() {
    // 后台优化设置页面内容
    include_once(plugin_dir_path(__FILE__) . 'Db-Optimizer.php');
}



// 站点信息仪表盘子菜单回调函数
function zkml_site_info_dashboard_page() {
    // 站点信息仪表盘设置页面内容
    include_once(plugin_dir_path(__FILE__) . 'site-info-dashboard.php');
}

// 钩子：admin_menu，用于添加菜单
add_action('admin_menu', 'zkml_toolbox_menu');
