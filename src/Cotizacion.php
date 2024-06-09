<?php

namespace Martintraverso\Cotizacionesbcu;

class Cotizacion
{
	public function __construct(public Moneda $moneda, public string $valor){}
}
