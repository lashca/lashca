<div class="card mx-auto">
    <div class="card-body">
        <h5 class="card-title">パスワード変更</h5>
        <form action="/menu/password" method="post">
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
                <button type="submit" class="btn btn-secondary bg-gray">登録変更</button>
            </div>
        </form>
    </div>
</div>