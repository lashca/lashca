<h1>ユーザ情報</h1>
<hr/>
<form action="/menu/user" method="post">
E-mail:<input type=">text" name="m_user_mail" size="30" maxlength="500" id="m_user_mail" value="<?= $data['m_user_mail'] ?>"/><?= $errormessage['m_user_mail'] ?><br/>
お名前：姓<input type=">text" name="m_user_lastname" size="30" maxlength="500" id="m_user_lastname" value="<?= $data['m_user_lastname'] ?>"/>名<input type="text" name="m_user_firstname" size="30" maxlength="500" id="m_user_firstname" value="<?= $data['m_user_firstname'] ?>"/><?= $errormessage['m_user_name'] ?><br/>
性別：<select name="m_user_sex" id="m_user_sex"><option value="0">男</option><option value="1">女</option></select><?= $errormessage['m_user_sex'] ?><br/>
生年月日：<select name="m_user_birthday_year" id="year"><option value="">----</option></select>年
<select name="m_user_birthday_month" id="month"><option value="">--</option></select>月
<select name="m_user_birthday_day" id="day"><option value="">--</option></select>日
<?= $errormessage['m_user_birthday'] ?><br/>
パスワード：<input type="password" name="pass" size="30" maxlength="500" id="pass" value="<?= $data['pass'] ?>"/><?= $errormessage['pass'] ?><br/>
<button type="submit">登録変更</button>
<script type="text/javascript">
    var y = <?= $data['m_user_birthday_year'] ?>;
    var m = <?= $data['m_user_birthday_month'] ?>;
    var d = <?= $data['m_user_birthday_day'] ?>;    
</script>  
<script src="/js/date.js"></script>
</form>