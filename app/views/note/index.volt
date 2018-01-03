<h1>ノート作成</h1>
<hr/>
<form action="/note" method="post">
ノート名:<input type=">text" name="m_note_name" size="30" maxlength="500" id="m_note_name" value="{{ data["m_user_mail"] }}"/>{{ errormessage["m_note_name"] }}<br/>
<button type="submit">作成</button>
</form>