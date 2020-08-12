  <table class="table table-striped jambo_table bulk_action">
      <thead>
        <tr class="headings">
            <th class="column-title"> </th>
            <th class="column-title"># </th>
            <th class="column-title">Vencimiento </th>
            <th class="column-title">Días mora </th>
            <th class="column-title">PPP </th>
            <th class="column-title">Capital </th>
            <th class="column-title">Cap.Amort.</th>
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
        <tr><td></td><td>0</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>{{ number_format($operation->amount+$operation->service_1+$operation->service_2, 2, '.', ',') }}</td></tr>
        @foreach($payments as $payment)
          <?php if ($payment->payment>=$operation->next_payment) { ?>

            <?php
                if ($payment->payment==$operation->next_payment) {
                    $dias = $days_late;
                    $mora = $interest_late;
                    $i = $operation->annual_interest_rate/100;   // Interés
                    if ($operation->next_payment_date>$amort_date) {
                        $days_interest = (strtotime($amort_date)-strtotime($operation->last_payment_date))/86400;
                        //$last_payment_date = $amort_date;
                        $sw = 1;
                    } else {
                        $days_interest = 360/$operation->payment_term;
                        $last_payment_date = $payment->expiration_date;
                        $sw = 0;
                    }
                    $interes = $operation->last_balance*($days_interest/360)*$i;
                    $capital = $payment->fixed_fee-$interes;
                    $last_balance = $operation->last_balance-($capital+$capital_fee);
            ?>

              <tr>
                <td>@if($payment->payment<$operation->next_payment) <span class="label label-success">Pagado</span> @elseif($payment->payment==$operation->next_payment) <span class="label label-danger">Recuperando mora</span> @endif</td>
                <td>{{ $payment->payment }} <input type="hidden" name="id_payment_a[]" id="id_payment_a" value="{{ $payment->id }}"><input type="hidden" name="payment_a[]" id="payment_a" value="{{ $payment->payment }}"></td>
                <td>{{ $payment->expiration_date }}</td>
                <td>{{ $dias }} <input type="hidden" name="payment_date_a[]" id="payment_date_a" value="{{ $amort_date }}"><input type="hidden" name="expiration_date_a[]" id="expiration_date_a" value="{{ $payment->expiration_date }}"></td>
                <td>{{ number_format($payment->fixed_fee, 2, '.', ',') }} <input type="hidden" name="fixed_fee_a[]" id="fixed_fee_a" value="{{ $payment->fixed_fee }}"></td>
                <td>{{ number_format($capital, 2, '.', ',') }} <input type="hidden" name="capital_a[]" id="capital_a" value="{{ $capital }}"></td>
                <td>{{ number_format($capital_fee, 2, '.', ',') }} <input type="hidden" name="amortization_fee_a[]" id="amortization_fee_a" value="{{ $capital_fee }}"></td>
                <td>{{ number_format($interes, 2, '.', ',') }} <input type="hidden" name="interest_a[]" id="interest_a" value="{{ $interes }}"></td>
                <td>{{ number_format($payment->interest_late+$mora, 2, '.', ',') }} <input type="hidden" name="interest_late_a[]" id="interest_late_a" value="{{ $payment->interest_late+$mora }}"></td>
                <td>{{ number_format($interest_accrued-($payment->interest_late+$mora), 2, '.', ',') }} <input type="hidden" name="interest_accrued_a[]" id="interest_accrued_a" value="{{ $interest_accrued-($payment->interest_late+$mora) }}"></td>
                <td>{{ number_format($payment->charges, 2, '.', ',') }} <input type="hidden" name="charges_a[]" id="charges_a" value="{{ $payment->charges }}"></td>
                <td>{{ number_format($payment->disgrace, 2, '.', ',') }} <input type="hidden" name="disgrace_a[]" id="disgrace_a" value="{{ $payment->disgrace }}"></td>
                <td>{{ number_format($payment->variable_fee+$capital_fee+$mora, 2, '.', ',') }} <input type="hidden" name="variable_fee_a[]" id="variable_fee_a" value="{{ $payment->variable_fee+$capital_fee+$mora }}"></td>
                <td>{{ number_format($last_balance, 2, '.', ',') }} <input type="hidden" name="balance_a[]" id="balance_a" value="{{ $last_balance }}"></td></td></td>
              </tr>
            <?php
                    //$last_payment_date = $amort_date;
                } else {
                    $dias = 0;
                    $mora = 0;
                    $i = $operation->annual_interest_rate/100;   // Interés
                    if ($sw == 1) {
                        $days_interest = (strtotime($payment->expiration_date)-strtotime($amort_date))/86400;
                        $sw = 0;
                    } else {
                        $days_interest = 360/$operation->payment_term;
                    }
                    if ($sw == 3) {
                        $charges = 0;
                        $disgrace = 0;
                    } else {
                        $charges = $payment->charges;
                        $disgrace = $payment->disgrace;
                    }
                    $interes = $last_balance*($days_interest/360)*$i;
                    if ($payment->fixed_fee<=$last_balance) {
                        $fixed_fee = $payment->fixed_fee;
                        $capital = $payment->fixed_fee-$interes;
                        $last_balance = $last_balance-$capital;
                    } else {
                        $fixed_fee = $payment->fixed_fee;
                        $capital = $payment->fixed_fee-$interes;
                        $last_balance = $last_balance-$last_balance;
                        $sw = 3;
                    }

            ?>
              <tr>
                <td>@if($payment->payment<$operation->next_payment) <span class="label label-success">Pagado</span> @elseif($payment->payment==$operation->next_payment) <span class="label label-danger">Recuperando mora</span> @endif</td>
                <td>{{ $payment->payment }} <input type="hidden" name="id_payment_a[]" id="id_payment_a" value="{{ $payment->id }}"><input type="hidden" name="payment_a[]" id="payment_a" value="{{ $payment->payment }}"></td>
                <td>{{ $payment->expiration_date }}</td>
                <td>{{ $dias }} <input type="hidden" name="payment_date_a[]" id="payment_date_a" value=""><input type="hidden" name="expiration_date_a[]" id="expiration_date_a" value="{{ $payment->expiration_date }}"></td>
                <td>{{ number_format($fixed_fee, 2, '.', ',') }} <input type="hidden" name="fixed_fee_a[]" id="fixed_fee_a" value="{{ $fixed_fee }}"></td>
                <td>{{ number_format($capital, 2, '.', ',') }} <input type="hidden" name="capital_a[]" id="capital_a" value="{{ $capital }}"></td>
                <td>{{ number_format($payment->capital_fee, 2, '.', ',') }} <input type="hidden" name="amortization_fee_a[]" id="amortization_fee_a" value="{{ $payment->capital_fee }}"></td>
                <td>{{ number_format($interes, 2, '.', ',') }} <input type="hidden" name="interest_a[]" id="interest_a" value="{{ $interes }}"></td>
                <td>{{ number_format($payment->interest_late, 2, '.', ',') }} <input type="hidden" name="interest_late_a[]" id="interest_late_a" value="{{ $payment->interest_late }}"></td>
                <td>{{ number_format($payment->interest_accrued, 2, '.', ',') }} <input type="hidden" name="interest_accrued_a[]" id="interest_accrued_a" value="{{ $payment->interest_accrued }}"></td>
                <td>{{ number_format($charges, 2, '.', ',') }} <input type="hidden" name="charges_a[]" id="charges_a" value="{{ $charges }}"></td>
                <td>{{ number_format($disgrace, 2, '.', ',') }} <input type="hidden" name="disgrace_a[]" id="disgrace_a" value="{{ $disgrace }}"></td>
                <td>{{ number_format($fixed_fee+$charges+$disgrace, 2, '.', ',') }} <input type="hidden" name="variable_fee_a[]" id="variable_fee_a" value="{{ $fixed_fee+$charges+$disgrace }}"></td>
                <td>{{ number_format($last_balance, 2, '.', ',') }} <input type="hidden" name="balance_a[]" id="balance_a" value="{{ $last_balance }}"></td>
              </tr>
            <?php } ?>
            @if ($payment->payment_date==null) @break; @endif
          <?php
                    $last_payment_date = $payment->expiration_date;
                } else {
                    $dias = (strtotime($payment->payment_date)-strtotime($payment->expiration_date))/86400;
                    $mora = 0;
                    if ($dias<0) {
                      $dias = 0;
                    }
          ?>
            <tr>
              <td>@if($payment->payment<$operation->next_payment) <span class="label label-success">Pagado</span> @elseif($payment->payment==$operation->next_payment) <span class="label label-danger">Recuperando mora</span> @endif</td>
              <td>{{ $payment->payment }}</td>
              <td>{{ $payment->expiration_date }}</td>
              <td>{{ $dias }} </td>
              <td>{{ number_format($payment->fixed_fee, 2, '.', ',') }}</td>
              <td>{{ number_format($payment->capital, 2, '.', ',') }}</td>
              <td>{{ number_format($payment->capital_fee, 2, '.', ',') }}</td>
              <td>{{ number_format($payment->interest, 2, '.', ',') }}</td>
              <td>{{ number_format($payment->interest_late, 2, '.', ',') }}</td>
              <td>{{ number_format($payment->interest_accrued, 2, '.', ',') }}</td>
              <td>{{ number_format($payment->charges, 2, '.', ',') }}</td>
              <td>{{ number_format($payment->disgrace, 2, '.', ',') }}</td>
              <td>{{ number_format($payment->variable_fee, 2, '.', ',') }}</td>
              <td>{{ number_format($payment->balance, 2, '.', ',') }}</td>
            </tr>

          <?php } ?>

        @endforeach
      </tbody>
  </table>
  <div class="x_panel">
      <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-4">
          {!! Form::submit('Procesar', ['id'=>'amort_e', 'name'=>'amort_e', 'class'=>'btn btn-success']) !!}
      </div>
  </div>
