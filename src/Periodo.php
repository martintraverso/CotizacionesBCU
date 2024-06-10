<?php
namespace Martintraverso\Cotizacionesbcu;

class Periodo
{
	public function __construct(private \DateTimeImmutable $start, private \DateTimeImmutable $end){}
	
	public function getStart(): \DateTimeImmutable
	{
		return $this->start;
	}

	public function getEnd(): \DateTimeImmutable
	{
		return $this->end;
	}
}
