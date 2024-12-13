<?php
/**
 * Output the Database Optimizer management page content.
 */
function zkml_Db_Optimizer_page_content() {
    if (!current_user_can('manage_options')) {
        return;
    }

    global $wpdb;

    // 实例化 DbOptimizer 类
    $dbOptimizer = new \ZkmlHelper\DbOptimizer($wpdb);

    if (isset($_POST['clear_auto_drafts'])) {
        if (wp_verify_nonce($_POST['clear_auto_drafts_nonce'], 'clear_auto_drafts_action')) {
            $dbOptimizer->clearAutoDrafts();
            echo '<div class="updated"><p>自动草稿已清理。</p></div>';
        }
    }

    if (isset($_POST['clear_trash_comments'])) {
        if (wp_verify_nonce($_POST['clear_trash_comments_nonce'], 'clear_trash_comments_action')) {
            $dbOptimizer->clearTrashComments();
            echo '<div class="updated"><p>回收站评论已清理。</p></div>';
        }
    }

    if (isset($_POST['optimize_database_tables'])) {
        if (wp_verify_nonce($_POST['optimize_database_tables_nonce'], 'optimize_database_tables_action')) {
            $optimize_results = $dbOptimizer->optimizeDatabaseTables();
            echo '<div class="updated"><p>数据库表已优化。</p></div>';

            // 显示优化结果
            echo '<h3>数据库表优化结果</h3>';
            echo '<ul>';
            foreach ($optimize_results as $result) {
                echo '<li>' . esc_html($result['table']) . ': ' . esc_html($result['result']) . '</li>';
            }
            echo '</ul>';
        }
    }

    // 获取统计数据
    $auto_drafts_stats = $dbOptimizer->getAllAutoDraftsStats();
    $trash_comments_stats = $dbOptimizer->getTrashCommentsStats();

    ?>
    <div class="wrap">
        <h1>数据库管理</h1>

        <hr>

        <h2>自动草稿统计</h2>
        <p>自动草稿数量: <?php echo $auto_drafts_stats['count']; ?></p>
        <p>自动草稿总大小: <?php echo $auto_drafts_stats['size']; ?></p>

        <form method="post" action="">
            <p>
                <input type="submit" name="clear_auto_drafts" class="button button-primary" value="清理自动草稿">
                <?php wp_nonce_field('clear_auto_drafts_action', 'clear_auto_drafts_nonce'); ?>
            </p>
        </form>

        <h2>回收站评论统计</h2>
        <p>回收站评论数量: <?php echo $trash_comments_stats['count']; ?></p>

        <form method="post" action="">
            <p>
                <input type="submit" name="clear_trash_comments" class="button button-primary" value="清理回收站评论">
                <?php wp_nonce_field('clear_trash_comments_action', 'clear_trash_comments_nonce'); ?>
            </p>
        </form>

        <h2>数据库表优化</h2>
        <form method="post" action="">
            <p>
                <input type="submit" name="optimize_database_tables" class="button button-primary" value="优化数据库表">
                <?php wp_nonce_field('optimize_database_tables_action', 'optimize_database_tables_nonce'); ?>
            </p>
        </form>
    </div>
    <?php
}

// 输出管理页面内容
zkml_Db_Optimizer_page_content();