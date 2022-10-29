<div class="card">
    <table border="1">
        <tr>
            <th>id</th>
            <th>買い物メモ</th>
            <th>項目</th>
            <th>支出</th>
            <th>入力日</th>
            <th>更新日</th>
        </tr>
        @foreach ($books as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td>{{ $book->diary }}</td>
                <td>{{ $book->spending }}</td>
                <td>{{ $book->price }}</td>
                <td>{{ $book->created_at }}</td>
                <td>{{ $book->updated_at }}</td>
        　　</tr>
        @endforeach
  　</table>
  　<table border="1">
        <tr>
            <th>id</th>
            <th>収支メモ</th>
            <th>項目</th>
            <th>収入</th>
            <th>入力日</th>
            <th>更新日</th>
        </tr>
        @foreach ($incomes as $income)
            <tr>
                <td>{{ $income->income_id }}</td>
                <td>{{ $income->income_diary }}</td>
                <td>{{ $income->income_spending }}</td>
                <td>{{ $income->income }}</td>
                <td>{{ $income->created_at }}</td>
                <td>{{ $income->updated_at }}</td>
        　　</tr>
        @endforeach
  　</table>
</div>
