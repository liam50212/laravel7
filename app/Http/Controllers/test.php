<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class NewsController extends Controller
{
    //
    public function index()
    {
        $newsData = News::get();
        
        return view('news.index2',compact('newsData'));
    }

    public function create()
    {
        return view('news.create_news');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // News::create([
        //     'tittle'=>$request->tittle,
        //     'date'=>$request->date,
        //     'img'=>$request->img,
        //     'content'=>$request->content
        // ]);

        // $data = $request->all();

        $requsetData = $request->all();
        
        if($request->hasFile('img')) {
            $file = $request->file('img');
            $path = $this->fileUpload($file,'product');
            $requsetData['img'] = $path;
        }        
        
        News::create($requsetData);
        return redirect('/news');
    }

    public function edit($id)
    {
        $news = News::find($id);
        return view('news.edit_news',compact('news'));
    }

    public function update($id,Request $request)
    {
        // dd($request->all());
        // News::find('id',$id)->update($request->all());
        $item = News::find($id);

        $requsetData = $request->all();
        if($request->hasFile('img')) {
            $old_image = $item->img;
            $file = $request->file('img');
            $path = $this->fileUpload($file,'product');
            $requsetData['img'] = $path;
            File::delete(public_path().$old_image);
        }

        $item->update($requsetData);
        return redirect('/news');
    }

    public function delete($id)
    {
        $item = News::find($id);
        $old_image = $item->img;
        if(file_exists(public_path().$old_image)){
            File::delete(public_path().$old_image);
        }
        $item->delete();
        return redirect('/news');
    }

    public function detail($id)
    {
        $newsDetail = News::find($id);
        return view('news.index3',compact('newsDetail'));
    }

    public function test()
    {
        $newsData = News::get();
        return view('news.test2',compact('newsData'));
    }

    private function fileUpload($file,$dir){
        //????????????????????????????????????????????????????????????????????????
        if( ! is_dir('upload/')){
            mkdir('upload/');
        }
        //????????????????????????????????????????????????????????????????????????
        if ( ! is_dir('upload/'.$dir)) {
            mkdir('upload/'.$dir);
        }
        //????????????????????????
        $extension = $file->getClientOriginalExtension();
        //??????????????????????????????
        $filename = strval(time().md5(rand(100, 200))).'.'.$extension;
        //?????????????????????
        move_uploaded_file($file, public_path().'/upload/'.$dir.'/'.$filename);
        //?????? ?????????????????????????????????
        return '/upload/'.$dir.'/'.$filename;
    }

}
