<h1><?= $m_note_name ?></h1>
<?= $__FILE__ ?>
<hr/>
<a href="/note/page">問題作成</a><br/>
<hr/>

<?php $prev_no = 0; ?>
<?php $choosable_count = 0; ?>
<?php foreach ($pages as $page) { ?>
    
    <?php if ($page->m_page_type == 1) { ?>
        <div style="float:left;border: 1px solid #000000;"><a href="/note/page/<?= $page->m_page_no ?>">
            <?php if ($page->m_basic_reverse_flag == 0) { ?>
            問題文：<?= $page->m_basic_word ?><br/>
            解答：<?= $page->m_basic_description ?>
            <?php } else { ?>
            単語：<?= $page->m_basic_word ?><br/>
            説明文：<?= $page->m_basic_description ?>
            <?php } ?>
        </a></div>
    <?php } elseif ($page->m_page_type == 2) { ?>
        <?php $choosable_count += 1; ?>
        <?php if ($prev_no != $page->m_page_no) { ?>
            <div style="float:left;border: 1px solid #000000;"><a href="/note/page/<?= $page->m_page_no ?>">
                問題文：<?= $page->m_choosable_sentence ?><br/>
            <?php $prev_no = $page->m_page_no; ?>
        <?php } ?>
        選択肢<?= $choosable_count ?>：<?= $page->m_selection_text ?><br/>
        <?php if ($choosable_count == $page->m_choosable_selection_count) { ?>
            </a></div>
            <?php $choosable_count = 0; ?>
        <?php } ?>
    <?php } ?>
<?php } ?>
<div style="clear:both;"/>