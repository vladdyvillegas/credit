  <table class="table table-striped jambo_table bulk_action">
      <thead>
        <tr class="headings">
          <th class="column-title"> </th>
          <th class="column-title"># </th>
          <th class="column-title">Vencimiento </th>
          <th class="column-title">Días mora </th>
          <th class="column-title">PPP </th>
          <th class="column-title">Capital </th>
          <th class="column-title">Interés </th>
          <th class="column-title">Int.Mora</th>
          <th class="column-title">Int.Acum</th>
          <th class="column-title">Cargos </th>
          <th class="column-title">Seg.Desg. </th>
          <th class="column-title">Cuota </th>
          <th class="column-title">Saldo </th>
        </tr>
      </thead>
      <tbody>
        <tr><td></td><td><input type="hidden" name="record">0</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>{{ number_format($operation->amount+$operation->service_1+$operation->service_2, 2, '.', ',') }}</td></tr>
        @foreach($payments as $payment)
          <?php if ($payment->payment>=$operation->next_payment) { ?>

            <?php if ($payment->payment==$operation->next_payment) {
              $a1 = (($operation->annual_interest_rate)/100)/$operation->payment_term;
              $b1 = $term - $payment->payment;
              $c1 = $payment->balance-$capital_fee;
              if ($payment->fixed_fee>$c1) { $cuota = $c1; }
              else { $cuota = $payment->fixed_fee; }

              $interes = $a1*$c1;
              $seguro_desgravamen = $c1*($operation->disgrace_insurance_rate/100)*(360/$operation->payment_term/30);
              $saldo = $c1-($cuota-$interes);
            ?>
              <tr>
                <td>@if($payment->payment<$operation->next_payment) <span class="label label-success">Pagado</span> @elseif($payment->payment==$operation->next_payment) <span class="label label-warning">Amortizando</span> @endif</td>
                <td>{{ $payment->payment }} <input type="hidden" name="id_payment_c[]" id="id_payment_c" value="{{ $payment->id }}"><input type="hidden" name="payment_c[]" id="payment_c" value="{{ $payment->payment }}"></td>
                <td>{{ $payment->expiration_date }}</td>
                <td>{{ $days_late }} <input type="hidden" name="payment_date_c[]" id="payment_date_c" value="{{ $amort_date }}"><input type="hidden" name="expiration_date_c[]" id="expiration_date_c" value="{{ $payment->expiration_date }}"></td>
                <td>{{ $payment->fixed_fee }} <input type="hidden" name="fixed_fee_c[]" id="fixed_fee_c" value="{{ $payment->fixed_fee }}"></td>
                <td>{{ $payment->capital }} <input type="hidden" name="capital_c[]" id="capital_c" value="{{ $payment->capital }}"></td>
                <td>{{ $payment->interest }} <input type="hidden" name="interest_c[]" id="interest_c" value="{{ $payment->interest }}"></td>
                <td>{{ number_format($payment->interest_late+$interest_late, 2, '.', ',') }} <input type="hidden" name="interest_late_c[]" id="interest_late_c" value="{{ $payment->interest_late+$interest_late }}"></td>
                <td>{{ number_format($interest_accrued-($payment->interest_late+$interest_late), 2, '.', ',') }} <input type="hidden" name="interest_accrued_c[]" id="interest_accrued_c" value="{{ $interest_accrued-($payment->interest_late+$interest_late) }}"></td>
                <td>{{ $payment->charges }} <input type="hidden" name="charges_c[]" id="charges_c" value="{{ $payment->charges }}"></td>
                <td>{{ $payment->disgrace }} <input type="hidden" name="disgrace_c[]" id="disgrace_c" value="{{ $payment->disgrace }}"></td>
                <td>{{ number_format($payment->variable_fee+$interest_late+$capital_fee, 2, '.', ',') }} <input type="hidden" name="variable_fee_c[]" id="variable_fee_c" value="{{ $payment->variable_fee+$interest_late+$capital_fee }}"></td>
                <td>{{ number_format($payment->balance-$capital_fee, 2, '.', ',') }} <input type="hidden" name="balance_c[]" id="balance_c" value="{{ $payment->balance-$capital_fee }}"><input type="hidden" name="amortization_fee_c[]" id="amortization_fee_c" value="{{ $capital_fee }}"></td>
              </tr>
            <?php } else { $dias = 0; $mora = 0; ?>
              <tr>
                <td>@if($payment->payment<$operation->next_payment) <span class="label label-success">Pagado</span> @elseif($payment->payment==$operation->next_payment) <span class="label label-warning">Amortizando</span> @endif</td>
                <td>{{ $payment->payment }} <input type="hidden" name="id_payment_c[]" id="id_payment_c" value="{{ $payment->id }}"><input type="hidden" name="payment_c[]" id="payment_c" value="{{ $payment->payment }}"></td>
                <td>{{ $payment->expiration_date }}</td>
                <td>{{ $dias }} <input type="hidden" name="payment_date_c[]" id="payment_date_c" value=""><input type="hidden" name="expiration_date_c[]" id="expiration_date_c" value="{{ $payment->expiration_date }}"></td>
                <td>{{ number_format($cuota, 2, '.', ',') }} <input type="hidden" name="fixed_fee_c[]" id="fixed_fee_c" value="{{ $cuota }}"></td>
                <td>{{ number_format($cuota-$interes, 2, '.', ',') }} <input type="hidden" name="capital_c[]" id="capital_c" value="{{ $cuota-$interes }}"></td>
                <td>{{ number_format($interes, 2, '.', ',') }} <input type="hidden" name="interest_c[]" id="interest_c" value="{{ $interes }}"></td>
                <td>{{ number_format($payment->interest_late, 2, '.', ',') }} <input type="hidden" name="interest_late_c[]" id="interest_late_c" value="{{ $payment->interest_late }}"></td>
                <td>{{ $payment->interest_accrued }} <input type="hidden" name="interest_accrued_c[]" id="interest_accrued_c" value="{{ $payment->interest_accrued }}"></td>
                <td>{{ $payment->charges }} <input type="hidden" name="charges_c[]" id="charges_c" value="{{ $payment->charges }}"></td>
                <td>{{ number_format($seguro_desgravamen, 2, '.', ',') }} <input type="hidden" name="disgrace_c[]" id="disgrace_c" value="{{ $seguro_desgravamen }}"></td>
                <td>{{ number_format($cuota+$mora+$payment->charges+$seguro_desgravamen, 2, '.', ',') }} <input type="hidden" name="variable_fee_c[]" id="variable_fee_c" value="{{ $cuota+$mora+$payment->charges+$seguro_desgravamen }}"></td>
                <td>{{ number_format($saldo, 2, '.', ',') }} <input type="hidden" name="balance_c[]" id="balance_c" value="{{ $saldo }}"><input type="hidden" name="amortization_fee_c[]" id="amortization_fee_c" value="0"></td>
              </tr>
            <?php
              if ($payment->fixed_fee>$saldo) {
                $cuota = $saldo;
                $interes = 0;
                $seguro_desgravamen = 0;
                $saldo = 0;
              }
              else {
                $cuota = $payment->fixed_fee;
                $interes = $a1*$saldo;
                $seguro_desgravamen = $saldo*($operation->disgrace_insurance_rate/100)*(360/$operation->payment_term/30);
                $saldo = $saldo-($cuota-$interes);
              }

            } ?>
            @if ($cuota==0) @break; @endif
          <?php } else { $dias = 0; $mora = 0; ?>
            <tr>
              <td>@if($payment->payment<$operation->next_payment) <span class="label label-success">Pagado</span> @elseif($payment->payment==$operation->next_payment) <span class="label label-warning">Amortizando</span> @endif</td>
              <td>{{ $payment->payment }} </td>
              <td>{{ $payment->expiration_date }}</td>
              <td>{{ $dias }} </td>
              <td>{{ $payment->fixed_fee }}</td>
              <td>{{ $payment->capital }}</td>
              <td>{{ $payment->interest }}</td>
              <td>{{ number_format($payment->interest_late+$mora, 2, '.', ',') }}</td>
              <td>{{ $payment->interest_accrued }}</td>
              <td>{{ $payment->charges }}</td>
              <td>{{ $payment->disgrace }}</td>
              <td>{{ number_format($payment->variable_fee+$mora, 2, '.', ',') }}</td>
              <td>{{ number_format($payment->balance, 2, '.', ',') }}</td>
            </tr>
          <?php } ?>
        @endforeach
      </tbody>
  </table>
  <div class="x_panel">
      <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-4">
          {!! Form::submit('Procesar', ['id'=>'amort_c', 'name'=>'amort_c', 'class'=>'btn btn-success']) !!}
      </div>
  </div>
