<?php
// 将原来在主文件中的代码复制到这里
add_action('admin_notices', function() {
    $file_path = plugin_dir_path(__FILE__) . '../assets/txt/epiphanies.txt';
    $sentences = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $sentence = wptexturize($sentences[array_rand($sentences)]);
    echo "<p id='epiphany'>$sentence</p>";
});

add_action('admin_enqueue_scripts', function() {
    wp_enqueue_style('epiphany-style', plugin_dir_url(__FILE__) . '../assets/css/style.css');
});


add_filter( 'admin_footer_text', function() {
    $link_url = 'https://chatgpt.heliq.cn'; // 修改为你想要跳转的链接地址
    $link_text = 'ZKML-helper'; // 修改为你想要显示的链接文本
    $exclamation_text = ' 守护本网站！'; // 修改为你想要显示的感叹号文本

    $footer_text = sprintf( '欢迎使用 <a href="%s">%s</a>%s', esc_url( $link_url ), esc_html( $link_text ), esc_html( $exclamation_text ) );

    return $footer_text;
}, 9999 );


function custom_login_page_styles() {
  echo '<style>';
  echo '#login h1 a, .login h1 a {';
  echo 'background-image:url(http://img.heliq.cn/ico_166x166.png);';
  echo 'background-size:contain;';
  echo 'width:180px;';
  echo '}';
  echo '</style>';
}
add_action('login_enqueue_scripts', 'custom_login_page_styles');

function custom_login_header_url() {
  return home_url();
}
add_filter('login_headerurl', 'custom_login_header_url');


//add_action('in_admin_header', function(){
//	add_filter('screen_options_show_screen', '__return_false');
//	add_filter('hidden_columns', '__return_empty_array');
//});
//add_action('in_admin_header', function(){
//	global $current_screen;
//	$current_screen->remove_help_tabs();
//});





function custom_admin_styles() {
    echo '<style>
            /* 全局背景颜色和字体 */
            body, #wpwrap, #wpcontent, #wpbody-content, .wrap, .postbox, .meta-box-sortables, .stuffbox, .inside, .form-table, .form-wrap, .media-frame, .media-frame-menu, .media-frame-title, .media-frame-router, .media-frame-content, .media-sidebar, .attachment-details, .attachment-info, .attachment-display-settings, .media-frame-toolbar, .media-uploader-status, .media-uploader-editor, .media-sidebar .details, .media-sidebar .details .thumbnail, .media-sidebar .details .details-image, .media-sidebar .details .details-info, .media-sidebar .details .details-info .setting, .media-sidebar .details .details-info .setting input, .media-sidebar .details .details-info .setting textarea, .media-sidebar .details .details-info .setting select, .media-sidebar .details .details-info .setting label, .media-sidebar .details .details-info .setting .button, .media-sidebar .details .details-info .setting .button-primary, .media-sidebar .details .details-info .setting .button-secondary, .media-sidebar .details .details-info .setting .button-group .button, .media-sidebar .details .details-info .setting .button-group .button-primary, .media-sidebar .details .details-info .setting .button-group .button-secondary, .media-sidebar .details .details-info .setting .button-large, .media-sidebar .details .details-info .setting .button-small, .media-sidebar .details .details-info .setting .button-link, .media-sidebar .details .details-info .setting .button-url, .media-sidebar .details .details-info .setting .button-custom, .media-sidebar .details .details-info .setting .button-upload, .media-sidebar .details .details-info .setting .button-toggle, .media-sidebar .details .details-info .setting .button-reset, .media-sidebar .details .details-info .setting .button-load, .postbox .inside, .meta-box-sortables .postbox, .stuffbox .inside {
                background-color: #ffffff;
                color: #333333;
                font-family: "宋体", "SimSun", "STSong", "宋体常规", serif;
            }

            /* 修改左侧菜单背景颜色 */
            #adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap {
                background-color: #2c3e50;
            }

            /* 修改顶部工具栏背景颜色和字体 */
            #wpadminbar {
                background-color: #34495e;
                color: #ffffff;
                font-family: "宋体", "SimSun", "STSong", "宋体常规", serif;
            }

            /* 修改左侧菜单字体颜色和样式 */
            #adminmenu a {
                color: #ecf0f1;
                font-size: 14px;
                padding: 10px 15px;
                display: block;
                font-family: "宋体", "SimSun", "STSong", "宋体常规", serif;
            }
            #adminmenu a:hover {
                color: #ffffff;
                background-color: #2980b9;
            }
            #adminmenu .wp-submenu a {
                color: #bdc3c7;
            }
            #adminmenu .wp-submenu a:hover {
                color: #ffffff;
            }
            #adminmenu .current a,
            #adminmenu .wp-has-current-submenu a.wp-has-current-submenu, 
            #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, 
            #adminmenu .wp-has-current-submenu .wp-submenu a.current {
                color: #ffffff;
                background-color: #2980b9;
            }

            /* 修改按钮样式 */
            .wp-core-ui .button-primary {
                background: #e74c3c;
                border-color: #c0392b;
                box-shadow: none;
                text-shadow: none;
                color: #ffffff;
                font-family: "宋体", "SimSun", "STSong", "宋体常规", serif;
            }
            .wp-core-ui .button-primary:hover {
                background: #c0392b;
                border-color: #a93226;
            }

            /* 修改页面标题样式 */
            .wrap h1 {
                color: #34495e;
                font-size: 24px;
                margin-bottom: 20px;
                font-family: "宋体", "SimSun", "STSong", "宋体常规", serif;
            }

            /* 修改表格样式 */
            .wp-list-table th, .wp-list-table td {
                border-color: #ddd;
                padding: 10px;
            }
            .wp-list-table th {
                background-color: #ecf0f1;
            }
            .wp-list-table tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            /* 修改链接颜色 */
            a {
                color: #3498db;
            }
            a:hover {
                color: #2980b9;
            }

            /* 修改页脚文本颜色 */
            #wpfooter {
                color: #bbb;
                text-align: center;
                padding: 10px;
            }

            /* 自定义小工具区样式 */
            .widget {
                background-color: #ecf0f1;
                border: 1px solid #ccc;
                padding: 15px;
                margin-bottom: 20px;
                font-family: "宋体", "SimSun", "STSong", "宋体常规", serif;
            }
            .widget h2 {
                color: #34495e;
                font-size: 18px;
                margin-top: 0;
            }

            /* 修改表格分页样式 */
            .tablenav .tablenav-pages a, .tablenav .tablenav-pages span {
                background-color: #ecf0f1;
                color: #34495e;
                border: 1px solid #ccc;
                padding: 5px 10px;
                margin-left: 5px;
                text-decoration: none;
            }
            .tablenav .tablenav-pages a:hover {
                background-color: #3498db;
                color: #ffffff;
            }

            /* 修改消息提示样式 */
            .notice, .update-nag {
                border-left: 4px solid #127eff;
                padding: 10px;
            }
            .notice.notice-success {
                border-left-color: #2ecc71;
            }
            .notice.notice-warning {
                border-left-color: #f1c40f;
            }
            .notice.notice-error {
                border-left-color: #e74c3c;
            }

            /* 修改用户头像样式 */
            #wpadminbar #wp-admin-bar-my-account.with-avatar > a img {
                border-radius: 50%;
                border: 2px solid #ffffff;
            }

            /* 修改媒体库样式 */
            .media-frame-content {
                background-color: #ffffff;
            }
            .media-frame-router a {
                color: #34495e;
            }
            .media-frame-router a.selected {
                color: #ffffff;
                background-color: #2980b9;
            }

            /* 自定义折叠菜单样式 */
            .folded #adminmenu, .folded #adminmenu li.menu {
                background-color: #2c3e50;
            }

            /* 自定义进度条样式 */
            .progress-bar {
                background-color: #3498db;
                height: 20px;
                border-radius: 3px;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            }

            /* 自定义提示工具样式 */
            .tooltip {
                position: relative;
                display: inline-block;
                cursor: pointer;
            }
            .tooltip .tooltiptext {
                visibility: hidden;
                width: 120px;
                background-color: #34495e;
                color: #ffffff;
                text-align: center;
                border-radius: 6px;
                padding: 5px 0;
                position: absolute;
                z-index: 1;
                bottom: 125%;
                left: 50%;
                margin-left: -60px;
                opacity: 0;
                transition: opacity 0.3s;
            }
            .tooltip:hover .tooltiptext {
                visibility: visible;
                opacity: 1;
            }
                
             
        </style>';

    // 添加 JavaScript 代码
    echo '<script>
            jQuery(document).ready(function($) {
                // 点击左侧菜单项时改变背景颜色
                $("#adminmenu a").click(function() {
                    $("#adminmenu a").css("background-color", "");
                    $(this).css("background-color", "#2980b9");
                });
            });
          </script>';
}
add_action('admin_head', 'custom_admin_styles');

function custom_login_styles() {
    echo '<style>
            body.login {
                background-color: #ffffff;
                font-family: "宋体", "SimSun", "STSong", "宋体常规", serif;
            }
            body.login form {
                background: #ffffff;
                border: 1px solid #ddd;
                padding: 26px 24px;
                box-shadow: 0 1px 3px rgba(0,0,0,.13);
                font-family: "宋体", "SimSun", "STSong", "宋体常规", serif;
            }
            body.login form .input, body.login input[type="text"], body.login input[type="password"], body.login input[type="checkbox"], body.login input[type="radio"], body.login input[type="email"], body.login input[type="url"], body.login input[type="tel"] {
                font-family: "宋体", "SimSun", "STSong", "宋体常规", serif;
            }
            body.login form .button-primary {
                background: #3498db;
                border-color: #2980b9;
                box-shadow: none;
                text-shadow: none;
                color: #ffffff;
                font-family: "宋体", "SimSun", "STSong", "宋体常规", serif;
            }
            body.login form .button-primary:hover {
                background: #2980b9;
                border-color: #1f639b;
            }
            body.login #nav a, body.login #backtoblog a {
                color: #3498db;
                font-family: "宋体", "SimSun", "STSong", "宋体常规", serif;
            }
            body.login #nav a:hover, body.login #backtoblog a:hover {
                color: #2980b9;
            }
        </style>';
}
add_action('login_head', 'custom_login_styles');

function custom_register_styles() {
    echo '<style>
            body.register {
                background-color: #ffffff;
                font-family: "宋体", "SimSun", "STSong", "宋体常规", serif;
            }
            body.register form {
                background: #ffffff;
                border: 1px solid #ddd;
                padding: 26px 24px;
                box-shadow: 0 1px 3px rgba(0,0,0,.13);
                font-family: "宋体", "SimSun", "STSong", "宋体常规", serif;
            }
            body.register form .input, body.register input[type="text"], body.register input[type="password"], body.register input[type="checkbox"], body.register input[type="radio"], body.register input[type="email"], body.register input[type="url"], body.register input[type="tel"] {
                font-family: "宋体", "SimSun", "STSong", "宋体常规", serif;
            }
            body.register form .button-primary {
                background: #3498db;
                border-color: #2980b9;
                box-shadow: none;
                text-shadow: none;
                color: #ffffff;
                font-family: "宋体", "SimSun", "STSong", "宋体常规", serif;
            }
            body.register form .button-primary:hover {
                background: #2980b9;
                border-color: #1f639b;
            }
        </style>';
}
add_action('register_head', 'custom_register_styles');



