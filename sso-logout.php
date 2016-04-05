<?php

require_once __DIR__ . '/functions.php';
require_logined_session();

// CSRFトークンを検証
if (!validate_token(filter_input(INPUT_GET, 'token'))) {
    // 「400 Bad Request」
    header('Content-Type: text/plain; charset=UTF-8', true, 400);
    exit('トークンが無効です');
}

// セッションファイルの破棄
session_destroy();

header('Content-Type: text/html; charset=UTF-8');

?>
<!DOCTYPE html>
<title>ログアウトしました</title>
<h1>ログアウトしました</h1>
<iframe src="http://localhost:8085/" style="visibility: hidden;"></iframe>
<iframe src="http://localhost:8086/" style="visibility: hidden;"></iframe>
<p>
    JavaScriptが無効の場合は<a href="/">こちら</a>をクリックしてください．
</p>
<script>
    // 全オリジンに対してCookie破棄イベントを発行
    Array
    .from(document.querySelectorAll('iframe'))
    .map(e => {
        let a = document.createElement('a');
        a.href = e.src;
        let message = {
            operation: 'destroy-session-id'
        };
        e.contentWindow.postMessage(JSON.stringify(message), a.origin);
    });
    // ページ遷移 (履歴に残さない)
    window.location = '/';
</script>
