<h1><?= $note->m_note_name ?></h1>
<hr/>
<?= $path ?>
問題数：<?= $note->pagecount ?><br/>
習得レベル：<?= $note->masterylevel ?><br/>
最終学習日：<?= $note->learneddate ?><br/>
<hr/>
<a href="/learning/">学習開始</a><br/>
<a href="/note/edit">問題編集</a><br/>