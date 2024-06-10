<?php
namespace Martintraverso\Cotizacionesbcu;

use Martintraverso\Cotizacionesbcu\Moneda;
use Martintraverso\Cotizacionesbcu\Periodo;
use Martintraverso\Cotizacionesbcu\Cotizaciones;
use Psr\Cache\CacheItemPoolInterface;

class CotizacionesBCU
{

	public function get(Moneda $moneda, Periodo $periodo) : Cotizaciones
	{
		return $this->build($moneda, $periodo);
	}

	private function build(Moneda $moneda, Periodo $periodo): Cotizaciones
	{
		$cotizaciones = new Cotizaciones();
		$current = $periodo->getStart();	
		$response = $this->getApi($periodo->getStart(), $periodo->getEnd());
		foreach ($response['cotizacionesoutlist']['Cotizaciones'] as $cotizacion) {
			$fecha = new \DateTimeInmutable(str_replace(')', '', str_replace('\/Date(' , '', $cotizacion['Fecha'])));
			$cotizaciones->add(Cotizacion::fromResponse($cotizacion));
		}
		return $cotizaciones;
	}

	private function getAPi(Periodo $periodo): mixed
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
  			CURLOPT_URL => 'https://www.bcu.gub.uy/_layouts/15/BCU.Cotizaciones/handler/CotizacionesHandler.ashx?op=getcotizaciones',
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>'{"KeyValuePairs":{"Monedas":[{"Val":"0","Text":"TODAS"}],"FechaDesde":"' . $periodo->getStart()->format('d/m/Y') . '","FechaHasta":"' . $periodo->getEnd()->format('d/m/Y'). ',"Grupo":"2"}}',
			CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
));

			$response = json_decode(curl_exec($curl), TRUE);
			curl_close($curl);
			return $response;	
	}
}
