<?php
namespace Martintraverso\Cotizacionesbcu;

use Martintraverso\Cotizacionesbcu\Moneda;
use Martintraverso\Cotizacionesbcu\Periodo;
use Martintraverso\Cotizacionesbcu\Cotizaciones;
use Martintraverso\Cotizacionesbcu\Cotizacion;

class CotizacionesBCU
{

	public function get(Periodo $periodo) : Cotizaciones
	{
		$cotizaciones = new Cotizaciones();
		$response = $this->getApi($periodo);
		foreach ($response['cotizacionesoutlist']['Cotizaciones'] as $cotizacion) {
			$cotizaciones->add(Cotizacion::fromResponse($cotizacion));
		}
		return $cotizaciones;
	}

	private function getAPi(Periodo $periodo): mixed
	{
		$url = 'https://www.bcu.gub.uy/_layouts/15/BCU.Cotizaciones/handler/CotizacionesHandler.ashx?op=getcotizaciones';
		$data = json_encode([
			"KeyValuePairs" => [
				"Monedas" => [["Val" => 0, "Text" => "TODAS"]],
				"FechaDesde" => $periodo->getStart()->format('d/m/Y'), 
				"FechaHasta" => $periodo->getEnd()->format('d/m/Y'), 
				"Grupo" => "2"
			]
		]);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_ENCODING, '');	
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($data)]);
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, false );
	
		$response = json_decode(curl_exec($curl), TRUE);
		var_dump(curl_errno($curl));
		curl_close($curl);
		return $response;	
	}
}
