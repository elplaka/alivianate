<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\ChecaTipoUsuario;


class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $usuarios = User::all();

        if ($request->has('search'))
        {
            $usuarios = User::where('name','like',"%{$request->search}%")->orWhere('email', 'like',"%{$request->search}%")->get();     
        }  

        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        User::create([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'password' => Hash::make($request->password),
        ]);

        //return redirect()->back()->with('message', 'Empleado GUARDADO con éxito!');
        return redirect()->route('usuarios.index')->with('message', 'Usuario REGISTRADO con éxito!');
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
    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        $usuario->update([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('usuarios.index')->with('message', 'Usuario ACTUALIZADO con éxito!');
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
    }

    public function __construct()
    {
        $this->middleware(ChecaTipoUsuario::class);
        // $this->middleware(ChecaTipoUsuario::class)->only('editar');
    }
}