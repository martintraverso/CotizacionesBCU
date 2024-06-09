<?php
namespace Martintraverso\Cotizacionesbcu;

use Martintraverso\Cotizacionesbcu\Moneda;
use Martintraverso\Cotizacionesbcu\Periodo;
use Martintraverso\Cotizacionesbcu\Cotizaciones;
use Psr\Cache\CacheItemPoolInterface;

class CotizacionesBCU
{
	public function __construct(private CacheItemPoolInterface $cache){}

	public function get(Moneda $moneda, Periodo $periodo) : Cotizaciones
	{
		return $this->build($moneda, $periodo);
	}

	private function build(Moneda $moneda, Periodo $periodo): Cotizaciones
	{
		$cotizaciones = new Cotizaciones();
		$current = $periodo->getStart();	
		while($current < $periodo->getEnd()) {
			$cacheitem= $current->format('Y-m-d') . $moneda->nombre . 'venta';

			if (!$this->cache->hasItem($cacheitem)) {
				$this->getApi(new Periodo($current, $current));
			}
	
			$cotizaciones->add($this->cache->getItem($cacheitem));
			$current = $current->sum('+1 day');
		}		
		return $cotizaciones;
	}

	private function getAPi(Periodo $periodo): void
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
			foreach ($response['cotizacionesoutlist']['Cotizaciones'] as $cotizacion) {
				$fecha = new \DateTimeInmutable(str_replace(')', '', str_replace('\/Date(' , '', $cotizacion['Fecha'])));
				$item = $this->cache->getItem($fecha->format('Y-m-d') . $cotizacion['CodigoISO'] . 'venta');
				$item->set($cotizacion['TCV']);
				$item2 = $this->cache->getItem($fecha->format('Y-m-d') . $cotizacion['CodigoISO'] . 'compra');
				$item2->set($cotizacion['TCC']);
				$this->cache->save($item);
				$this->cache->save($item2);
			}
	}
}
