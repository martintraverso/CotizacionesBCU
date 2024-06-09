<?php 
namespace Martintraverso\Cotizacionesbcu;

class Cotizaciones
{
	private mixed $cotizaciones;

	public function add(Cotizacion $cotizacion)
	{ 
		$this->cotizaciones[] = $cotizacion;	
	}

	public function get(){
		return $this->cotizaciones;
	}
}
