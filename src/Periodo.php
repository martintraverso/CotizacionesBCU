<?php
namespace Martintraverso\Cotizacionesbcu;

class Periodo
{
	public function __construct(private \DateTimeInmutable $start, private \DateTimeInmutable $end){}
	
	public function getStart(): \DateTimeInmutable
	{
		return $this->start;
	}

	public function getEnd(): \DateTimeInmutable
	{
		return $this->end;
	}
}
