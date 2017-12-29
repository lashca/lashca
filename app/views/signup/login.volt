<h1>ログイン</h1>
<hr/>
<form action="login" method="post">
E-mail:<input type="text" name="m_user_mail" size="30" maxlength="500" id="m_user_mail" value="{{data['m_user_mail']}}"/><br/>
パスワード:<input type="password" name="pass" size="30" maxlength="500" id="pass" value="{{data['pass']}}"/><br/>
{{errormessage}}<br/>
<button type="submit">ログイン</button>
</form>
パスワードを忘れた方は<a href="/signup/forgot">こちら</a>