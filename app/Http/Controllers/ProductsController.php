<?php

namespace App\Http\Controllers;

use App\Products;
use App\ProuctImg;
use App\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    //
    public function index()
    {
        $newsData = Products::with('productType')->get();
        return view('admin.products.index',compact('newsData'));
    }

    public function create()
    {
        
        $productTypes = ProductType::get();
        return view('admin.products.create',compact('productTypes'));
    }

    public function store(Request $request)
    {
        $requsetData = $request->all();

        // if($request->hasFile('img')) {
        //     $file = $request->file('img');
        //     $path = Stroage::disk('myfile')->putFile('product',$file);
        //     $requsetData['img'] = $path;Stroage::disk('myfile')->url($path);
        // } 
        
        if($request->hasFile('img')) {
            $file = $request->file('img');
            $path = $this->fileUpload($file,'product');
            $requsetData['img'] = $path;
        }        
        
        $product = Products::create($requsetData);

        $imgs = $request->file('imgs');
        foreach($imgs as $img){
            $path = $this->fileUpload($img,'product');
            
            ProuctImg::create([
                'product_id'=>$product->id,
                'img'=>$path
            ]);
        }
        
        return redirect('/admin/products');
    }

    public function edit($id)
    {
        $productTypes = ProductType::get();
        $news = Products::with('productType','productImgs')->find($id);
        // dd($news);
        return view('admin.products.edit',compact('news','productTypes'));
    }

    public function update($id,Request $request)
    {
        $item = Products::find($id);

        $requsetData = $request->all();
        if($request->hasFile('img')) {
            $old_image = $item->img;
            $file = $request->file('img');
            $path = $this->fileUpload($file,'product');
            $requsetData['img'] = $path;
            File::delete(public_path().$old_image);
        }

        $item->update($requsetData);
        return redirect('/admin/products');
    }

    public function delete($id)
    {
        $item = Products::find($id);
        $old_image = $item->img;
        if(file_exists(public_path().$old_image)){
            File::delete(public_path().$old_image);
        }
        $item->delete();
        // News::find($id)->delete();
        return redirect('/admin/products');
    }

    public function delete_img(Request $request)
    {
        $img = ProuctImg::find($request->id);
        File::delete(public_path().$img->img);
        $img->delete();

        return 'success';
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
