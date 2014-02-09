Hanauta
=======

phpでオレ様ライブラリ。
ハナウタ君を乗せて♪

=======

Hanauta基本クラス内呼び出しは以下です。
$Hanauta->obj["hogeclass"]->hogefunction();

プロジェクト毎クラス内呼び出しは以下です。
プロジェクト設定ファイルのextend.iniで呼び出し設定した上で
$Hanauta->obj_ext["hogeclass"]->hogefunction();

基本クラスにしても自前クラスにしても設定ファイルで呼ぶ呼ばない選んで使えます。
不要な時はコメントアウト。

=======

特に同梱させてないですが一緒によく使うライブラリとか。

・テンプレはSmartyです。

・大体pearいれてます。

・エラーハンドラは以下のを使ってます。
PHP5でSTRICT有効でPEARを使う（NOTICE、STRICTをあやつる） - gounx2の日記
http://d.hatena.ne.jp/gounx2/20071112/1194878765

・htmlパーサーは以下のを使ってます。
PHP Simple HTML DOM Parser
http://sourceforge.net/projects/simplehtmldom/

