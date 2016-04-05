# PHPでクロスオリジンなシングルサインオン認証

[こちら]()の記事で解説している内容の実装です．

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

- [http://localhost:8085/](http://localhost:8085/)
- [http://localhost:8086/](http://localhost:8086/)
