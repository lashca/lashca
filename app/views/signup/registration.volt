<div class="card mx-auto">
    <div class="card-body">
        <h5 class="card-title">本登録</h5>
        <form action="/signup/registration" method="post">
            <div class="form-group row">
                <label for="staticEmail" class="col-md-3 col-form-label">Email</label>
                <div class="col-lg-9">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ email }}" />
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-md-3 col-form-label">お名前</label>
                <div class="col">
                    <input type="text" class="form-control" name="m_user_lastname" placeholder="姓" maxlength="100" pattern="^[ぁ-んァ-ンー\w一-龠]+$" value="{{ data["m_user_lastname"] }}" required/>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="m_user_firstname" placeholder="名" maxlength="100" pattern="^[ぁ-んァ-ンー\w一-龠]+$" value="{{ data["m_user_firstname"] }}" required/>
                </div>
                <font color="#ff0000"><b>{{ errormessage["m_user_name"] }}</b></font><br/>
            </div>

            <div class="form-group row">
                <label for="staticEmail" class="col-md-3 col-form-label">性別</label>
                <div class="btn-group btn-group-toggle" data-toggle="buttons" style="padding-left:1em;">
                    <label class="btn btn-outline-secondary {% if data["m_user_sex"] == 0 %}active{% endif %}">
                        <input type="radio" name="m_user_sex" autocomplete="off" value="0"> 男性
                    </label>
                    <label class="btn btn-outline-secondary {% if data["m_user_sex"] == 1 %}active{% endif %}">
                        <input type="radio" name="m_user_sex" autocomplete="off" value="1"> 女性
                    </label>
                </div>
                <font color="#ff0000"><b>{{ errormessage["m_user_sex"] }}</b></font><br/>
            </div>

            <div class="form-group row">
                <label for="staticEmail" class="col-md-3 col-form-label">生年月日</label>
                <div class="col-4">
                    <select class="form-control" name="m_user_birthday_year" id="year"><option value="">年</option></select>
                </div>
                <div class="col">
                    <select class="form-control" name="m_user_birthday_month" id="month"><option value="">月</option></select>
                </div>
                <div class="col">
                    <select class="form-control" name="m_user_birthday_day" id="day"><option value="">日</option></select>
                </div>
                <font color="#ff0000"><b>{{ errormessage["m_user_birthday"] }}</b></font><br/>
            </div>

            <div class="form-group row">
                <label for="inputPassword" class="col-md-3 col-form-label">パスワード</label>
                <div class="col-lg-9">
                    <input type="password" class="form-control" name="pass" id="inputPassword" minlength="8" maxlength="50" pattern="^([\w\.\-#]+)$" placeholder="パスワード" value="{{ data["pass"] }}" required/>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                            8～50文字の英数記号(.-#)のみ設定可能
                    </small>
                    <font color="#ff0000"><b>{{ errormessage["pass"] }}</b></font><br/>
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-secondary bg-gray">利用規約に同意して本登録</button>
            </div>
            <div class="row justify-content-center">
                <label><a class="btn-link" href="/signup/terms" target="_blank">利用規約</a>についてお読みください</label>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    var y = {{ data["m_user_birthday_year"] }};
    var m = {{ data["m_user_birthday_month"] }};
    var d = {{ data["m_user_birthday_day"] }};    
</script>
<script src="/js/date.js"></script>