<?php

namespace App\Http\Controllers;

use App\Models\Municipios;
use Illuminate\Http\Request;

class Componentes extends Controller
{
    /**
     * este metodo devuelve la fecha actual
     * @return string
     */
    public function fechaActual()
    {

        $fecha_dia = date("d");
        $fecha_mes = date("m");
        $fecha_year = date("Y");
        $dia_semana = [
            "Monday" => "Lunes",
            "Tuesday" => "Martes",
            "Wednesday" => "Miercoles",
            "Thursday" => "Jueves",
            "Friday" => "Viernes",
            "Saturday" => "Sabado",
            "Sunday" => "Domingo"
        ];
        $meses_year = [
            "01" => "Enero",
            "02" => "Febrero",
            "03" => "Marzo",
            "04" => "Abril",
            "05" => "Mayo",
            "06" => "Junio",
            "07" => "Julio",
            "08" => "Agosto",
            "09" => "Septiembre",
            "10" => "Octubre",
            "11" => "Noviembre",
            "12" => "Diciembre"
        ];

        return $dia_semana[date("l")] . " " . $fecha_dia . " de " . $meses_year[$fecha_mes] . " de " . $fecha_year;
    }
    /**
     * este metodo devuelve una lista de los municipios de un departamento
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMunicipiosDepartamento($id)
    {
        $municipios = Municipios::where('id_departamento', $id)->get();
        return response()->json($municipios);
    }
}
