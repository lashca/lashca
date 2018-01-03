<h1>{{m_note_name}}</h1>
<hr/>
<a href="/note/page">問題作成</a><br/>
<hr/>

{% set prev_no = 0%}
{% set choosable_count = 0%}
{% for page in pages %}
    
    {% if page.m_page_type == 1 %}
        <div style="float:left;border: 1px solid #000000;"><a href="/note/page/{{ page.m_page_no }}">
            {% if page.m_basic_reverse_flag == 0 %}
            問題文：{{ page.m_basic_word}}<br/>
            解答：{{ page.m_basic_description}}
            {% else %}
            単語：{{ page.m_basic_word}}<br/>
            説明文：{{ page.m_basic_description}}
            {% endif %}
        </a></div>
    {% elseif page.m_page_type == 2 %}
        {% set choosable_count += 1%}
        {% if prev_no != page.m_page_no %}
            <div style="float:left;border: 1px solid #000000;"><a href="/note/page/{{ page.m_page_no }}">
                問題文：{{ page.m_choosable_sentence}}<br/>
            {% set prev_no = page.m_page_no%}
        {% endif %}
        選択肢{{choosable_count}}：{{ page.m_selection_text}}<br/>
        {% if choosable_count == page.m_choosable_selection_count %}
            </a></div>
            {% set choosable_count = 0%}
        {% endif %}
    {% endif %}
{% endfor %}
<div style="clear:both;"/>