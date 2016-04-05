<?php

require_once __DIR__ . '/functions.php';
require_unlogined_session();

// 事前に生成したユーザごとのパスワードハッシュの配列
$hashes = [
    'username' => '$2y$10$5oJchTrDqSp7L9PsZ.WxPOHw7f7YAjpiUbQvRNKMb2tNPcBfl.CMu',
];

// ユーザから受け取ったユーザ名とパスワード
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

// POSTメソッドのときのみ実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        validate_token(filter_input(INPUT_POST, 'token')) &&
        password_verify(
            $password,
            isset($hashes[$username])
                ? $hashes[$username]
                : '$2y$10$abcdefghijklmnopqrstuv' // ユーザ名が存在しないときだけ極端に速くなるのを防ぐ
        )
    ) {
        // 認証が成功したとき
        // セッションIDの追跡を防ぐ
        session_regenerate_id(true);
        // ユーザ名をセット
        $_SESSION['username'] = $username;
        // ログイン完了後に /sso-login.php にCSRFトークンつきで遷移
        header('Location: /sso-login.php?token=' . urlencode(generate_token()));
        exit;
    }
    // 認証が失敗したとき
    // 「403 Forbidden」
    http_response_code(403);
}

header('Content-Type: text/html; charset=UTF-8');

?>
<!DOCTYPE html>
<title>ログインページ - <?=h(get_origin())?></title>
<h1>ログインページ - <?=h(get_origin())?></h1>
<form method="post" action="">
    ユーザ名: <input type="text" name="username" value="">
    パスワード: <input type="password" name="password" value="">
    <input type="hidden" name="token" value="<?=h(generate_token())?>">
    <input type="submit" value="ログイン">
</form>
<?php if (http_response_code() === 403): ?>
<p style="color: red;">ユーザ名またはパスワードが違います</p>
<?php endif; ?>
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
        // セッションID上書きイベントを取り扱う
        if (e.data.operation === 'overwrite-session-id') {
            document.cookie =
            document.cookie
            .split('; ')
            .map(pair =>
                pair.indexOf('PHPSESSID=') === 0
                ? 'PHPSESSID=' + e.data.value
                : pair
            ).join('; ');
        }
    });
</script>
