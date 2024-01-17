<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Nivel;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $alumnos = Alumno::all();
        return view('alumnos.index',['alumnos' => $alumnos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // TRAER TODOS LOS REGISTROS DE ESA TABLA
        // $niveles = Nivel::all();
        return view('alumnos.create', ['niveles' => Nivel::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validaciones
        $request->validate([
            'matricula' => 'required|unique:alumnos|max:10',
            'nombre'=> 'required|max:255',
            'fecha'=> 'required|date',
            'telefono'=> 'required',
            'email'=> 'nullable|email',
            'nivel'=> 'required'
        ]);

        $alumno = new Alumno();
        $alumno->matricula = $request->input('matricula');
        $alumno->nombre = $request->input('nombre');
        $alumno->fecha_nacimiento = $request->input('fecha');
        $alumno->telefono = $request->input('telefono');
        $alumno->email = $request->input('email');
        $alumno->nivel_id = $request->input('nivel');  
        $alumno->save();

        return view("alumnos.message", ['msg'=> "Registro guardado"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumno $alumno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // llamamos la vista para editar 
        $alumno = Alumno::find($id);
        return view('alumnos.edit',['alumno'=> $alumno, 'niveles'=> Nivel::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //guardar los datos actulizados
        $request->validate([
            // para poder omitir la matricula ese registro cuando se quiera actulizar ese registro
            'matricula' => 'required|max:10|unique:alumnos,matricula,'.$id,
            'nombre'=> 'required|max:255',
            'fecha'=> 'required|date',
            'telefono'=> 'required',
            'email'=> 'nullable|email',
            'nivel'=> 'required'
        ]);

        $alumno = Alumno::find($id);
        $alumno->matricula = $request->input('matricula');
        $alumno->nombre = $request->input('nombre');
        $alumno->fecha_nacimiento = $request->input('fecha');
        $alumno->telefono = $request->input('telefono');
        $alumno->email = $request->input('email');
        $alumno->nivel_id = $request->input('nivel');  
        $alumno->save();

        return view("alumnos.message", ['msg'=> "Registro modificado"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //eliminar un dato
        $alumno = Alumno::find($id);
        $alumno->delete();

         return redirect("alumnos");

    }
}
