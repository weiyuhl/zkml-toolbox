<?php
// 获取插件的绝对路径
$plugin_dir = plugin_dir_path(__FILE__);

// 包含 RearEnd 类文件
require_once $plugin_dir . '../includes/RearEnd.php';

use ZkmlHelper\RearEnd;

// 实例化 RearEnd 类
$rearEnd = new RearEnd();

// 检查用户权限，如果没有管理选项的权限则直接返回
if ( ! current_user_can( 'manage_options' ) ) {
    return;
}

// 处理表单提交
if ( isset( $_POST['zkml_save_settings'] ) ) {
    $disable_language_dropdown = isset( $_POST['zkml_disable_language_dropdown'] ) ? 1 : 0;
    $disable_user_color_schemes = isset( $_POST['zkml_disable_user_color_schemes'] ) ? 1 : 0;
    $remove_admin_bar_logo = isset( $_POST['zkml_remove_admin_bar_logo'] ) ? 1 : 0;
    $disable_image_height_limit = isset( $_POST['zkml_disable_image_height_limit'] ) ? 1 : 0;
    $disable_image_sizes = isset( $_POST['zkml_disable_image_sizes'] ) ? 1 : 0;
    $disable_image_multiple_sizes = isset( $_POST['zkml_disable_image_multiple_sizes'] ) ? 1 : 0;
    $disable_image_pixel_ratio_scaling = isset( $_POST['zkml_disable_image_pixel_ratio_scaling'] ) ? 1 : 0;
    $disable_image_attributes = isset( $_POST['zkml_disable_image_attributes'] ) ? 1 : 0;
    $disable_post_revisions = isset( $_POST['zkml_disable_post_revisions'] ) ? 1 : 0;
    $disable_autosave = isset( $_POST['zkml_disable_autosave'] ) ? 1 : 0;
    $classic_editor = isset( $_POST['zkml_classic_editor'] ) ? 1 : 0;
    $classic_widgets = isset( $_POST['zkml_classic_widgets'] ) ? 1 : 0;
    $close_core_update = isset( $_POST['zkml_close_core_update'] ) ? 1 : 0;
    $remove_admin_toolbar_links = isset( $_POST['zkml_remove_admin_toolbar_links'] ) ? 1 : 0;
    
    $disable_help_tab = isset( $_POST['zkml_disable_help_tab'] ) ? 1 : 0;
        

    $rearEnd->updateSettings(
        $disable_language_dropdown,
        $disable_user_color_schemes,
        $remove_admin_bar_logo,
        $disable_image_height_limit,
        $disable_image_sizes,
        $disable_image_multiple_sizes,
        $disable_image_pixel_ratio_scaling,
        $disable_image_attributes,
        $disable_post_revisions,
        $disable_autosave,
        $classic_editor,
        $classic_widgets,
        $close_core_update,
        $remove_admin_toolbar_links,
        $disable_help_tab,
    );

    // 显示设置已保存的提示
    echo '<div class="updated"><p>设置已保存。</p></div>';
}

// 获取选项的当前值
$settings = $rearEnd->getSettings();
$disable_language_dropdown = isset($settings['zkml_disable_language_dropdown']) ? $settings['zkml_disable_language_dropdown'] : 0;
$disable_user_color_schemes = isset($settings['zkml_disable_user_color_schemes']) ? $settings['zkml_disable_user_color_schemes'] : 0;
$remove_admin_bar_logo = isset($settings['zkml_remove_admin_bar_logo']) ? $settings['zkml_remove_admin_bar_logo'] : 0;
$disable_image_height_limit = isset($settings['zkml_disable_image_height_limit']) ? $settings['zkml_disable_image_height_limit'] : 0;
$disable_image_sizes = isset($settings['zkml_disable_image_sizes']) ? $settings['zkml_disable_image_sizes'] : 0;
$disable_image_multiple_sizes = isset($settings['zkml_disable_image_multiple_sizes']) ? $settings['zkml_disable_image_multiple_sizes'] : 0;
$disable_image_pixel_ratio_scaling = isset($settings['zkml_disable_image_pixel_ratio_scaling']) ? $settings['zkml_disable_image_pixel_ratio_scaling'] : 0;
$disable_image_attributes = isset($settings['zkml_disable_image_attributes']) ? $settings['zkml_disable_image_attributes'] : 0;
$disable_post_revisions = isset($settings['zkml_disable_post_revisions']) ? $settings['zkml_disable_post_revisions'] :
$disable_post_revisions = isset($settings['zkml_disable_post_revisions']) ? $settings['zkml_disable_post_revisions'] : 0;
$disable_autosave = isset($settings['zkml_disable_autosave']) ? $settings['zkml_disable_autosave'] : 0;
$classic_editor = isset($settings['zkml_classic_editor']) ? $settings['zkml_classic_editor'] : 0;
$classic_widgets = isset($settings['zkml_classic_widgets']) ? $settings['zkml_classic_widgets'] : 0;
$close_core_update = isset($settings['zkml_close_core_update']) ? $settings['zkml_close_core_update'] : 0;

$remove_admin_toolbar_links = isset($settings['zkml_remove_admin_toolbar_links']) ? $settings['zkml_remove_admin_toolbar_links'] : 0;

$disable_help_tab = isset($settings['zkml_disable_help_tab']) ? $settings['zkml_disable_help_tab'] : 0;

?>

<div class="wrap">
    <h1>插件设置</h1>
    <form method="post" action="">
        <table class="form-table">
            <tr>
                <th scope="row">禁用核心更新</th>
                <td>
                    <input type="checkbox" name="zkml_close_core_update" value="1" <?php checked($close_core_update, 1); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">禁用语言选择下拉菜单</th>
                <td>
                    <input type="checkbox" name="zkml_disable_language_dropdown" value="1" <?php checked($disable_language_dropdown, 1); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">禁用用户颜色方案</th>
                <td>
                    <input type="checkbox" name="zkml_disable_user_color_schemes" value="1"                     <?php checked($disable_user_color_schemes, 1); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">移除管理栏Logo</th>
                <td>
                    <input type="checkbox" name="zkml_remove_admin_bar_logo" value="1" <?php checked($remove_admin_bar_logo, 1); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">禁用图像高度限制</th>
                <td>
                    <input type="checkbox" name="zkml_disable_image_height_limit" value="1" <?php checked($disable_image_height_limit, 1); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">禁用图像尺寸</th>
                <td>
                    <input type="checkbox" name="zkml_disable_image_sizes" value="1" <?php checked($disable_image_sizes, 1); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">禁用图像多尺寸</th>
                <td>
                    <input type="checkbox" name="zkml_disable_image_multiple_sizes" value="1" <?php checked($disable_image_multiple_sizes, 1); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">禁用图像像素比例缩放</th>
                <td>
                    <input type="checkbox" name="zkml_disable_image_pixel_ratio_scaling" value="1" <?php checked($disable_image_pixel_ratio_scaling, 1); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">禁用图像属性</th>
                <td>
                    <input type="checkbox" name="zkml_disable_image_attributes" value="1" <?php checked($disable_image_attributes, 1); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">禁用文章修订版</th>
                <td>
                    <input type="checkbox" name="zkml_disable_post_revisions" value="1" <?php checked($disable_post_revisions, 1); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">禁用自动保存</th>
                <td>
                    <input type="checkbox" name="zkml_disable_autosave" value="1" <?php checked($disable_autosave, 1); ?> />
                                    </td>
            </tr>
            <tr>
                <th scope="row">启用经典编辑器</th>
                <td>
                    <input type="checkbox" name="zkml_classic_editor" value="1" <?php checked($classic_editor, 1); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">启用经典小工具</th>
                <td>
                    <input type="checkbox" name="zkml_classic_widgets" value="1" <?php checked($classic_widgets, 1); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">清理顶部导航栏</th>
                <td>
                    <input type="checkbox" name="zkml_remove_admin_toolbar_links" value="1" <?php checked($remove_admin_toolbar_links, 1); ?> />
                </td>
            </tr>

            <tr>
                <th scope="row">移除后台界面右上角的帮助</th>
                <td>
                    <input type="checkbox" name="zkml_disable_help_tab" value="1" <?php checked($disable_help_tab, 1); ?> />
                </td>
            </tr>

        </table>
        <p class="submit">
            <input type="submit" name="zkml_save_settings" class="button-primary" value="保存设置" />
        </p>
    </form>
</div>


