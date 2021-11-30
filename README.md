# phpfw3

色々中途半端だけど少しずつ進める。

## Memo
- フレームワーク固有クラスのテストはsrc/tests/において、tests/はアプリケーション固有クラス用のテストディレクトリにする
- フレームワーク固有の処理は別リポジトリにして、composerで読み込んだ方がいい  
フレームワークとアプリケーションは完全に切り離したいため。それにそうしないとcomposer.jsonがごちゃごちゃしちゃう。
- Containerの扱い方がピンときていない
- PHP8で使えるようになった構文で書き換える

## Directory stracture
.  
├── app  
│   ├── app.php  
│   ├── includes  
│   └── modules  
├── bin  
├── bootstrap.php  
├── composer.json  
├── composer.lock  
├── httpd.conf  
├── public  
│   ├── index.php  
│   └── static  
├── src  
├── templates  
├── tests  
├── var  
│   └── logs  
└── vendor  

### app/
アプリケーション固有の処理を実装するためのディレクトリです。フレームワークのコア処理から完全に切り離されています。

### app/app.php
アプリケーションのエントリポイントとなるファイルです。

### includes/
アプリケーション固有の定数・関数の定義をするためのディレクトリです。

### bin/
フレームワークのコマンドラインスクリプトやアプリケーションのバッチスクリプトを配置するためのディレクトリです。

### bootstrap.php
アプリケーションを利用可能にするための下準備を行うためのファイルです。ユーザが実装することはありません。任意の処理を追加したい場合はapp/app.phpに実装して下さい。

### public/
ドキュメントルートです。静的ファイル以外は置かないで下さい。

### public/index.php
存在しないファイルに対するリクエストは全てこのファイルに吸収されます。このファイルは編集しないで下さい。

### public/static/
静的ファイル（css/image/javascript等）を配置するためのディレクトリです。

### src/
フレームワークを構成するソースコードが含まれます。

### templates/
テンプレートレスポンダーを通してレンダリングされるhtmlファイルを格納するためのディレクトリです。

## 一連の流れ
基本はindex.php → bootstrap.php → app.php → ミドルウェアをトラバース → URLパスに基づいてActionを解決 → メイン処理実行してResponseインスタンスを返してemmitする。