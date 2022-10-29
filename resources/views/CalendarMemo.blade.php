@extends('layouts.app')
@section('content')
<div class="title">
    <label>選択日付</label>
    <label class="date">{{ $showDate }}</label>
</div>
<div class="total">
    <label class="pricePlus" for="price">支出合計</label>
    <label class="prices">{{ $prices }}円</label>
    <div class="move">
        <input type="submit" class="btn btn-primary submit" value="収入登録画面へ" id="button3" onClick="income()">
    </div>
</div>
<div class="block">
    <form action="{{ route('create_page') }}" method="post">
        <div class="textarea">
            <label class="col-md-2" for="price">支出（円）</label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="price" maxlength="9" value="{{ old('price') }}" id="price">
            </div>
            <label class="col-md-2" for="spending">項目の選択</label>
            <div class="col-md-10">
                <select class="form-control" name="spending" value="{{ old('spending') }}" id="spending">
                    <option value="" hidden>選択してください</option>
                    @foreach (config('select.select') as $select)
                        <option value="{{$select}}">{{ $select }}</option>
                    @endforeach
                </select>
            </div>
            <label class="col-md-2" for="diary">買い物メモ</label>
            <div class="col-md-10">
                <textarea class="form-control" name="diary" rows="15" maxlength="100" id="diary">{{ old('diary') }}</textarea>
            </div>
        </div>
        @csrf
        <div class="but">
            <input type="submit" class="btn btn-primary submit" value="登録" id="button1" onClick="return register()">
            <input type="submit" class="btn btn-primary submit" value="戻る" id="button2" onClick="back(); history.back(-1)">
            <input type="hidden" name="selectedDate" value="{{ $selectedDate }}">
        </div>
    </form>
    <form action="{{ route('update_delete_page') }}" method="post">
        <div class="history">
            <h2>支出履歴</h2>
            <div class="scroll">
                <table class="history_table" border="1" width="600">
                    <tr align="center">
                        <th>詳細</th>
                        <th>支出（円）</th>
                        <th>項目</th>
                        <th>買い物メモ</th>
                        <th>削除</th>
                    </tr>
                    @foreach ($books as $book)
                    <tr align="center">
                        <input type="hidden" name="id-{{ $book->id }}" value="{{ $book->id }}" >
                        <td><input type="button" name="detail-{{ $book->id }}" class="btn btn-primary modal-open" value="詳細" id="off" onClick="modalOpen(this)"></td>
                        <td><input class="input_text" type="text" name="price-{{ $book->id }}" id="price-{{ $book->id }}" value={{ $book->price }}></td>
                        <td><select name="spending-{{ $book->id }}" id="spending-{{ $book->id }}">
                            @foreach (config('select.select') as $select)
                                <option value="{{$select}}"@if($select==$book->spending) selected @endif>{{ $select }}</option>
                            @endforeach
                            </select>
                        </td>
                        <td><textarea name="diary-{{ $book->id }}" id="diary-{{ $book->id }}">{{ $book->diary }}</textarea></td>
                        <td>
                            <input type="checkbox" class="btn btn-primary del-checkbox" value={{ $book->id }}>
                            <input type="hidden" name="delete-{{ $book->id }}">
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <p class="scroll_txt">※横スクロールできます</p>
            <div class="but">
                <input type="submit" name="upd_book"  class="btn btn-primary ud-submit" value="一括更新" id="upd" onClick="return upd_button()">
                <input type="submit" name="del_book"  class="btn btn-primary ud-submit" value="一括削除" id="del" onClick="return del_button()">
                <input type="hidden" name="selectedDate" value="{{ $selectedDate }}">
            </div>
        </div>
        @csrf
    </form>
</div>
<div class="modal-container">
    <div class="modal-body">
        <!-- 閉じるボタン -->
        <div class="modal-close" id="on">×</div>
        <!-- モーダル内のコンテンツ -->
        <div class="modal-content">
            <table class="modal_window">
                <tr class="modal_tr"><th class="modal_th">支出（円）</th><td><p class="modal_td" type="text" id="modal_price">10000</p></td></tr>
                <tr class="modal_tr"><th class="modal_th">項目</th><td><p class="modal_td" id="modal_spending">食費</p></td></tr>
                <tr class="modal_tr"><th class="modal_th">買い物メモ</th><td><p class="modal_td" id="modal_diary">スーパーマーケット、玉ねぎ、にんじん</p></td></tr>
            </table>
        </div>
    </div>
</div>
<script>
    const register = () =>{
        let price = document.getElementById('price').value;
        if(price.length == 0 || spending.value == "" || diary.value.length == 0) {
            alert('『支出』 『項目』 『買い物メモ』全てに入力してください');
        } else if(price == 0){
            alert('0円は登録できません');
        } else if(isNaN(price)){
            alert('『支出』には半角の数字を入力してください');
        } else{
            if (!window.confirm('登録してもよろしいですか？')){return false}
        }
    };
    
    function back() {
      document.getElementById("button1").disabled = false;
      document.getElementById("button2").disabled = true;
      document.getElementById("button3").disabled = false;
    }
    function income() {
      document.getElementById("button1").disabled = false;
      document.getElementById("button2").disabled = false;
      document.getElementById("button3").disabled = true;
      var paramstr = document.location.search;
      document.location.href = "/calendar/income"+paramstr;
    }
    
    const upd_button = () =>{
        if (!window.confirm('更新してもよろしいですか？')){return false} 
    };
    
    const del_button = () =>{
        if (!window.confirm('削除してもよろしいですか？')){return false} 
    };
    
    $(function(){
        $(document).on("click", '.del-checkbox', function(){
        let bool = $(this).prop("value");
        bool && $(this).next().val(bool);
        bool || $(this).next().val("");
        });
    });
    
    function modalOpen(button) {
        var detail = button.getAttribute('name');
        var detailDelete = detail.substr( 6 );
        
        let detailPrice = 'price' + detailDelete;
        let priceValue = document.getElementById(detailPrice).value;
        
        let detailSpending = 'spending' + detailDelete;
        let spendingValue = document.getElementById(detailSpending).value;
        
        let detailDiary = 'diary' + detailDelete;
        let diaryValue = document.getElementById(detailDiary).value;

        var modal_price = document.getElementById("modal_price");
        modal_price.innerHTML = priceValue;
        
        var modal_spending = document.getElementById("modal_spending");
        modal_spending.innerHTML = spendingValue;
        
        var modal_diary = document.getElementById("modal_diary");
        modal_diary.innerHTML = diaryValue;
        
    	var open = $('.modal-open'),
    		close = $('.modal-close'),
    		container = $('.modal-container');
    	console.log(open);
    	
		container.addClass('active');
	
    	close.on('click',function(){	
    		container.removeClass('active');
    	});
    }
    
    $('#off').on('click', function(){
       $('body').addClass('no_scroll');
       var pagetop = $('#page_top');
       pagetop.fadeOut();
    });
     
    $('#on').on('click', function(){
       $('body').removeClass('no_scroll');
       var pagetop = $('#page_top');
       pagetop.fadeIn();
    });
</script>
@endsection