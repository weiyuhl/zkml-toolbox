<?php
// admin/pages/site-info-dashboard.php

// 获取操作系统详细信息的函数
$get_detailed_os_info = function() {
    $os_info = ['name' => php_uname('s')];
    if (file_exists('/etc/os-release')) {
        $os_release = parse_ini_file('/etc/os-release');
        $os_info['name'] = $os_release['NAME'] ?? $os_info['name'];
        $os_info['version'] = $os_release['VERSION'] ?? '';
    }
    return $os_info;
};

// 获取站点数据的函数
$get_site_data = function() {
    $theme = wp_get_theme();
    return [
        'server_os' => php_uname(),
        'web_server_software' => $_SERVER['SERVER_SOFTWARE'],
        'php_version' => phpversion(),
        'mysql_version' => $GLOBALS['wpdb']->db_version(),
        'wordpress_version' => get_bloginfo('version'),
        'theme_name' => $theme->get('Name'),
        'theme_version' => $theme->get('Version'),
        'total_plugins_installed' => count(get_plugins()),
        'active_plugins_count' => count(get_option('active_plugins')),
        'total_posts_count' => wp_count_posts()->publish + wp_count_posts()->draft,
        'published_posts_count' => wp_count_posts()->publish,
        'draft_posts_count' => wp_count_posts()->draft,
        'total_users_count' => count_users(),
        'subscriber_users_count' => count_users()['avail_roles']['subscriber'] ?? 0,
        'admin_users_count' => count_users()['avail_roles']['administrator'] ?? 0,
        'total_comments_count' => wp_count_comments()->total_comments,
        'approved_comments_count' => wp_count_comments()->approved,
        'pending_comments_count' => wp_count_comments()->moderated,
    ];
};

// 获取站点数据
$site_data = $get_site_data();
$detailed_os_info = $get_detailed_os_info();

// 表格数据
$tables = [
    '服务器详情' => [
        '服务器操作系统' => $detailed_os_info['name'] . ' ' . ($detailed_os_info['version'] ?? ''),
        'Web服务器软件' => $site_data['web_server_software'],
        'PHP版本' => $site_data['php_version'],
        'MySQL版本' => $site_data['mysql_version'],
    ],
    'WordPress详情' => [
        'WordPress版本' => $site_data['wordpress_version'],
        '主题名称' => $site_data['theme_name'],
        '主题版本' => $site_data['theme_version'],
    ],
    '插件详情' => [
        '已安装插件总数' => $site_data['total_plugins_installed'],
        '激活插件数量' => $site_data['active_plugins_count'],
    ],
    '内容详情' => [
        '总文章数量' => $site_data['total_posts_count'],
        '已发布文章数量' => $site_data['published_posts_count'],
        '草稿文章数量' => $site_data['draft_posts_count'],
    ],
    '用户详情' => [
        '总用户数量' => $site_data['total_users_count']['total_users'],
        '订阅者数量' => $site_data['subscriber_users_count'],
        '管理员数量' => $site_data['admin_users_count'],
    ],
    '评论详情' => [
        '总评论数量' => $site_data['total_comments_count'],
        '已批准评论数量' => $site_data['approved_comments_count'],
        '待审评论数量' => $site_data['pending_comments_count'],
    ],
];
?>

<div class="wrap zkml-toolbox-wrap">
    <h1>站点信息仪表盘</h1>
    <?php foreach ($tables as $title => $data): ?>
        <h2><?php echo esc_html($title); ?></h2>
        <table class="form-table">
            <?php foreach ($data as $label => $value): ?>
                <tr>
                    <th><?php echo esc_html($label); ?></th>
                    <td><?php echo esc_html($value); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>
</div>
