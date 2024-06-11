# CotizacionesBCU
Little package to get exchanges from Central Uruguayan Bank. 
Pequeño paquete para obtener las cotizaciones del Banco Central del Uruguay.

WORK IN PROGRESS - TRABAJO QUE DA VERGUENZA

```php
use Martintraverso\Cotizacionesbcu\Periodo;
use Martintraverso\Cotizacionesbcu\CotizacionesBCU;

$periodo = new Periodo(new DateTimeImmutable(), new DateTimeImmutable);
$cotizaciones = new CotizacionesBCU();
$cotizaciones->get($periodo);
```

