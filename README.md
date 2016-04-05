# PHP+JavaScriptでクロスオリジンなシングルサインオン認証

[こちら](http://qiita.com/mpyw/items/904d0692b4594265dbd4)の記事で解説している内容の実装です．

|ユーザ名|パスワード|
|:---:|:---:|
|`username`|`password`|

## 基本的な使い方

```ShellSession
mpyw@localhost:~$ git clone git@github.com:mpyw/php-sso-examples.git
mpyw@localhost:~$ cd php-sso-examples
mpyw@localhost:~/php-sso-examples$ ./run.sh
```

この状態でWebブラウザから以下のURLに，それぞれ別のウィンドウでアクセスして検証してください．

- [http://localhost:8080/](http://localhost:8080/)
- [http://127.0.0.1:8081/](http://127.0.0.1:8081/)
