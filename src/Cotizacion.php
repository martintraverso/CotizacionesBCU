<?php

namespace Martintraverso\Cotizacionesbcu;

class Cotizacion
{
	private $compra;
	private $venta;
	private $moneda;
	private $arbitraje;

	public function setCompra($compra)
	{
		$this->compra = $compra;
		return $this;
	}
	
	public function getCompra()
	{
		return $this->compra;
	}

	public function setVenta($venta)
	{
		$this->venta = $venta;
		return $this;
	}

	public function getVenta()
	{
		return $this->venta;
	}
	public function setMoneda($moneda)
	{
		$this->moneda = $moneda;
		return $this;
	}
	
	public function getMoneda()
	{
		return $this->moneda;
	}

	public function setArbitraje($arbitraje)
	{
		$this->arbitraje = $arbitraje;
		return $this;
	}

	public function getArbitraje()
	{
		return $this->arbitraje;
	}

	public static function fromResponse(mixed $data): self
	{
		$class = new Cotizacion();	
		$class->setVenta($data['TCV'])
			->setCompra($data['TCC'])
			->setMoneda($data['CodigoISO'])
			->setArbitraje($data['ArbAct']);
		return $class;
	}
}
