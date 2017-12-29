var webPage = require ( 'webpage' ) ;
var page = webPage.create ( ) ;
 
// 出力文字コードをShift-JISに設定
phantom.outputEncoding = 'sjis' ;
 
// 弊社のウェブサイト
var strURL = 'http://www.clara.ad.jp' ;
 
// ページを開く
page.open ( strURL , function ( status ) {
    if ( status !== 'success' ) {
        // 失敗した場合
        console.log ( 'Unable to access website!' ) ;
    }
    else {
        // 成功すれば、ページの内容を表示する
        console.log ( page.content ) ;
    }
    // phantomJSを停止する
    phantom.exit ( ) ;
} ) ;