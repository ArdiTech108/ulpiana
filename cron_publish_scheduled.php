<?php
require __DIR__ . '/db.php';

function cron_log(string $message): void {
    $line = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
    @file_put_contents(__DIR__ . '/cron.log', $line, FILE_APPEND);
}

// Lejo ekzekutim nga CLI pa çelës, ose nga web me ?key=...
$isCli = (php_sapi_name() === 'cli');
$cfg = app_config();
$secret = (string)($cfg['private_dashboard_key'] ?? '');

if (!$isCli) {
    $provided = (string)($_GET['key'] ?? '');
    if (!$secret || !$provided || !hash_equals($secret, $provided)) {
        http_response_code(401);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'message' => 'Unauthorized'], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

try {
    cron_log('Cron run started');
    $rows = db()->query("SELECT * FROM scheduled_posts WHERE status='scheduled' AND publish_at <= NOW() ORDER BY publish_at ASC LIMIT 100")->fetchAll();
    $published = 0;

    foreach ($rows as $r) {
        $ins = db()->prepare('INSERT INTO announcements (title, content, audience, created_by_user_id) VALUES (?, ?, ?, ?)');
        $ins->execute([
            $r['title'],
            $r['content'],
            $r['audience'] ?: 'all',
            $r['created_by_user_id']
        ]);

        $up = db()->prepare("UPDATE scheduled_posts SET status='published', published_at=NOW() WHERE id=?");
        $up->execute([(int)$r['id']]);
        $published++;
        cron_log('Published scheduled_post_id=' . (int)$r['id'] . ' title="' . $r['title'] . '"');
    }

    $result = ['ok' => true, 'published' => $published];
    if ($isCli) {
        echo "Published: {$published}" . PHP_EOL;
    } else {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    cron_log('Cron run finished. Published=' . $published);
} catch (Throwable $e) {
    cron_log('Cron error: ' . $e->getMessage());
    if ($isCli) {
        fwrite(STDERR, "Error: " . $e->getMessage() . PHP_EOL);
    } else {
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
}
