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
        <tr><td></td><td>0</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>{{ number_format($operation->amount+$operation->service_1+$operation->service_2, 2, '.', ',') }}</td></tr>
        @foreach($payments as $payment)
          <?php if ($payment->payment>=$operation->next_payment) { ?>

            <?php if ($payment->payment==$operation->next_payment) {
              $a1 = (($operation->annual_interest_rate)/100)/$operation->payment_term;
              $b1 = $term - $payment->payment;
              $c1 = $payment->balance-$capital_fee;
              $cuota = ($a1*(1+$a1)**$b1)*$c1/(((1+$a1)**$b1)-1);

              $interes = $a1*$c1;
              $seguro_desgravamen = $c1*($operation->disgrace_insurance_rate/100)*(360/$operation->payment_term/30);
              $saldo = $c1-($cuota-$interes);
            ?>
              <tr>
                <td>@if($payment->payment<$operation->next_payment) <span class="label label-success">Pagado</span> @elseif($payment->payment==$operation->next_payment) <span class="label label-warning">Amortizando</span> @endif</td>
                <td>{{ $payment->payment }} <input type="hidden" name="id_payment_b[]" id="id_payment_b" value="{{ $payment->id }}"><input type="hidden" name="payment_b[]" id="payment_b" value="{{ $payment->payment }}"></td>
                <td>{{ $payment->expiration_date }}</td>
                <td>{{ $days_late }} <input type="hidden" name="payment_date_b[]" id="payment_date_b" value="{{ $amort_date }}"><input type="hidden" name="expiration_date_b[]" id="expiration_date_b" value="{{ $payment->expiration_date }}"></td>
                <td>{{ $payment->fixed_fee }} <input type="hidden" name="fixed_fee_b[]" id="fixed_fee_b" value="{{ $payment->fixed_fee }}"></td>
                <td>{{ $payment->capital }} <input type="hidden" name="capital_b[]" id="capital_b" value="{{ $payment->capital }}"></td>
                <td>{{ $payment->interest }} <input type="hidden" name="interest_b[]" id="interest_b" value="{{ $payment->interest }}"></td>
                <td>{{ number_format($payment->interest_late+$interest_late, 2, '.', ',') }} <input type="hidden" name="interest_late_b[]" id="interest_late_b" value="{{ $payment->interest_late+$interest_late }}"></td>
                <td>{{ number_format($interest_accrued-($payment->interest_late+$interest_late), 2, '.', ',') }} <input type="hidden" name="interest_accrued_b[]" id="interest_accrued_b" value="{{ $interest_accrued-($payment->interest_late+$interest_late) }}"></td>
                <td>{{ $payment->charges }} <input type="hidden" name="charges_b[]" id="charges_b" value="{{ $payment->charges }}"></td>
                <td>{{ $payment->disgrace }} <input type="hidden" name="disgrace_b[]" id="disgrace_b" value="{{ $payment->disgrace }}"></td>
                <td>{{ number_format($payment->variable_fee+$interest_late+$capital_fee, 2, '.', ',') }} <input type="hidden" name="variable_fee_b[]" id="variable_fee_b" value="{{ $payment->variable_fee+$interest_late+$capital_fee }}"></td>
                <td>{{ number_format($payment->balance-$capital_fee, 2, '.', ',') }} <input type="hidden" name="balance_b[]" id="balance_b" value="{{ $payment->balance-$capital_fee }}"><input type="hidden" name="amortization_fee_b[]" id="amortization_fee_b" value="{{ $capital_fee }}"></td></td>
              </tr>
            <?php } else { $dias = 0; $mora = 0; ?>
              <tr>
                <td>@if($payment->payment<$operation->next_payment) <span class="label label-success">Pagado</span> @elseif($payment->payment==$operation->next_payment) <span class="label label-warning">Amortizando</span> @endif</td>
                <td>{{ $payment->payment }} <input type="hidden" name="id_payment_b[]" id="id_payment_b" value="{{ $payment->id }}"><input type="hidden" name="payment_b[]" id="payment_b" value="{{ $payment->payment }}"></td>
                <td>{{ $payment->expiration_date }}</td>
                <td>{{ $dias }} <input type="hidden" name="payment_date_b[]" id="payment_date_b" value=""><input type="hidden" name="expiration_date_b[]" id="expiration_date_b" value="{{ $payment->expiration_date }}"></td>
                <td>{{ number_format($cuota, 2, '.', ',') }} <input type="hidden" name="fixed_fee_b[]" id="fixed_fee_b" value="{{ $cuota }}"></td>
                <td>{{ number_format($cuota-$interes, 2, '.', ',') }} <input type="hidden" name="capital_b[]" id="capital_b" value="{{ $cuota-$interes }}"></td>
                <td>{{ number_format($interes, 2, '.', ',') }} <input type="hidden" name="interest_b[]" id="interest_b" value="{{ $interes }}"></td>
                <td>{{ number_format($payment->interest_late, 2, '.', ',') }} <input type="hidden" name="interest_late_b[]" id="interest_late_b" value="{{ $payment->interest_late }}"></td>
                <td>{{ $payment->interest_accrued }} <input type="hidden" name="interest_accrued_b[]" id="interest_accrued_b" value="{{ $payment->interest_accrued }}"></td>
                <td>{{ $payment->charges }} <input type="hidden" name="charges_b[]" id="charges_b" value="{{ $payment->charges }}"></td>
                <td>{{ number_format($seguro_desgravamen, 2, '.', ',') }} <input type="hidden" name="disgrace_b[]" id="disgrace_b" value="{{ $seguro_desgravamen }}"></td>
                <td>{{ number_format($cuota+$mora+$payment->charges+$seguro_desgravamen, 2, '.', ',') }} <input type="hidden" name="variable_fee_b[]" id="variable_fee_b" value="{{ $cuota+$mora+$payment->charges+$seguro_desgravamen }}"></td>
                <td>{{ number_format($saldo, 2, '.', ',') }} <input type="hidden" name="balance_b[]" id="balance_b" value="{{ $saldo }}"><input type="hidden" name="amortization_fee_b[]" id="amortization_fee_b" value="0"></td>
              </tr>
            <?php
              $interes = $a1*$saldo;
              $seguro_desgravamen = $saldo*($operation->disgrace_insurance_rate/100)*(360/$operation->payment_term/30);
              $saldo = $saldo-($cuota-$interes);
            } ?>

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
          {!! Form::submit('Procesar', ['id'=>'amort_b', 'name'=>'amort_b', 'class'=>'btn btn-success']) !!}
      </div>
  </div>
