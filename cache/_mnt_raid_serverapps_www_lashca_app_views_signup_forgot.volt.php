<h1>パスワード再登録依頼</h1>
<hr/>
<form action="/signup/forgot" method="post">
E-mail:<input type="text" name="m_forgotuser_mail" size="30" maxlength="500" id="m_forgotuser_mail" value="<?= $data['m_forgotuser_mail'] ?>"/><?= $errormessage['m_forgotuser_mail'] ?><br/>
<button type="submit">再登録</button>
</form>