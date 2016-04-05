<?php

require_once __DIR__ . '/functions.php';
require_logined_session();

// CSRFトークンを検証
if (!validate_token(filter_input(INPUT_GET, 'token'))) {
    // 「400 Bad Request」
    header('Content-Type: text/plain; charset=UTF-8', true, 400);
    exit('トークンが無効です');
}

header('Content-Type: text/html; charset=UTF-8');

?>
<!DOCTYPE html>
<title>ログインしています</title>
<h1>ログインしています</h1>
<form target="ifr0" method="get" action="http://localhost:8080/login.php"></form>
<form target="ifr1" method="get" action="http://127.0.0.1:8081/login.php"></form>
<iframe name="ifr0" style="visibility: hidden;" data-origin="http://localhost:8080"></iframe>
<iframe name="ifr1" style="visibility: hidden;" data-origin="http://127.0.0.1:8081"></iframe>
<p>
    JavaScriptが無効の場合は<a href="/">こちら</a>をクリックしてください．<br>
    その場合，シングルサインオンはご利用いただけません．
</p>
<script>
    addEventListener('DOMContentLoaded', () => {
        // DOMを読み込み終わるまで待ってから実行

        Promise.all(
            // 全てのiframeに対して適用
            Array
            .from(document.querySelectorAll('iframe'))
            .map(iframe => {
                // ログイン済みのセッションIDをPHPから受け取る
                let id = <?=json_encode(session_id())?>;
                // メッセージを定義
                let message = {
                    operation: 'overwrite-session-id',
                    value: id,
                };
                return new Promise(r => iframe.addEventListener('load', r))
                // iframeを読み込み終わるまで待ってから実行
                .then(() => iframe.contentWindow.postMessage(message, iframe.dataset.origin));
            })
        )
        // 全てのiframeに対してメッセージを送信し終えてから実行
        .then(() => location.replace('/'))
        .catch(e => console.error(e));

        // 全てのformからiframeに対して送信
        Array
        .from(document.querySelectorAll('form'))
        .forEach(form => form.submit());

    });
</script>
