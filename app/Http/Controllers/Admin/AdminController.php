<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\User;
use App\Models\Certificado;
use App\Http\Requests\Admin\AddEventoRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Admin\AddOrganizadorRequest;
use App\Http\Requests\Admin\AddPonenteRequest;
use App\Http\Requests\Admin\AddCertificadoBaseRequest;
use App\Models\Tipo;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrganizadoresExport;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function getDashboard()
    {
        $eventos = Evento::orderBy('fecha', 'desc')->get();
        return view('admin.dashboard', ['eventos' => $eventos]);
    }
    public function evento($evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        $organizadores = $evento->organizadores;
        $ponentes = $evento->ponentes()->withPivot('ponencia')->get();
        $asistentes = $evento->asistentes;
        $preregistrados = $evento->pre_registrados;
        return view('admin.evento', [
            'evento' => $evento,
            'organizadores' => $organizadores,
            'ponentes' => $ponentes,
            'asistentes' => $asistentes,
            'preregistrados' => $preregistrados,
            'evento_id' => $evento_id
        ]);
    }
    public function getAddCertificadoBase($evento_id)
    {
        return view('admin.add_certificado_base', ['evento_id' => $evento_id]);
    }
    public function postAddCertificadoBase(AddCertificadoBaseRequest $request, $evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        $ext = $request->base->extension();
        $name = strval($evento->id) . "." . $ext;
        $request->base->storeAs('certificados', $name);
        $evento->certificado_base = $name;
        $evento->save();
        return redirect()->route('evento', ['evento_id' => $evento_id]);
    }
    public function getAddEvento()
    {
        return view('admin.add_evento');
    }
    public function postAddEvento(AddEventoRequest $request)
    {
        Log::warning("request validado, por crear evento");
        Evento::create([
            "name" => $request->name,
            "fecha" => $request->fecha,
            "address" => $request->address,
            "url" => $request->url
        ]);
        return redirect()->route("dashboard");
    }
    
    public function getAddOrganizador($evento_id)
    {
        $users = User::select('id', 'paternal_surname', 'maternal_surname', 'name')->get();
        return view('admin.add_organizador', ['users' => $users]);
    }
    public function postAddOrganizador(AddOrganizadorRequest $request, $evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        $organizador_id = (int) $request->organizador;
        $org = $evento->organizadores()->wherePivot('user_id', $organizador_id)->first();
        if (!$org) {
            $evento->organizadores()->attach([
                $organizador_id => ['tipo_id' => 4]
            ]);
        }
        return redirect()->route('evento', ['evento_id' => $evento_id]);
    }
    public function getAddPonente($evento_id)
    {
        $users = User::select('id', 'paternal_surname', 'maternal_surname', 'name')->get();
        return view('admin.add_ponente', ['evento_id' => $evento_id, 'users' => $users]);
    }

    public function postAddPonente(AddPonenteRequest $request, $evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        $ponente_id = (int) $request->ponente;
        $ponente = $evento->ponentes()->wherePivot('user_id', $ponente_id)->first();
        if (!$ponente) {
            $evento->ponentes()->attach([
                $ponente_id => ['tipo_id' => 3, 'ponencia' => $request->ponencia]
            ]);
        }
        return redirect()->route('evento', ['evento_id' => $evento_id]);
    }
    public function certificados($evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        $organizadores = $evento->organizadores()->withPivot('certificado_creado')->get();
        $ponentes = $evento->ponentes()->withPivot('ponencia', 'certificado_creado')->get();
        $certificados = $evento->certificados;
        return view('admin.certificados', [
            'evento' => $evento,
            'organizadores' => $organizadores,
            'ponentes' => $ponentes,
            'evento_id' => $evento_id,
            'certificados' => $certificados
        ]);
    }
    public function generarCertificadoOrganizadores($evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        $organizadores = $evento->organizadores()->wherePivot('certificado_creado', false)->get();
        foreach ($organizadores as $organizador) {
            Certificado::create([
                'tipo_id' => 4,
                'user_id' => $organizador->id,
                'evento_id' => $evento_id
            ]);
            $evento->organizadores()->updateExistingPivot($organizador->id, ['certificado_creado' => true]);
        }
        return redirect()->route('admin-certificados', ['evento_id' => $evento_id]);
    }
    public function generarCertificadoPonentes($evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        $ponentes = $evento->ponentes()->wherePivot('certificado_creado', false)->get();
        foreach ($ponentes as $ponente) {
            Certificado::create([
                'tipo_id' => 3,
                'user_id' => $ponente->id,
                'evento_id' => $evento_id
            ]);
            $evento->ponentes()->updateExistingPivot($ponente->id, ['certificado_creado' => true]);
        }
        return redirect()->route('admin-certificados', ['evento_id' => $evento_id]);
    }
    public function documento($certificado_id)
    {
        $certificado = Certificado::findOrFail($certificado_id);
        $evento = $certificado->evento;
        $tipo = $certificado->tipo;
        $user = $certificado->usuario;
        $fecha = Carbon::parse($evento->fecha);
        $meses = ["", 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'setiembre', 'octubre', 'noviembre', 'diciembre'];
        $dia = $fecha->day < 10 ? "0" . $fecha->day : $fecha->day;
        $ruta = storage_path('app/private/certificados/' . $evento->certificado_base);
        $base64 = "data:image/png;base64," . base64_encode(file_get_contents($ruta));
        
        $url_certificado = route('documento', ['certificado_id' => $certificado_id]);
        $qr_code = new QrCode(
            data: $url_certificado,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );
        $writer = new PngWriter();
        $result = $writer->write($qr_code);
        $qr_data = $result->getDataUri();
        $pdf =  Pdf::loadView('admin.plantillas.certificado_academico', [
            'evento' => $evento,
            'base64' => $base64,
            'meses' => $meses,
            'dia' => $dia,
            'fecha' => $fecha,
            'tipo' => $tipo,
            'user' => $user,
            'qr_data' => $qr_data,
            'url_certificado' => $url_certificado
        ])->setPaper('a4', 'landscape')->setOption('dpi', 120)->setOption('image_dpi', 300);
        
        return $pdf->stream('certificado.pdf');
    }
    public function exportarOrganizadores($evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        $organizadores = $evento->organizadores()->select('paternal_surname', 'maternal_surname', 'name', 'email')->get();
        return Excel::download(new OrganizadoresExport($organizadores), 'organizadores.xlsx');
    }
}