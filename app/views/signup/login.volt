<div class="card mx-auto">
    <div class="card-body">
        <h5 class="card-title">ログイン</h5>
        <form action="/signup/login" method="post">
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail4" maxlength="254" placeholder="Email" name="m_user_mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" value="{{ data["m_user_mail"] }}" required/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">パスワード</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="pass" id="inputPassword" maxlength="50" placeholder="パスワード" value="{{ data["pass"] }}" required/>
                    <font color="#ff0000"><b>{{ errormessage }}</b></font><br/>
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-secondary bg-gray">ログイン</button>
            </div>
            <div class="row justify-content-center">
                <label>パスワードを忘れた方は<a class="btn-link" href="/signup/forgot">こちら</a></label>
            </div>
        </form>
    </div>
</div>