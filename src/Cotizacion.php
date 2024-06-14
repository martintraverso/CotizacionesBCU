<?php

namespace Martintraverso\Cotizacionesbcu;

class Cotizacion
{
	private float $compra;
	private float $venta;
	private string $moneda;
	private string $nombre;
	private float $arbitraje;
	private string $emisor;
	private \DateTimeImmutable $fecha;

	public function __construct(array $data)
	{
		$this->setVenta($data['TCV']);
		$this->setCompra($data['TCC']);
		$this->setMoneda($data['CodigoISO']);
		$this->setNombre($data['Nombre']);
		$this->setArbitraje($data['ArbAct']);
		$this->setEmisor($data['Emisor']);
		$this->setFecha($data['Fecha']);

	}

	public static function fromResponse(mixed $data): self
	{
		return new self($data);	
	}

	public function setCompra(float $compra): self 
	{
		$this->compra = $compra;
		return $this;
	}
	
	public function getCompra(): float
	{
		return $this->compra;
	}

	public function setVenta(float $venta): self
	{
		$this->venta = $venta;
		return $this;
	}

	public function getVenta(): float
	{
		return $this->venta;
	}

	public function setMoneda(string $moneda): self
	{
		$this->moneda = $moneda;
		return $this;
	}
	
	public function getMoneda(): string
	{
		return $this->moneda;
	}

	public function setArbitraje(float $arbitraje): self
	{
		$this->arbitraje = $arbitraje;
		return $this;
	}

	public function getArbitraje(): float
	{
		return $this->arbitraje;
	}

	public function setEmisor(string $emisor): self
	{
		$this->emisor = $emisor;
		return $this;
	}

	public function getEmisor(): string
	{
		return $this->emisor;
	}

	public function setNombre(string $nombre): self
	{
		$this->nombre = $nombre;
		return $this;
	}

	public function getNombre(): string
	{
		return $this->nombre;
	}

	public function setFecha(string $fecha): self
	{
		$this->fecha = (new \DateTimeImmutable())->setTimestamp(substr(trim(trim($fecha, '/Date('), ')'), 0, 10));
		return $this;
	}

	public function getFecha(): \DateTimeImmutable
	{
		return $this->fecha;
	}

}
