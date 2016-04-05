<?php

require_once __DIR__ . '/functions.php';
require_logined_session();

header('Content-Type: text/html; charset=UTF-8');

?>
<!DOCTYPE html>
<title>会員限定ページ - <?=h(get_origin())?></title>
<h1>会員限定ページ - <?=h(get_origin())?></h1>
<p>
    ようこそ,<?=h($_SESSION['username'])?>さん<br>
    <a href="/sso-logout.php?token=<?=h(generate_token())?>">ログアウト</a>
</p>
<script>
    addEventListener('message', e => {
        // CSRF対策のため，許可したオリジン以外からのメッセージは無視する
        switch (e.origin) {
            case 'http://localhost:8080':
            case 'http://127.0.0.1:8081':
                break;
            default:
                return;
        }
        let message = JSON.parse(e.data);
        // セッションID破棄イベントを取り扱う
        if (message.operation === 'destroy-session-id') {
            document.cookie =
            document.cookie
            .split('; ')
            .filter(pair => pair.indexOf('PHPSESSID=') !== 0)
            .join('; ');
        }
    });
</script>
