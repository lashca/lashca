<div class="card w-75 mx-auto">
    <div class="card-body">
        <h5 class="card-title">パスワード再登録</h5>
        <form action="/signup/forgot" method="post">
            <div class="form-group row">
                <label for="staticEmail" class="col-md-3 col-form-label">Email</label>
                <div class="col-lg-9">
                    <input type="email" class="form-control" id="inputEmail4" maxlength="254" placeholder="Email" name="m_forgotuser_mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" value="{{ data["m_forgotuser_mail"] }}" required/>
                    <font color="#ff0000"><b>{{ errormessage["m_forgotuser_mail"] }}</b></font><br/>
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-secondary bg-gray">再登録依頼</button>
            </div>
        </form>
    </div>
</div>