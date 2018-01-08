<div class="card w-75 mx-auto">
    <div class="card-body">
        <h5 class="card-title">仮登録</h5>
        <form action="/signup" method="post">
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail4" maxlength="254" placeholder="Email" name="m_semiuser_mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" value="{{ data["m_semiuser_mail"] }}" required/>
                    <font color="#ff0000"><b>{{ errormessage["m_semiuser_mail"] }}</b></font><br/>
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-secondary bg-gray">利用規約に同意して仮登録</button>
            </div>
            <div class="row justify-content-center">
                <label><a class="btn-link" href="/signup/terms" target="_blank">利用規約</a>についてお読みください</label>
            </div>
        </form>
    </div>
</div>