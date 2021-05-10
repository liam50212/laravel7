@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

@endsection

@section('main')
    <a href="/news/create"><button>新增最新消息</button></a>
    <hr>
    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>編號</th>
                <th>標題</th>
                <th>日期</th>
                <th>src</th>
                <th>圖片</th>
                <th>主旨</th>
                <th>編輯</th>
                <th>刪除</th>
            </tr>
        </thead>
        @foreach ($newsData as $news)    
        <tbody>
            <tr>
                <td>{{$news->id}}</td>
                <td>{{$news->tittle}}</td>
                <td>{{$news->date}}</td>
                <td><img style="width: 300px;height: 200px;" src="{{$news->img}}"></td>
                <td>{{$news->img}}</td>
                <td>{{$news->content}}</td>
                <td>
                    <a href="/news/edit/{{$news->id}}">
                        <button>編輯</button>
                    </a>
                </td>
                <td>
                    <a class="btn" href="/news/delete/{{$news->id}}">
                        <button class="delete btn" data-href="/news/delete/{{$news->id}}">刪除</button>
                    </a>
                </td>
            </tr>
        </tbody>
        @endforeach
    </table>
@endsection

@section('js')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script>
    $(document).ready( function () {
    $('#table_id').DataTable();
} );
</script>

@endsection