<div class="card-columns">
{% for note in holdingnotes %}
    <a href="/note/detail/{{ note.m_holdingnote_no }}" style="color: #000000;text-decoration: none;">
        <div class="card border-secondary">
            {% if note.m_notecategory_id > 1 %}
            <div class="card-header bg-purple">
                <span class="icon-sphere"></span> 
            {% else %}
            <div class="card-header">
                <span class="icon-file-text2"></span> 
            {% endif %}
            {{note.m_notecategory_name}}
            </div>
            <div class="card-body">
                <h4 class="card-title" id="note{{ note.m_holdingnote_no }}">{{ note.m_note_name }}</h4>
                {% if note.m_notecategory_id == 1 %}
                <div class="text-right">
                    <div class="dropdown">
                        <a class="btn btn-outline-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="icon-pencil"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#nameChangeModal{{ note.m_holdingnote_no }}">ノート名変更</a>
                            <a class="dropdown-item" href="#">削除</a>
                        </div>
                    </div>
                </div>
                {% endif %}
            </div>
        </div>
    </a>
    {% if note.m_notecategory_id == 1 %}
    <div class="modal fade" id="nameChangeModal{{ note.m_holdingnote_no }}" tabindex="-1" role="dialog" aria-labelledby="ノート名変更" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nameChangeModalTitle{{ note.m_holdingnote_no }}">ノート名変更</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">ノート名:</label>
                        <input type="text" class="form-control" name="m_note_name"  id="nameChangeModalValue{{ note.m_holdingnote_no }}" placeholder="ノート名" maxlength="20" pattern="^[ぁ-んァ-ンー\w一-龠]+$" value="{{ note.m_note_name }}" required/>
                        <small id="passwordHelpBlock" class="form-text text-muted">
                                20文字以内の全角半角文字を設定可能
                        </small>
                        <font color="#ff0000"><b id="erromess{{ note.m_holdingnote_no }}"></b></font><br/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                    <button type="button" class="btn btn-primary" id="changeSubmit{{ note.m_holdingnote_no }}">変更</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#changeSubmit{{ note.m_holdingnote_no }}').on('click',function(){
            var $loading = $(".loading");
            $.ajax({
                url:'/note/rename',
                type:'POST',
                timeout: 10000,
                data:{
                    'm_note_name':$('#nameChangeModalValue{{ note.m_holdingnote_no }}').val(),
                    'm_holdingnote_no':{{ note.m_holdingnote_no }},
                },
                beforeSend:function(){
                    $loading.removeClass("is-hide");
                },
            })
            .done(function (response, textStatus, jqXHR) {
                if (response === "ok") {
                    $('#note{{ note.m_holdingnote_no }}').text($('#nameChangeModalValue{{ note.m_holdingnote_no }}').val());
                    $('#nameChangeModal{{ note.m_holdingnote_no }}').modal('hide');
                    $('#erromess{{ note.m_holdingnote_no }}').text("");
                    $loading.addClass("is-hide");
                } else {
                    $('#erromess{{ note.m_holdingnote_no }}').text(response);
                    $loading.addClass("is-hide");
                }
            })
            .fail(function(){
                $('#erromess{{ note.m_holdingnote_no }}').text("通信エラー");
                $loading.addClass("is-hide");
            });

        });
    </script>
    {% endif %}
{% endfor %}
    <div class="card">
        <div class="card-body text-center">
            <a href="/note" class="btn btn-outline-secondary" style="width:100%;"><span class="icon-book" style="font-size: 2em;"></span><br/>
            <small>ノートを追加</small></a>
        </div>
    </div>
</div>

<div class="loading is-hide">
    <div class="loading_icon"></div>
</div>

<script>
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })
</script>

