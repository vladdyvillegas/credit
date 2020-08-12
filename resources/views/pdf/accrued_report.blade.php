<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Reporte de cuotas en mora de gestiones cerradas</title>
    <link rel="stylesheet" href="assets/css/style.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <!-- <div id="logo">
        <img src="assets/css/logo.png">
      </div> -->
      <h1>PAGOS EN MORA ACUMULADOS GESTIONES CERRADAS @if($type=='PROPIO') ENDULZA PROPIOS @else ENDULZA FINANCIERA @endif</h1>
      <h3>Al {{ date('d-m-Y', strtotime($date_report)) }}, Expresado en dólares</h3>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="desc">OPERACIÓN</th>
            <th class="desc">NOMBRE DE CLIENTE</th>
            <th>FECHA DE <br /> VENCIMIENTO</th>
            <th>FECHA <br /> DE PAGO</th>
            <th>MONTO <br /> PAGADO</th>
            <th>NRO. DE <br /> COMPROBANTE</th>
          </tr>
        </thead>
        <tbody>
          <?php
              $sum_monto = 0;
          ?>
          @foreach($payments as $payment)
            @if($payment->accrued_past_payment_date != null)
              <tr>
                <td class="desc">{{ $payment->operation }}</td>
                <td class="desc">{{ $payment->name }}</td>
                <td>{{ $payment->expiration_date }}</td>
                <td>{{ $payment->accrued_past_payment_date }}</td>
                <td class="unit">{{ number_format($payment->interest_accrued_past, 2, '.', ',') }}</td>
                <td>{{ $payment->accrued_past_payment_date }}</td>
              </tr>
              <?php
                  $sum_monto = $sum_monto + $payment->interest_accrued_past;
              ?>
            @endif
          @endforeach
          <tr>
            <td class="grand total">TOTAL</td>
            <td class="grand total"></td>
            <td class="grand total"></td>
            <td class="grand total"></td>
            <td class="grand total">{{ number_format($sum_monto, 2, '.', ',') }}</td>
            <td class="grand total"></td>
          </tr>
        </tbody>
      </table>
    </main>
    <footer>
      Credit Portfolio Manager by PaperPlane &copy;2017
    </footer>
  </body>
</html>
