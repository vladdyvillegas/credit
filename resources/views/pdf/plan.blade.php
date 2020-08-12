<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Plan de pagos</title>
    <link rel="stylesheet" href="assets/css/style2.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="assets/css/logo.png">
      </div>
      <h1>PLAN DE PAGOS</h1>
      <h3>Al {{ date('d-m-Y') }}, Epresado en dólares</h3>
      <!-- <div id="company" class="clearfix">
        <div> 796 Silver Harbour, TX 79273, US</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
      </div> -->
      <div id="project">
        <div><span>OPERACION</span>{{ $operation->operation }}</div>
        <div><span>CLIENTE</span>{{ $operation->client->name }}</div>
        <div><span>{{ $operation->client->type_id_document }} CLIENTE</span>{{ $operation->client->id_document }}</div>
        <div><span>PRODUCTO</span>{{ $operation->product->name }}</div>
      </div>
      <div id="project">
        <div><span>PRECIO PRODUCTO</span>{{ number_format($operation->product_price, 2, '.', ',') }}</div>
        <div><span>APORTE PROPIO</span>-{{ number_format($operation->own_input, 2, '.', ',') }}</div>
        <div><span>UBICAR</span>{{ number_format($operation->service_1, 2, '.', ',') }}</div>
        <div><span>SEGURO AUTOMOTOR</span>{{ number_format($operation->service_2, 2, '.', ',') }}</div>
        <div><span>TOTAL CREDITO</span>{{ number_format($operation->amount+$operation->service_1+$operation->service_2, 2, '.', ',') }}</div>
      </div>
      <div id="project">
        <div><span>INTERES</span>{{ $operation->annual_interest_rate }}% anual</div>
        <div><span>PLAZO</span>{{ $operation->monthly_term*$operation->payment_term }} meses</div>
        <div><span>FRECUENCIA</span>{{ 360/$operation->payment_term }} días</div>
        <div><span>IND. SEG. DESG.</span>{{ number_format($operation->disgrace_insurance_rate, 2, '.', ',') }}%</div>
      </div>
    </header>
    <br />
    <main>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>FECHA <br /> VENCIMIENTO</th>
            <th>FECHA <br /> PAGO</th>
            <th>CUOTA <br /> FIJA</th>
            <th>CAPITAL</th>
            <th>INTERES</th>
            <th>INTERES <br /> P/MORA</th>
            <th>CARGOS</th>
            <th>SEGURO <br /> DESGRAV.</th>
            <th>CUOTA <br /> VARIABLE</th>
            <th>SALDO</th>
          </tr>
        </thead>
        <tbody>
          <?php
              $sum_fixed_fee = 0;
              $sum_capital = 0;
              $sum_interest = 0;
              $sum_interest_late = 0;
              $sum_charges = 0;
              $sum_disgrace = 0;
              $sum_variable_fee = 0;
              $sum_balance = 0;
          ?>
          <tr><td>0</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td class="unit">{{ number_format($operation->amount+$operation->service_1+$operation->service_2, 2, '.', ',') }}</td></tr>
          @foreach($payments as $payment)
            <tr>
              <td>{{ $payment->payment }}</td>
              <td>{{ $payment->expiration_date }}</td>
              <td>{{ $payment->payment_date }}</td>
              <td class="unit">{{ number_format($payment->fixed_fee, 2, '.', ',') }}</td>
              <td class="unit">{{ number_format($payment->capital+$payment->amortization_fee, 2, '.', ',') }}</td>
              <td class="unit">{{ number_format($payment->interest, 2, '.', ',') }}</td>
              <td class="unit">{{ number_format($payment->interest_late, 2, '.', ',') }}</td>
              <td class="unit">{{ number_format($payment->charges, 2, '.', ',') }}</td>
              <td class="unit">{{ number_format($payment->disgrace, 2, '.', ',') }}</td>
              <td class="unit">{{ number_format($payment->variable_fee, 2, '.', ',') }}</td>
              <td class="unit">{{ number_format($payment->balance, 2, '.', ',') }}</td>
            </tr>
            <?php
                $sum_fixed_fee = $sum_fixed_fee + $payment->fixed_fee;
                $sum_capital = $sum_capital + $payment->capital;
                $sum_interest = $sum_interest + $payment->interest;
                $sum_interest_late = $sum_interest_late + $payment->interest_late;
                $sum_charges = $sum_charges + $payment->charges;
                $sum_disgrace = $sum_disgrace + $payment->disgrace;
                $sum_variable_fee = $sum_variable_fee + $payment->variable_fee;
            ?>
          @endforeach
          <tr>
            <td colspan="3" class="grand total">TOTAL</td>
            <td class="grand total">{{ number_format($sum_fixed_fee, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_capital, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_interest, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_interest_late, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_charges, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_disgrace, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_variable_fee, 2, '.', ',') }}</td>
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
