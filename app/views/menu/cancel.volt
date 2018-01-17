<div class="card w-75 mx-auto">
    <div class="card-body">
        <h5 class="card-title">有料ノート解約</h5>
        <form action="/note/cancel" method="get">
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-outline-secondary">解約手続きに進む</button><br/>
            </div>
        </form>
    </div>
</div>
<br/>
<div class="card w-75 mx-auto">
    <div class="card-body">
        <h5 class="card-title">ユーザ解約</h5>
        <hr/>
        <form action="/menu/cancel" method="get">
            解約を行った場合、ユーザ情報、有料ノート、学習状況の全ての情報が削除されます。<br/>
            再度登録を行っても各情報を復帰できませんので、ご注意ください。<br/>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-outline-secondary">解約</button><br/>
            </div>
        </form>
    </div>
</div>