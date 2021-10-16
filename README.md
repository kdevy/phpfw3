# 

CallableResolverではなく、ActionResolverにして、$actionResolver->resolve()でActionInterfaceを実装したインスタンスを返すようにして、受け取り側でsetup()と__invoke()を実行すれば、シンプルでいいのでは。Slimほど汎用化する必要も特にないのでは。メイン処理のインターフェースは決めちゃっていい

dispatch()の代わり：
・main()
・handle()
・process()
・__invoke()*
