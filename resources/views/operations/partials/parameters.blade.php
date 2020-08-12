<?php
    $ubicar = 230;  // Costo anual por el servicio de localización
    $seguro_rate = 0.03; // Prcentaje sobre el valor del producto para calcular el costo anual del seguro automotor
    $cargos = 2;    // Costo mensual por gastos administrativos
    $seguro_desgravamen1 = 0.0008; // Porcentaje del seguro cuando es 1 persona
    $seguro_desgravamen2 = 0.0005; // Porcentaje del seguro cuando son 2 personas
    if($operations->service_1 == null && $operations->service_2 == null){
        $ubicar = 0;
        $seguro_rate = 0;
    }
?>
