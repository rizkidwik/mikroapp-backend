<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Rate;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rate = Rate::get();
        if ($request->ajax()) {

            $data = Product::with('rates')->latest()->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                            return $btn;
                    })
                    ->addColumn('image', function ($row) {
            //             if($row->image){
            //                 $url= asset('images/'.$row->image);
            //             } else {
            // $url = 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg';
            //             }
    return '<img src="'.$row->image.'" border="0" width="40" class="img-rounded" align="center" />';
                    })
                    ->rawColumns(['action','image'])
                    ->make(true);
                }

        return view('admin.product.index')->with([
            'rate'=>$rate,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
       ]);

       $imageName = time().'.'.$request->image->extension();

        $request->image->move(public_path('images'), $imageName);

        Product::updateOrCreate([
            'id' => $request->product_id
        ],
        [
            'name' => $request->name,
            'rate_limit_id' => $request->rate_limit_id,
            'price' => $request->price,
            'duration' => $request->duration,
            'image' => $imageName

        ]);

return response()->json(['success'=>'Product saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();

        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
