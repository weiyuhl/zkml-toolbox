<?php
/**
 * Zkml Helper Class for Cache and Auto Draft Cleaner Plugin.
 */

namespace ZkmlHelper;

if (!defined('ABSPATH')) {
    exit;
}

class DbOptimizer {
    private $wpdb;

    public function __construct($wpdb) {
        $this->wpdb = $wpdb;
    }

    public function getAllAutoDraftsStats() {
        $autoDrafts = $this->wpdb->get_results($this->wpdb->prepare("
            SELECT ID, post_modified
            FROM {$this->wpdb->posts}
            WHERE post_status = %s
        ", 'auto-draft'));

        $draftCount = 0;
        $draftSize = 0;

        foreach ($autoDrafts as $draft) {
            $draftSize += strlen(serialize($draft));
            $draftCount++;
        }

        return [
            'count' => $draftCount,
            'size' => size_format($draftSize),
            'auto_drafts' => $autoDrafts,
        ];
    }

    public function clearAutoDrafts() {
        $autoDrafts = $this->wpdb->get_results($this->wpdb->prepare("
            SELECT ID FROM {$this->wpdb->posts}
            WHERE post_status = %s
        ", 'auto-draft'));

        foreach ($autoDrafts as $draft) {
            wp_delete_post($draft->ID, true);
        }
    }

    public function getTrashCommentsStats() {
        $trashComments = $this->wpdb->get_results("
            SELECT comment_ID, comment_post_ID, comment_author, comment_date
            FROM {$this->wpdb->comments}
            WHERE comment_approved = 'trash'
        ");

        $trashCount = count($trashComments);

        return [
            'count' => $trashCount,
            'trash_comments' => $trashComments,
        ];
    }

    public function clearTrashComments() {
        $trashComments = $this->wpdb->get_results("
            SELECT comment_ID
            FROM {$this->wpdb->comments}
            WHERE comment_approved = 'trash'
        ");

        foreach ($trashComments as $comment) {
            wp_delete_comment($comment->comment_ID, true);
        }
    }

    public function optimizeDatabaseTables() {
        $optimizeResults = [];

        $tables = $this->wpdb->get_results("SHOW TABLES");

        foreach ($tables as $table) {
            $tableName = reset($table);

            $result = $this->wpdb->query("OPTIMIZE TABLE $tableName");

            $optimizeResults[] = [
                'table' => $tableName,
                'result' => $result !== false ? '优化成功' : '优化失败',
            ];
        }

        return $optimizeResults;
    }
}
