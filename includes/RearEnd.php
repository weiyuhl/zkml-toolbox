<?php
namespace ZkmlHelper;

class RearEnd {
    private $settings_key = 'zkml_toolbox_settings';

    public function __construct() {
        // 初始化设置
        $this->initSettings();
        // 添加钩子
        add_action('init', [$this, 'disableLanguageDropdown']);
        add_action('admin_init', [$this, 'disableUserColorSchemes']);
        add_action('wp_before_admin_bar_render', [$this, 'removeAdminBarLogo']);
        add_action('init', [$this, 'imageRelatedHooks']);
        add_action('init', [$this, 'additionalHooks']);
        add_action('init', [$this, 'disableUpdates']);
        add_action('admin_bar_menu', [$this, 'removeAdminToolbarLinks'], 999);
        add_action('admin_head', [$this, 'remove_admin_help_tab']);
    }

    private function initSettings() {
        // 如果设置不存在，则初始化默认值
        if (get_option($this->settings_key) === false) {
            $default_settings = [
                'zkml_disable_language_dropdown' => 0,
                'zkml_disable_user_color_schemes' => 0,
                'zkml_remove_admin_bar_logo' => 0,
                'zkml_disable_image_height_limit' => 0,
                'zkml_disable_image_sizes' => 0,
                'zkml_disable_image_multiple_sizes' => 0,
                'zkml_disable_image_pixel_ratio_scaling' => 0,
                'zkml_disable_image_attributes' => 0,
                'zkml_disable_post_revisions' => 0,
                'zkml_disable_autosave' => 0,
                'zkml_classic_editor' => 0,
                'zkml_classic_widgets' => 0,
                'zkml_close_core_update' => 0,
                'zkml_remove_admin_toolbar_links' => 0,
                'zkml_disable_help_tab' => 0,
            ];
            add_option($this->settings_key, $default_settings);
        }
    }

    public function getSettings() {
        return get_option($this->settings_key);
    }

    public function updateSettings(
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
        $disable_help_tab
    ) {
        $settings = [
            'zkml_disable_language_dropdown' => $disable_language_dropdown,
            'zkml_disable_user_color_schemes' => $disable_user_color_schemes,
            'zkml_remove_admin_bar_logo' => $remove_admin_bar_logo,
            'zkml_disable_image_height_limit' => $disable_image_height_limit,
            'zkml_disable_image_sizes' => $disable_image_sizes,
            'zkml_disable_image_multiple_sizes' => $disable_image_multiple_sizes,
            'zkml_disable_image_pixel_ratio_scaling' => $disable_image_pixel_ratio_scaling,
            'zkml_disable_image_attributes' => $disable_image_attributes,
            'zkml_disable_post_revisions' => $disable_post_revisions,
            'zkml_disable_autosave' => $disable_autosave,
            'zkml_classic_editor' => $classic_editor,
            'zkml_classic_widgets' => $classic_widgets,
            'zkml_close_core_update' => $close_core_update,
            'zkml_remove_admin_toolbar_links' => $remove_admin_toolbar_links,
            'zkml_disable_help_tab' => $disable_help_tab,
        ];
        update_option($this->settings_key, $settings);
    }

    public function disableUpdates() {
        $settings = $this->getSettings();
        if (isset($settings['zkml_close_core_update']) && $settings['zkml_close_core_update']) {
            // 禁用核心更新
            add_filter('automatic_updater_disabled', '__return_true');
            remove_action('init', 'wp_schedule_update_checks');
            wp_clear_scheduled_hook('wp_version_check');
            wp_clear_scheduled_hook('wp_maybe_auto_update');
            remove_action('admin_init', '_maybe_update_core');
            add_filter('pre_site_transient_update_core', function ($a) {
                return null;
            });
        }
    }

    public function disableLanguageDropdown() {
        $settings = $this->getSettings();
        if (isset($settings['zkml_disable_language_dropdown']) && $settings['zkml_disable_language_dropdown']) {
            add_filter('login_display_language_dropdown', '__return_false');
        }
    }

    public function disableUserColorSchemes() {
        $settings = $this->getSettings();
        if (isset($settings['zkml_disable_user_color_schemes']) && $settings['zkml_disable_user_color_schemes']) {
            remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
        }
    }

    public function removeAdminBarLogo() {
        $settings = $this->getSettings();
        if (isset($settings['zkml_remove_admin_bar_logo']) && $settings['zkml_remove_admin_bar_logo']) {
            global $wp_admin_bar;
            $wp_admin_bar->remove_node('wp-logo');
        }
    }

    public function imageRelatedHooks() {
        $settings = $this->getSettings();
        if (isset($settings['zkml_disable_image_height_limit']) && $settings['zkml_disable_image_height_limit']) {
            add_filter('big_image_size_threshold', '__return_false');
        }
        if (isset($settings['zkml_disable_image_sizes']) && $settings['zkml_disable_image_sizes']) {
            remove_image_size('medium');
            remove_image_size('large');
            remove_image_size('medium_large');
            remove_image_size('1536x1536');
            remove_image_size('2048x2048');
        }
        if (isset($settings['zkml_disable_image_multiple_sizes']) && $settings['zkml_disable_image_multiple_sizes']) {
            add_filter('intermediate_image_sizes_advanced', function($sizes) {
                return [];
            });
        }
        if (isset($settings['zkml_disable_image_pixel_ratio_scaling']) && $settings['zkml_disable_image_pixel_ratio_scaling']) {
            add_filter('wp_calculate_image_srcset', '__return_false');
        }
        if (isset($settings['zkml_disable_image_attributes']) && $settings['zkml_disable_image_attributes']) {
            add_filter('wp_get_attachment_image_attributes', function($attr) {
                if (isset($attr['sizes'])) {
                    unset($attr['sizes']);
                }
                if (isset($attr['srcset'])) {
                    unset($attr['srcset']);
                }
                return $attr;
            }, 10, 1);
        }
    }

    public function additionalHooks() {
        $settings = $this->getSettings();
        if (isset($settings['zkml_disable_post_revisions']) && $settings['zkml_disable_post_revisions']) {
            add_filter('wp_revisions_to_keep', '__return_false');
        }
        if (isset($settings['zkml_disable_autosave']) && $settings['zkml_disable_autosave']) {
            add_action('wp_print_scripts', function() {
                wp_deregister_script('autosave');
            });
        }
        if (isset($settings['zkml_classic_editor']) && $settings['zkml_classic_editor']) {
            add_filter('use_block_editor_for_post', '__return_false', 10);
        }
        if (isset($settings['zkml_classic_widgets']) && $settings['zkml_classic_widgets']) {
            add_filter('use_widgets_block_editor', '__return_false');
        }
    }

    public function removeAdminToolbarLinks($wp_admin_bar) {
        $settings = $this->getSettings();
        if (isset($settings['zkml_remove_admin_toolbar_links']) && $settings['zkml_remove_admin_toolbar_links']) {
            // 移除快速操作菜单中的站点名称
            $wp_admin_bar->remove_menu('site-name');
            // 例如，移除“新建”按钮
            $wp_admin_bar->remove_node('new-content');
            // 移除评论按钮
            $wp_admin_bar->remove_node('comments');
        }
    }

    // 移除后台帮助选项
    public function remove_admin_help_tab() {
        $settings = $this->getSettings();
        if (isset($settings['zkml_disable_help_tab']) && $settings['zkml_disable_help_tab']) {
            $screen = get_current_screen();
            if ($screen) {
                $screen->remove_help_tabs();
            }
        }
    }

}