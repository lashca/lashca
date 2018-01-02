<h1>仮登録</h1>
<hr/>
<form action="/signup" method="post">
E-mail:<input type="text" name="m_semiuser_mail" size="30" maxlength="500" id="m_semiuser_mail" value="<?= $data['m_semiuser_mail'] ?>"/><?= $errormessage['m_semiuser_mail'] ?><br/>
<button type="submit">仮登録</button>
</form>