<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Reporte de cartera de créditos</title>
    <link rel="stylesheet" href="assets/css/style.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <!-- <div id="logo">
        <img src="assets/css/logo.png">
      </div> -->
      <h1>CREDITOS DIRECTOS @if($type=='PROPIO') ENDULZA PROPIOS @else ENDULZA FINANCIERA @endif</h1>
      <h3>Al {{ date('d-m-Y', strtotime($date_report)) }}, Expresado en dólares</h3>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">OP.</th>
            <th class="desc">CLIENTE</th>
            <th>PRIMER <br /> PAGO</th>
            <th>ULTIMO <br /> PAGO</th>
            <th>MONTO <br /> CREDITO</th>
            <th>CAPITAL</th>
            <th>INTERES</th>
            <th>INTERES <br /> P/MORA</th>
            <th>UBICAR</th>
            <th>SEGURO</th>
            <th>CARGOS</th>
            <th>SEGURO <br /> DESGRAV.</th>
            <th>SALDO</th>
            <th>CUOTAS <br />MORA</th>
            <th>PLAN DE <br /> CUOTAS</th>
            <th>PLAN DE <br /> PAGOS</th>
          </tr>
        </thead>
        <tbody>
          <?php
              $dealer = 4;
              $sum_amount = 0;
              $sum_capital = 0;
              $sum_interest = 0;
              $sum_interest_late = 0;
              $sum_ubicar = 0;
              $sum_assure = 0;
              $sum_charges = 0;
              $sum_disgrace = 0;
              $sum_balance = 0;
          ?>
          @foreach($payments as $payment)
            @if($payment->request_date<=$date_report)
              @if($payment->dealer_id==$dealer)
                  <tr>
                    <td colspan="16">&nbsp;</td>
                  </tr>
                  <?php $dealer = 0; ?>
              @endif
                  <tr>
                    <td class="desc">{{ $payment->operation }}</td>
                    <td class="desc">{{ $payment->name }} @if($payment->status=="LIT") (EN LITIGIO) @endif</td>
                    <td>{{ $payment->application_date }}</td>
                    <td>{{ $payment->payment_date }}</td>
                    @if($payment->status=="REC")
                        <td colspan="10">RECUPERADO POR MORA</td>
                    @elseif ($payment->status=="RES")
                        <td colspan="10">RESCINDIDO POR MUTUO ACUERDO</td>
                    @else
                      <td class="unit">{{ number_format($payment->amount+$payment->service_1+$payment->service_2, 2, '.', ',') }}</td>
                      <td class="unit">@if($payment->last_payment_date<>'') {{ number_format($payment->capital+$payment->amortization_fee, 2, '.', ',') }} @else {{ number_format(0, 2, '.', ',') }} @endif </td>
                      <td class="unit">@if($payment->last_payment_date<>'') {{ number_format($payment->interest, 2, '.', ',') }} @else {{ number_format(0, 2, '.', ',') }} @endif </td>
                      <td class="unit">@if($payment->last_payment_date<>'') {{ number_format($payment->interest_late, 2, '.', ',') }} @else {{ number_format(0, 2, '.', ',') }} @endif </td>
                      <td class="unit">@if($payment->last_payment_date<>'') {{ number_format($payment->ubicar, 2, '.', ',') }} @else {{ number_format(0, 2, '.', ',') }} @endif </td>
                      <td class="unit">@if($payment->last_payment_date<>'') {{ number_format($payment->assure, 2, '.', ',') }} @else {{ number_format(0, 2, '.', ',') }} @endif </td>
                      <td class="unit">@if($payment->last_payment_date<>'') {{ number_format($payment->charges, 2, '.', ',') }} @else {{ number_format(0, 2, '.', ',') }} @endif </td>
                      <td class="unit">@if($payment->last_payment_date<>'') {{ number_format($payment->disgrace, 2, '.', ',') }} @else {{ number_format(0, 2, '.', ',') }} @endif </td>
                      <td class="unit">@if($payment->last_payment_date<>'') {{ number_format($payment->balance, 2, '.', ',') }} @else {{ number_format($payment->amount+$payment->service_1+$payment->service_2, 2, '.', ',') }} @endif </td>
                      <td>
                        <?php
                            $delayed = 0;
                            if($payment->payment_date<>null){
                                 $expiration = date('Y-m-d', strtotime($payment->expiration_date));
                            } else {
                                 $expiration = date('Y-m-d', strtotime($date_report));
                            }
                            while ($expiration <= $date_report) {
                               for ($y = 1; $y <= 12/$payment->payment_term; $y++) {
                                 $num = cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($expiration)), date('Y', strtotime($expiration)));
                                 $expiration = date('Y-m-d', strtotime($expiration.'+'.$num.' day'));
                               }
                               $delayed++;
                            }
                            if ($payment->balance==0 or $delayed<=0) {
                                echo 0;
                            } else {
                                if (($payment->total_payment-$payment->payment)>($delayed-1)) {
                                    if ($payment->next_payment > $payment->payment) {
                                        echo $delayed-1;
                                    } else {
                                        echo $delayed;
                                    }
                                } else {
                                   echo $payment->total_payment-$payment->payment;
                                }
                            }
                        ?>
                      </td>
                    @endif
                    <td>@if($payment->next_payment<>'') {{ $payment->next_payment-1 }} / {{ $payment->total_payment }} @else {{ $payment->total_payment }} / {{ $payment->total_payment }} @endif </td>
                    <td>
                      <?php
                        switch ($payment->payment_term) {
                          case 12:  echo "Mensual"; break;
                          case 6:   echo "Bimestral"; break;
                          case 4:   echo "Trimestral"; break;
                          case 2:   echo "Semestral"; break;
                          case 1:   echo "Anual"; break;
                        }
                      ?>
                    </td>
                  </tr>
              <?php
                  if ($payment->status=='REC' or $payment->status=='RES') {
                      $payment->amount = 0;
                      $payment->service_1 = 0;
                      $payment->service_2 = 0;
                      $payment->capital = 0;
                      $payment->amortization_fee = 0;
                      $payment->interest = 0;
                      $payment->interest_late = 0;
                      $payment->ubicar = 0;
                      $payment->assure = 0;
                      $payment->charges = 0;
                      $payment->disgrace = 0;
                      $payment->balance = 0;
                  }
                  $sum_amount = $sum_amount + ($payment->amount+$payment->service_1+$payment->service_2);
                  if ($payment->last_payment_date<>'') { $sum_capital = $sum_capital + ($payment->capital+$payment->amortization_fee); } else { $sum_capital = $sum_capital + 0; }
                  if ($payment->last_payment_date<>'') { $sum_interest = $sum_interest + $payment->interest; } else { $sum_interest = $sum_interest + 0; }
                  if ($payment->last_payment_date<>'') { $sum_interest_late = $sum_interest_late + $payment->interest_late; } else { $sum_interest_late = $sum_interest_late + 0; }
                  if ($payment->last_payment_date<>'') { $sum_ubicar = $sum_ubicar + $payment->ubicar; } else { $sum_ubicar = $sum_ubicar + 0; }
                  if ($payment->last_payment_date<>'') { $sum_assure = $sum_assure + $payment->assure; } else { $sum_assure = $sum_assure + 0; }
                  if ($payment->last_payment_date<>'') { $sum_charges = $sum_charges + $payment->charges; } else { $sum_charges = $sum_charges + 0; }
                  if ($payment->last_payment_date<>'') { $sum_disgrace = $sum_disgrace + $payment->disgrace; } else { $sum_disgrace = $sum_disgrace + 0; }
                  if ($payment->last_payment_date<>'') { $sum_balance = $sum_balance + $payment->balance; } else { $sum_balance = $sum_balance + ($payment->amount+$payment->service_1+$payment->service_2); }
              ?>
            @endif
          @endforeach
          <tr>
            <td colspan="4" class="grand total">TOTAL</td>
            <td class="grand total">{{ number_format($sum_amount, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_capital, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_interest, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_interest_late, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_ubicar, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_assure, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_charges, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_disgrace, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_balance, 2, '.', ',') }}</td>
            <td class="grand total"></td>
            <td class="grand total"></td>
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
