<div class="card mx-auto">
    <div class="card-body">
        <h5 class="card-title">ユーザ情報</h5>
        <form action="/menu/user" method="post">
            <div class="form-group row">
                <label for="staticEmail" class="col-md-3 col-form-label">Email</label>
                <div class="col-lg-9">
                    <input type="email" class="form-control" id="inputEmail4" maxlength="254" placeholder="Email" name="m_user_mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" value="{{ data["m_user_mail"] }}" required/>
                    <font color="#ff0000"><b>{{ errormessage["m_user_mail"] }}</b></font>
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
                    <label class="btn btn-outline-secondary {% if data["m_user_sex"] != 1 %}active{% endif %}">
                        <input type="radio" name="m_user_sex" autocomplete="off" value="0" {% if data["m_user_sex"] != 1 %}checked{% endif %}> 男性
                    </label>
                    <label class="btn btn-outline-secondary {% if data["m_user_sex"] == 1 %}active{% endif %}">
                        <input type="radio" name="m_user_sex" autocomplete="off" value="1" {% if data["m_user_sex"] == 1 %}checked{% endif %}> 女性
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
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-secondary bg-gray">登録変更</button>
            </div>
        </form>
    </div>
</div>
<br/>
<div class="card mx-auto">
    <div class="card-body">
        <h5 class="card-title">解約</h5>
        <form action="/menu/cancel" method="get">
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-outline-secondary">解約手続きに進む</button><br/>
            </div>
            <div class="row justify-content-center">
                <small id="passwordHelpBlock" class="form-text text-muted">
                    有料ノートやユーザ情報の解約を行います
                </small>
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