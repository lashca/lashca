<h1>{{m_note_name}}</h1>
<hr/>
<style>
.ChangeElem_Panel{
  display: none;
}
</style>


出題区分：
<div class="ChangeElem_Btn_Content">
<button class="ChangeElem_Btn">通常出題</button>
<button class="ChangeElem_Btn">単語暗記</button>
<button class="ChangeElem_Btn">択一式</button>
</div>
<ul>
<li class="ChangeElem_Panel">
<form action="/note/page" method="post">
    問題文：<input type="text" name="m_basic_word" size="30" maxlength="500" id="m_basic_word1" value="{{ data["m_basic_word"] }}"/>{{ errormessage["m_basic_word"] }}<br/>
    解答：<input type="text" name="m_basic_description" size="30" maxlength="500" id="m_basic_description1" value="{{ data["m_basic_description"] }}"/>{{ errormessage["m_basic_description"] }}<br/>
    <input type="hidden" name="startpos" value="0"/>
    <input type="hidden" name="m_page_type" value="1"/>
    <input type="hidden" name="m_basic_reverse_flag" value="0"/>
    <button type="submit">登録</button>
</form>
</li>
<li class="ChangeElem_Panel">
<form action="/note/page" method="post">
    単語：<input type="text" name="m_basic_word" size="30" maxlength="500" id="m_basic_word2" value="{{ data["m_basic_word"] }}"/>{{ errormessage["m_basic_word"] }}<br/>
    説明文：<input type="text" name="m_basic_description" size="30" maxlength="500" id="m_basic_description2" value="{{ data["m_basic_description"] }}"/>{{ errormessage["m_basic_description"] }}<br/>
    <input type="hidden" name="startpos" value="1"/>
    <input type="hidden" name="m_page_type" value="1"/>
    <input type="hidden" name="m_basic_reverse_flag" value="1"/>
    <button type="submit">登録</button>
</form>
</li>
<li class="ChangeElem_Panel">
<form action="/note/page" method="post">
    問題文：<input type="text" name="m_choosable_sentence" size="30" maxlength="500" id="m_choosable_sentence" value="{{ data["m_choosable_sentence"] }}"/>{{ errormessage["m_choosable_sentence"] }}<br/>
    選択肢数：
    <select name="m_choosable_selection_count" id="m_choosable_selection_count">
    </select>{{ errormessage["m_choosable_selection_count"] }}<br/>
    正解：{{ errormessage["m_choosable_answer"] }}
    選択肢：{{ errormessage["m_selection_text"] }}<div id="selection"></div>
    <input type="hidden" name="startpos" value="2"/>
    <input type="hidden" name="m_page_type" value="2"/>
    <button type="submit">登録</button>
</form>
</li>
</ul>

<script>
    var startpos = {{ data["startpos"] }};
    var selection_max = 8;
    var m_choosable_selection_count =  {{ data["m_choosable_selection_count"] }};
    var answer = {{ data["m_choosable_answer"] }};
    var m_selection_text = [];
    m_selection_text.push("{{ data["m_selection_text1"] }}");
    m_selection_text.push("{{ data["m_selection_text2"] }}");
    m_selection_text.push("{{ data["m_selection_text3"] }}");
    m_selection_text.push("{{ data["m_selection_text4"] }}");
    m_selection_text.push("{{ data["m_selection_text5"] }}");
    m_selection_text.push("{{ data["m_selection_text6"] }}");
    m_selection_text.push("{{ data["m_selection_text7"] }}");
    m_selection_text.push("{{ data["m_selection_text8"] }}");
</script>

<script>
$(function () {
  /*初期表示*/
  $('.ChangeElem_Panel').hide();
  $('.ChangeElem_Panel').eq(startpos).show();
  $('.ChangeElem_Btn').eq(startpos).addClass('is-active');
  /*クリックイベント*/
  $('.ChangeElem_Btn').each(function () {
    $(this).on('click', function () {
      var index = $('.ChangeElem_Btn').index(this);
      $('.ChangeElem_Btn').removeClass('is-active');
      $(this).addClass('is-active');
      $('.ChangeElem_Panel').hide();
      $('.ChangeElem_Panel').eq(index).show();
    });
  });
});
</script>

<script>
$(function () {
    for (var i = 2; i <= selection_max; i++) {
        if (m_choosable_selection_count == i) {
            $('#m_choosable_selection_count').append('<option value="'+i+'" selected>'+i+'</option>');
        }else{
            $('#m_choosable_selection_count').append('<option value="'+i+'">'+i+'</option>');
        }
    }

    var last = $('#m_choosable_selection_count').val();
    for (var i = 1; i <= selection_max; i++) {
        if (answer == i) {
            $('#selection').append('<div id="subselection'+i+'"><input type="radio" name="m_choosable_answer" id="m_choosable_answer" value="'+i+'" checked/><input type="text" name="m_selection_text'+i+'" size="30" maxlength="500" id="m_selection_text'+i+'" value="'+m_selection_text[i-1]+'"/></div>');
        }else{
            $('#selection').append('<div id="subselection'+i+'"><input type="radio" name="m_choosable_answer" id="m_choosable_answer" value="'+i+'"/><input type="text" name="m_selection_text'+i+'" size="30" maxlength="500" id="m_selection_text'+i+'" value="'+m_selection_text[i-1]+'"/></div>');
        }
    }

    function showSelection(){
        var last = $('#m_choosable_selection_count').val();
        for (var i = 1; i <= selection_max; i++) {
            if (i <= last) {
                $('#subselection'+i+'').eq(0).show();
            }else{
                $('#subselection'+i+'').hide();
            }
        }
    }
    showSelection();
    $('#m_choosable_selection_count').change(showSelection);
});
</script>
<script>
$(function () {
    function setword1to2(){$('#m_basic_word2').val($('#m_basic_word1').val())}
    function setword2to1(){$('#m_basic_word1').val($('#m_basic_word2').val())}
    function setdescription1to2(){$('#m_basic_description2').val($('#m_basic_description1').val())}
    function setdescription2to1(){$('#m_basic_description1').val($('#m_basic_description2').val())}
    $('#m_basic_word1').change(setword1to2);
    $('#m_basic_word2').change(setword2to1);
    $('#m_basic_description1').change(setdescription1to2);
    $('#m_basic_description2').change(setdescription2to1);
});
</script>