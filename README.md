# phpfw3

## Directory
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
存在しないファイルに対するリクエストは全てこのファイルに巻き取られます。

### public/static/
静的ファイルを配置するためのディレクトリです。

### src/
フレームワークを構成するソースコードが含まれます。（別リポジトリとして分離する予定です（phpfw3-lib））

### templates/
TemplateResponderを通してレンダリングされるhtmlファイルを格納するためのディレクトリです。

## 一連の流れ
基本はindex.php → bootstrap.php → app.php → ミドルウェアをトラバース → URLパスに基づいてActionを解決 → メイン処理実行してResponseインスタンスを返してemmitする。  
場合によってTemplateResponderでResponseインスタンスを作成したり、ミドルウェアが処理を捕縛したりする。
