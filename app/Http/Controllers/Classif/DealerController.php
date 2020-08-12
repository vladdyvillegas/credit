<?php

namespace Credit\Http\Controllers\Classif;

use Illuminate\Http\Request;
use Credit\Http\Controllers\Controller;
use Credit\Models\Classif\Dealer;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $dealers = Dealer::all();
        //dd($dealers);
        return view('classif.dealers.index')->with('dealers', $dealers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         //
         return view('classif.dealers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //
       $dealer = new Dealer();
       $dealer->create($request->all());
       return redirect()->action('Classif\DealerController@index');
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
       $delete = "NO";
       $dealers = Dealer::FindOrFail($id);
       return view('classif.dealers.show')->with('dealers', $dealers)->with('delete', $delete);
    }

    /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
    public function edit($id)
    {
       //
       $dealers = Dealer::FindOrFail($id);
       return view('classif.dealers.edit')->with('dealers', $dealers);
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
        $dealers = Dealer::FindOrFail($id);
        $dealers->fill($request->all())->save();
        return redirect()->action('Classif\DealerController@index');
    }

    /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
    public function delete($id)
    {
       //
       $delete = "YES";
       $dealers = Dealer::FindOrFail($id);
       return view('classif.dealers.show')->with('dealers', $dealers)->with('delete', $delete);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $dealers = Dealer::FindOrFail($id);
        $dealers->delete();
        return redirect()->action('Classif\DealerController@index');
    }
}
