<h1>パスワード再登録</h1>
<hr/>
{{ dump(errormessage)}}
<form action="/signup/reset" method="post">
E-mail:{{ email }}<br/>
パスワード：<input type="password" name="pass" size="30" maxlength="500" id="pass" value="{{ data["pass"] }}"/>{{ errormessage["pass"] }}<br/>
<button type="submit">再登録</button>