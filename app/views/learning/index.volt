<h1>{{m_note_name}}</h1>
<hr/>
{% set prev_no = 0%}
{% set page_count = 0%}
{% set choosable_count = 0%}
{% for learning in learninglist %}
    {% if learning.m_page_type == 1 %}
        {% if learning.m_basic_reverse_flag == 0 %}
        {% set page_count += 1%}
        <div id="fullpage{{page_count}}">
        {{page_count}} / {{ page_num }}<br/>
        <form class="form" action="" method="post">
            問題文：<br/>
            <div style=" width:200px;height:100px;border:#000000 solid 1px;">
            <div>{{ learning.m_basic_word}}</div>
            </div>
            解答：<br/>
            <div id="answer{{page_count}}" style=" width:200px;height:100px;border:#000000 solid 1px;">
                <div id="dummy{{page_count}}">(解答を見る)</div>
                <div id="page{{page_count}}">{{ learning.m_basic_description}}</div>
            </div>
            <input id="incorrect{{page_count}}" type="submit" name="b1" value="不正解" />
            <input id="correct{{page_count}}" type="submit" name="b2" value="正解" />
        </form>
        </div>
            <script type="text/javascript">
            function showanser{{page_count}}(){
                $('#dummy{{page_count}}').hide();
                $('#page{{page_count}}').show();
                $('#incorrect{{page_count}}').show();
                $('#correct{{page_count}}').show();
            };
            {% if page_count > 1 %}
                $('#fullpage{{page_count}}').hide();
            {% endif %}
            $('#page{{page_count}}').hide();
            $('#incorrect{{page_count}}').hide();
            $('#correct{{page_count}}').hide();
            $('#answer{{page_count}}').click(showanser{{page_count}});

            $('#incorrect{{page_count}}').on('click',function(){
                $.ajax({
                    url:'/learning',
                    type:'POST',
                    data:{
                        'm_page_id':{{ learning.m_page_id}},
                        't_learninglist_corrected':0,
                        't_learninglist_answer_time':0,
                    }
                });
                $('#fullpage{{page_count}}').hide();
                $('#fullpage{{page_count+1}}').show();
            });
            $('#correct{{page_count}}').on('click',function(){
                $.ajax({
                    url:'/learning',
                    type:'POST',
                    data:{
                        'm_page_id':{{ learning.m_page_id}},
                        't_learninglist_corrected':1,
                        't_learninglist_answer_time':0,
                    }
                });
                $('#fullpage{{page_count}}').hide();
                $('#fullpage{{page_count+1}}').show();
            });
            </script>
        {% else %}
        {% set page_count += 1%}
        <div id="fullpage{{page_count}}">
        {{page_count}} / {{ page_num }}<br/>
            {% if learning.m_learned_correctedcount == 0 %}
                <form class="form" action="" method="post">
                    単語：<br/>
                    <div style=" width:200px;height:100px;border:#000000 solid 1px;">
                    <div>{{ learning.m_basic_word}}</div>
                    </div>
                    説明文：<br/>
                    <div id="answer{{page_count}}" style=" width:200px;height:100px;border:#000000 solid 1px;">
                        <div id="dummy{{page_count}}">(解答を見る)</div>
                        <div id="page{{page_count}}">{{ learning.m_basic_description}}</div>
                    </div>
                    <input id="incorrect{{page_count}}" type="submit" name="b1" value="不正解" />
                    <input id="correct{{page_count}}" type="submit" name="b2" value="正解" />
                </form>
            {% else %}
                <form class="form" action="" method="post">
                    単語：<br/>
                    <div id="answer{{page_count}}" style=" width:200px;height:100px;border:#000000 solid 1px;">
                        <div id="dummy{{page_count}}">(解答を見る)</div>
                        <div id="page{{page_count}}">{{ learning.m_basic_word}}</div>
                    </div>
                    説明文：<br/>
                    <div style=" width:200px;height:100px;border:#000000 solid 1px;">
                        <div>{{ learning.m_basic_description}}</div>
                    </div>
                    <input id="incorrect{{page_count}}" type="submit" name="b1" value="不正解" />
                    <input id="correct{{page_count}}" type="submit" name="b2" value="正解" />
                </form>
            {% endif %}
        </div>
                <script type="text/javascript">
                function showanser{{page_count}}(){
                    $('#dummy{{page_count}}').hide();
                    $('#page{{page_count}}').show();
                    $('#incorrect{{page_count}}').show();
                    $('#correct{{page_count}}').show();
                };
                {% if page_count > 1 %}
                    $('#fullpage{{page_count}}').hide();
                {% endif %}
                $('#page{{page_count}}').hide();
                $('#incorrect{{page_count}}').hide();
                $('#correct{{page_count}}').hide();
                $('#answer{{page_count}}').click(showanser{{page_count}});
    
                $('#incorrect{{page_count}}').on('click',function(){
                    $.ajax({
                        url:'/learning',
                        type:'POST',
                        data:{
                            'm_page_id':{{ learning.m_page_id}},
                            't_learninglist_corrected':0,
                            't_learninglist_answer_time':0,
                        }
                    });
                    $('#fullpage{{page_count}}').hide();
                    $('#fullpage{{page_count+1}}').show();
                });
                $('#correct{{page_count}}').on('click',function(){
                    $.ajax({
                        url:'/learning',
                        type:'POST',
                        data:{
                            'm_page_id':{{ learning.m_page_id}},
                            't_learninglist_corrected':1,
                            't_learninglist_answer_time':0,
                        }
                    });
                    $('#fullpage{{page_count}}').hide();
                    $('#fullpage{{page_count+1}}').show();
                });
                </script>
        {% endif %}
    {% elseif learning.m_page_type == 2 %}
    {% set choosable_count += 1%}
        {% if prev_no != learning.m_page_no %}
            {% set page_count += 1%}
            <div id="fullpage{{page_count}}">
            {{page_count}} / {{ page_num }}<br/>
            <form class="form" action="" method="post">
            <div id="correct{{page_count}}">正解！<br/><input type="submit" name="next{{page_count}}" value="次の問題へ"></input></div>
            <div id="incorrect{{page_count}}">不正解...<br/><input type="submit" name="next{{page_count}}" value="次の問題へ"/></div>
            <div id="sentence{{page_count}}">
                問題文：<br/>
                <div style=" width:200px;height:100px;border:#000000 solid 1px;">
                    <div>{{ learning.m_choosable_sentence}}</div>
                </div>
            {% set prev_no = learning.m_page_no%}
        {% endif %}
            <div>
            <input type="radio" name="m_choosable_answer{{page_count}}" id="m_choosable_answer{{page_count}}" value="{{choosable_count}}"/>
            {{ learning.m_selection_text}}
            </div>
        {% if choosable_count == learning.m_choosable_selection_count %}
            <input id="answer{{page_count}}" type="submit" name="b1" value="回答" disabled="disabled"/>
            </div>
            </form></div>
            
            <script type="text/javascript">
                {% if page_count > 1 %}
                    $('#fullpage{{page_count}}').hide();
                {% endif %}
                $('#correct{{page_count}}').hide();
                $('#incorrect{{page_count}}').hide();
                $("input[name='m_choosable_answer{{page_count}}']").change(function(){
                    $("#answer{{page_count}}").prop("disabled", false);
                });
                $('#answer{{page_count}}').on('click',function(){
                    if($("input[name='m_choosable_answer{{page_count}}']:checked").val()=={{learning.m_choosable_answer}}){
                        $('#correct{{page_count}}').show();
                        $('#sentence{{page_count}}').hide();
                        $.ajax({
                        url:'/learning',
                        type:'POST',
                        data:{
                            'm_page_id':{{ learning.m_page_id}},
                            't_learninglist_corrected':1,
                            't_learninglist_answer_time':0,
                        }
                    });
                    }else{
                        $('#incorrect{{page_count}}').show();
                        $('#sentence{{page_count}}').hide();
                        $.ajax({
                        url:'/learning',
                        type:'POST',
                        data:{
                            'm_page_id':{{ learning.m_page_id}},
                            't_learninglist_corrected':0,
                            't_learninglist_answer_time':0,
                        }
                    });
                    }
                });
                $("input[name='next{{page_count}}']").on('click',function(){
                    $('#fullpage{{page_count}}').hide();
                    $('#fullpage{{page_count+1}}').show();
                });
            </script>
            {% set choosable_count = 0%}
        {% endif %}

    {% endif %}
{% endfor %}
{% set page_count += 1%}
<div id="fullpage{{page_count}}">
        <form action="/note/detail/{{m_holdingnote_no}}" method="get">
            終了しました。<br/>
            <input type="submit" value="戻る" />
        </form>
</div>
    
<script type="text/javascript">
$('#fullpage{{page_count}}').hide();
$('.form').submit(function(event) {
    event.preventDefault();
});
</script>