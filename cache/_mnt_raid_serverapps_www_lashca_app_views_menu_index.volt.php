<h1>メニュー</h1>
<hr/>
<a href="/menu/user">ユーザ情報</a><br/>
<a href="/note/buy">ノート購入</a><br/>
<a href="/note/">ノート作成</a><br/>
<a href="/menu/logout">ログアウト</a><br/>
<hr/>
<a href="/note/edit">ノート名変更</a><br/>
<a href="/note/delete">ノート削除</a><br/>
<hr/>
<?php $prevcategory = ''; ?>
<?php foreach ($holdingnotes as $note) { ?>
<?php if ($prevcategory != $note->m_notecategory_name) { ?>
<h2><?= $note->m_notecategory_name ?></h2>
<?php $prevcategory = $note->m_notecategory_name; ?>
<?php } ?>
<a href="/note/detail/<?= $note->m_holdingnote_no ?>"><?= $note->m_note_name ?></a><br/>
<?php } ?>