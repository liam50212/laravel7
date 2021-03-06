@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index2.css') }}">

@endsection

@section('main')
<div class="section">
    <div class="section-data">
        <a href="/news/create">
            <button>新增</button>
        </a>
    </div>
    <hr>
</div>
<section class="section-main">
    @foreach ($newsData as $news)
    <div class="main-text" style="display: flex">
        <img src="{{$news->img}}" style="width: 400px; height: 300px;" alt="">
        <div class="section-block" style="margin-left: 50px">
            <span class="span-block">{{$news->tittle}}</span><br><br>
            <a href="/news/detail/{{$news->id}}">
                <span>經典小鎮升級3.0正式開跑　小鎮逗鎮趣 集章抽好禮</span>
            </a>
            <h5>{{$news->date}}</h5>
            <h5>{{$news->content}}</h5>
            <a href="/news/edit/{{$news->id}}">
                <button>編輯</button>
            </a>
            <a class="btn" href="/news/delete/{{$news->id}}">
                <button class="delete btn" data-href="/news/delete/{{$news->id}}">刪除</button>
            </a>
        </div>
    </div>   
    <hr>
    @endforeach
<section>


@endsection

@section('js')

<script>
    document.querySelectorAll('.delete').forEach(function (btn)){
        btn.addEventListener('click',function (){
            if(confirm('確定要刪除嗎')) {
                location.href= this.getAttribute('data-href');
            }
        })
    });
</script>

@endsection