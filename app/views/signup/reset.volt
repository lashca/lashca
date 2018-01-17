<div class="card w-75 mx-auto">
    <div class="card-body">
        <h5 class="card-title">パスワード再登録</h5>
        <form action="/signup/reset" method="post">
            <div class="form-group row">
                <label for="staticEmail" class="col-md-3 col-form-label">Email</label>
                <div class="col-lg-9">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ email }}" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label">パスワード</label>
                <div class="col-lg-9">
                    <input type="password" class="form-control" name="pass" id="inputPassword" maxlength="50" placeholder="パスワード" value="{{ data["pass"] }}" required/>
                    <font color="#ff0000"><b>{{ errormessage["pass"] }}</b></font><br/>
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-secondary bg-gray">再登録</button>
            </div>
        </form>
    </div>
</div>