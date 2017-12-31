<h1>{{note.m_note_name}}</h1>
<hr/>
<a href="/note/page">問題作成</a><br/>
<hr/>

{% for page in pages %}
<a href="/note/page/{{ page.m_page_no }}">{{ page.m_basic_description}}</a><br/>
{% endfor %}