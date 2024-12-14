<?php
/*
Plugin Name: ZKML-helper
Description: Wordpress优化🛠️助手
Version: 1.0
Author: 你的名字
Author URI: https://yourwebsite.com
License: GPL2
*/

// 注册卸载钩子
register_uninstall-hook(__FILE__, 'zkml_uninstall');

require_once plugin_dir_path(__FILE__) . 'includes/zkmlcore.php';

// 命名空间检查
if ( ! class_exists( 'ZkmlHelper\RearEnd' ) ) {
    require_once plugin_dir_path( __FILE__ ) . 'includes/RearEnd.php';
}

// 命名空间检查
if ( ! class_exists( 'ZkmlHelper\DbOptimizer' ) ) {
    require_once plugin_dir_path( __FILE__ ) . 'includes/DbOptimizer.php';
}

// 包含后台菜单相关的文件
include_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php';

// 使用ZkmlHelper命名空间下的RearEnd类
use ZkmlHelper\RearEnd;

// 使用ZkmlHelper命名空间下的DbOptimizer类
use ZkmlHelper\DbOptimizer;

// 初始化插件
add_action( 'plugins_loaded', function() {
    new RearEnd();
});

// 在插件加载完成后添加插件操作链接
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), function( $links ) {
    return array_merge( $links, [
        '<a href="admin.php?page=zkml_about">设置</a>',
    ] );
});

// 添加插件行元数据
add_filter( 'plugin_row_meta', function( $plugin_meta, $plugin_file ) {
    if ( $plugin_file === plugin_basename( __FILE__ ) ) {
        return array_merge( $plugin_meta, [
            '<a href="https://example.com/custom-link1" target="_blank">自定义链接1</a>',
        ]);
    }
    return $plugin_meta;
}, 10, 2 );

// 卸载插件时删除特定选项
function zkml_uninstall() {
    $prefix = 'zkml_';
    // 获取所有选项
    $options = get_alloptions();

    foreach ( $options as $option_name => $option_value ) {
        // 检查选项名称是否以前缀开头
        if ( strpos( $option_name, $prefix ) === 0 ) {
            // 删除插件特定选项
            delete_option( $option_name );
        }
    }
}