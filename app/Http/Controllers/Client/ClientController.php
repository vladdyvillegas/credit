<?php

namespace Credit\Http\Controllers\Client;

use Illuminate\Http\Request;
use Credit\Http\Controllers\Controller;
use Credit\Models\Client\Client;
use Session;
use Credit\Http\Requests\Client\ClientCreateRequest;
use Credit\Http\Requests\Client\ClientUpdateRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $clients = Client::all();
        return view('clients.index')->with('clients', $clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($legal_pers)
    {
        //
        return view('clients.create')->with('legal_pers', $legal_pers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientCreateRequest $request)
    {
        //
        //dd($request->civil_status);
        Client::create($request->all());
        Session::flash('save', 'Cliente creado satisfactoriamente.');
        return redirect()->action('Client\ClientController@index');
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
        $clients = Client::FindOrFail($id);
        return view('clients.show')->with('clients', $clients)->with('legal_pers', $clients->legal_personality)->with('delete', $delete);
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
        $clients = Client::FindOrFail($id);
        return view('clients.edit')->with('clients', $clients)->with('legal_pers', $clients->legal_personality);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientUpdateRequest $request, $id)
    {
        //
        $clients = Client::FindOrFail($id);
        $clients->fill($request->all())->save();
        Session::flash('update', 'Cliente actualizado satisfactoriamente.');
        return redirect()->action('Client\ClientController@index');
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
        $clients = Client::FindOrFail($id);
        return view('clients.show')->with('clients', $clients)->with('legal_pers', $clients->legal_personality)->with('delete', $delete);
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
        $clients = Client::FindOrFail($id);
        $clients->delete();
        Session::flash('delete', 'Cliente eliminado satisfactoriamente.');
        return redirect()->action('Client\ClientController@index');
    }

}
