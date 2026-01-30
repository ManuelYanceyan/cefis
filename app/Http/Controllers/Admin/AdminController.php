<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Http\Requests\Admin\AddEventoRequest;
use App\Models\User;    
use App\Http\Requests\Admin\AddOrganizadorRequest;
use App\Http\Requests\Admin\AddAsistenteRequest;
use App\Http\Requests\Admin\AddPreregistradoRequest;
use App\Http\Requests\Admin\AddCertificadoBaseRequest;
use App\Models\Certificado;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Writer\PngWriter;
use App\Exports\OrganizadoresExport;
use Maatwebsite\Excel\Facades\Excel;


class AdminController extends Controller
{
    public function getAddEvento()
    {
        return view('admin.add_evento');
    }

    public function postAddEvent(AddEventoRequest $request)
    {
        Evento::create([
            'name' => $request->name,
            'fecha' => $request->fecha,
            'address' => $request->address,
            'url' => $request->url,
        ]);
        
        return redirect()->route('dashboard')->with('success', 'Evento creado exitosamente');
    }

    public function dashboard()
    {
        $eventos = Evento::select('id', 'name', 'fecha', 'certificado_base')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.dashboard', compact('eventos'));
    }

    public function getAddOrganizador($evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        $users = User::select('id', 'paternal_surname', 'maternal_surname', 'name')
            ->whereNotIn('id', $evento->organizadores->pluck('id'))
            ->get();
            
        return view('admin.add_organizador', [
            'users' => $users,
            'evento' => $evento,
            'evento_id' => $evento->id
        ]);
    }

    public function evento($id)
    {
        $evento = Evento::with(['organizadores', 'ponentes', 'asistentes', 'pre_registrados'])
            ->findOrFail($id);

        return view('admin.evento', [
            'evento' => $evento,
            'organizadores' => $evento->organizadores,
            'ponentes' => $evento->ponentes,
            'asistentes' => $evento->asistentes,
            'preregistrados' => $evento->pre_registrados
        ]);
    }

    public function postAddOrganizador(AddOrganizadorRequest $request, $evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        
        // El formulario envía 'organizador', pero validamos que no sea null
        $userId = $request->input('organizador');

        // Verificar si el usuario ya es organizador
        if (!$evento->organizadores()->where('user_id', $userId)->exists()) {
            $evento->organizadores()->attach($userId, ['tipo_id' => 4]);
            return redirect()
                ->route('evento', $evento_id)
                ->with('success', 'Organizador agregado correctamente');
        }

        return redirect()
            ->route('evento', $evento_id)
            ->with('error', 'El usuario ya es organizador de este evento');
    }

    public function getAddPonente($evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        
        // Excluir usuarios que ya son ponentes (tipo_id = 3) en este evento
        // Asumiendo que pueden ser ponentes aunque sean organizadores, 
        // pero NO si ya son ponentes.
        $ponentesIds = $evento->ponentes->pluck('id');

        $users = User::select('id', 'paternal_surname', 'maternal_surname', 'name')
            ->whereNotIn('id', $ponentesIds)
            ->get();
            
        return view('admin.add_ponente', [
            'users' => $users,
            'evento' => $evento,
            'evento_id' => $evento->id
        ]);
    }

    public function postAddPonente(\App\Http\Requests\Admin\AddPonenteRequest $request, $evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        
        $userId = $request->input('ponente');
        $ponenciaTitle = $request->input('ponencia');

        // Verificar si el usuario ya es ponente (usando la relación ponentes que filtra por tipo_id=3)
        if (!$evento->ponentes()->where('user_id', $userId)->exists()) {
            // Attach con tipo_id = 3 (Ponente) y el título de la ponencia
            $evento->ponentes()->attach($userId, [
                'tipo_id' => 3,
                'ponencia' => $ponenciaTitle
            ]);
            
            return redirect()
                ->route('evento', $evento_id)
                ->with('success', 'Ponente agregado correctamente');
        }

        return redirect()
            ->route('evento', $evento_id)
            ->with('error', 'El usuario ya es ponente de este evento');
    }

    public function getAddAsistente($evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
    
        $asistentesIds = $evento->asistentes->pluck('id');

        $users = User::select('id', 'paternal_surname', 'maternal_surname', 'name')
            ->whereNotIn('id', $asistentesIds)
            ->get();
            
        return view('admin.add_asistente', [
            'users' => $users,
            'evento' => $evento,
            'evento_id' => $evento->id
        ]);
    }

    public function postAddAsistente(AddAsistenteRequest $request, $evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        
        $userId = $request->input('asistente');

        if (!$evento->asistentes()->where('user_id', $userId)->exists()) {
            $evento->asistentes()->attach($userId, ['tipo_id' => 2]);
            return redirect()
                ->route('evento', $evento_id)
                ->with('success', 'Asistente agregado correctamente');
        }

        return redirect()
            ->route('evento', $evento_id)
            ->with('error', 'El usuario ya es asistente de este evento');
    }

    public function getAddPreregistrado($evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        
        // Use the correct relationship name defined in Evento model: pre_registrados
        $preregistradosIds = $evento->pre_registrados->pluck('id');

        $users = User::select('id', 'paternal_surname', 'maternal_surname', 'name')
            ->whereNotIn('id', $preregistradosIds)
            ->get();
            
        return view('admin.add_preregistrado', [
            'users' => $users,
            'evento' => $evento,
            'evento_id' => $evento->id
        ]);
    }

    public function postAddPreregistrado(AddPreregistradoRequest $request, $evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        
        $userId = $request->input('preregistrado');

        if (!$evento->pre_registrados()->where('user_id', $userId)->exists()) {
            $evento->pre_registrados()->attach($userId, ['tipo_id' => 1]);
            return redirect()
                ->route('evento', $evento_id)
                ->with('success', 'Preregistrado agregado correctamente');
        }

        return redirect()
            ->route('evento', $evento_id)
            ->with('error', 'El usuario ya es preregistrado en este evento');
    }

    public function getAddCertificadoBase($evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        return view('admin.add_certificado_base', compact('evento'));
    }

    public function getConfigCertificado()
    {
        return view('admin.config_certificado');
    }

    public function postConfigCertificado(AddCertificadoBaseRequest $request)
    {
        $ext = $request->base->extension();
        $name = 'certificado_global_' . time() . '.' . $ext;
        $request->base->storeAs('certificados', $name);

        // Actualizar TODOS los eventos con este certificado
        Evento::query()->update(['certificado_base' => $name]);

        return redirect()->route('dashboard')->with('success', 'Certificado base global actualizado para todos los eventos.');
    }
    public function  certificados($evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        $organizadores =$evento->organizadores()->withPivot('certificado_creado')->get();
        $ponentes =$evento->ponentes()->withPivot('certificado_creado')->get();
        $asistentes =$evento->asistentes()->withPivot('certificado_creado')->get();
        $preregistrados =$evento->pre_registrados()->withPivot('certificado_creado')->get();

        return view('admin.certificados',[
            'evento' => $evento,
            'organizadores' => $organizadores,
            'ponentes' => $ponentes,
            'asistentes' => $asistentes,
            'preregistrados' => $preregistrados,
            'evento_id' => $evento->id
        ]);
    }

    public function generarCertificadoOrganizadores($evento_id){
        $evento = Evento::findOrFail($evento_id);
        $organizadores =$evento->organizadores()->withPivot('certificado_creado')->get();
        foreach($organizadores as $organizador){
           Certificado::create([
            'tipo_id' => 4,
            'user_id' => $organizador->id,
            'evento_id' => $evento_id
           ]);
           $evento->organizadores()->updateExistingPivot($organizador->id, ['certificado_creado' => true]);
        }
        return redirect()->route('admin-certificados', ['evento_id' => $evento_id]);
    }

    public function generarCertificadoPonentes($evento_id){
        $evento = Evento::findOrFail($evento_id);
        $ponentes =$evento->ponentes()->withPivot('certificado_creado')->get();
        foreach($ponentes as $ponente){
           Certificado::create([
            'tipo_id' => 3, // 3 es Ponente segun seeder
            'user_id' => $ponente->id,
            'evento_id' => $evento_id
           ]);
           $evento->ponentes()->updateExistingPivot($ponente->id, ['certificado_creado' => true]);
        }
        return redirect()->route('admin-certificados', ['evento_id' => $evento_id]);
    }

    public function generarCertificadoAsistentes($evento_id){
        $evento = Evento::findOrFail($evento_id);
        $asistentes =$evento->asistentes()->withPivot('certificado_creado')->get();
        foreach($asistentes as $asistente){
           Certificado::create([
            'tipo_id' => 2, // 2 es Asistente
            'user_id' => $asistente->id,
            'evento_id' => $evento_id
           ]);
           $evento->asistentes()->updateExistingPivot($asistente->id, ['certificado_creado' => true]);
        }
        return redirect()->route('admin-certificados', ['evento_id' => $evento_id]);
    }

    public function generarCertificadoPreregistrados($evento_id){
        $evento = Evento::findOrFail($evento_id);
        $preregistrados =$evento->pre_registrados()->withPivot('certificado_creado')->get();
        foreach($preregistrados as $pre){
           Certificado::create([
            'tipo_id' => 1, // 1 es Pre-registrado
            'user_id' => $pre->id,
            'evento_id' => $evento_id
           ]);
           $evento->pre_registrados()->updateExistingPivot($pre->id, ['certificado_creado' => true]);
        }
        return redirect()->route('admin-certificados', ['evento_id' => $evento_id]);
    }

    public function downloadCertificado($evento_id, $certificado_id)
    {
        $evento = Evento::findOrFail($evento_id);
        // Buscar el certificado por ID (uuid hay que tener cuidado si es string)
        $certificado = Certificado::where('id', $certificado_id)->orWhere('user_id', $certificado_id)->first(); 
        // Nota: El botón en la vista podría mandar el ID del usuario o el ID del certificado. 
        // Si mandamos el ID del certificado es más directo. 
        // Pero en la vista actual no tenemos fácil acceso al ID del certificado en la lista de usuarios, 
        // solo sabemos si "certificado_creado" es true. 
        // Sería mejor buscar el certificado por user_id y evento_id.
        
        // Ajuste: Vamos a aceptar $user_id como segundo parámetro para facilitar la búsqueda
        $user_id = $certificado_id; 
        
        $certificado = Certificado::where('evento_id', $evento_id)
                        ->where('user_id', $user_id)
                        ->firstOrFail();

        $user = User::findOrFail($user_id);

        // Determinar el rol (texto)
        $rol = '';
        switch ($certificado->tipo_id) {
            case 1: $rol = 'Pre-registrado'; break;
            case 2: $rol = 'Asistente'; break;
            case 3: $rol = 'Ponente'; break;
            case 4: $rol = 'Organizador'; break;
            default: $rol = 'Participante'; break;
        }

        // Formatear fecha
        // Carbon instance from event date string
        $fecha = \Carbon\Carbon::parse($evento->fecha);
        // Set locale to Spanish for this operation if possible, or manual mapping
        $meses = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        $dia = $fecha->day;
        $mes = $meses[$fecha->month];
        $anio = $fecha->year;
        
        $fechaTexto = "$dia de $mes de $anio";



        // Generar QR
        // Generar QR
        // URL de Verificación Pública
        $qrUrl = route('certificado.verify', ['evento_id' => $evento->id, 'certificado_id' => $user->id]);
        $qrCode = new QrCode(
            data: $qrUrl,
            encoding: new Encoding('UTF-8'),
            size: 300,
            margin: 10,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );
            
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $qrCodeBase64 = $result->getDataUri();

        // Pasar QR a la vista (usando share o recompilando data)
        // Como Pdf::loadView ya cargó la vista, necesitamos pasar el QR ahí.
        // Re-hacemos loadView con el QR incluido
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.pdf_certificado', [
            'evento' => $evento,
            'user' => $user,
            'rol' => $rol,
            'fechaTexto' => $fechaTexto,
            'certificado' => $certificado,
            'qrCodeBase64' => $qrCodeBase64,
            'qrUrl' => $qrUrl
        ]);

        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('certificado_' . $user->name . '.pdf');
    }

    public function verifyCertificado($evento_id, $certificado_id)
    {
        // Buscar el certificado
        $certificado = Certificado::where('evento_id', $evento_id)
                        ->where('user_id', $certificado_id)
                        ->firstOrFail();

        $evento = Evento::findOrFail($evento_id);
        $user = User::findOrFail($certificado_id);

        // Determinar el rol (texto)
        $rol = '';
        switch ($certificado->tipo_id) {
            case 1: $rol = 'Pre-registrado'; break;
            case 2: $rol = 'Asistente'; break;
            case 3: $rol = 'Ponente'; break;
            case 4: $rol = 'Organizador'; break;
            default: $rol = 'Participante'; break;
        }

        // Formatear fecha (usando el mismo helper o lógica si es necesario)
        $fecha = \Carbon\Carbon::parse($evento->fecha);
        $fechaTexto = $fecha->isoFormat('D [de] MMMM [de] YYYY'); 

        return view('verificar_certificado', compact('evento', 'user', 'certificado', 'rol', 'fechaTexto'));
    }

    public function exportOrganizadores($evento_id) 
    {
        return Excel::download(new OrganizadoresExport($evento_id), 'organizadores.xlsx');
    }
}