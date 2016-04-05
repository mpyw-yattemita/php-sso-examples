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
        // CSRF対策
        if (!/^http:\/\/localhost:808[56]$/.test(e.origin)) return;
        let message = JSON.parse(e.data);
        if (message.operation === 'overwrite-session-id') {
            // Cookie上書きイベントの場合
            document.cookie =
            document.cookie
            .split('; ')
            .map(pair =>
                pair.indexOf('PHPSESSID=') === 0
                ? 'PHPSESSID=' + message.value
                : pair
            ).join('; ');
        } else if (message.operation === 'destroy-session-id') {
            // Cookie破棄イベントの場合
            document.cookie =
            document.cookie
            .split('; ')
            .filter(pair => pair.indexOf('PHPSESSID=') !== 0)
            .join('; ');
        }
    });
</script>
