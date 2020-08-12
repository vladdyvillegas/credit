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
            $c1 = $payment->balance-$payment->balance;
            if ($payment->fixed_fee>$c1) { $cuota = $c1; }
            else { $cuota = $payment->fixed_fee; }

            $interes = $operation->last_balance*($frequency/360)*($operation->annual_interest_rate/100);
            $seguro_desgravamen = $c1*($operation->disgrace_insurance_rate/100)*(360/$operation->payment_term/30);
            $saldo = $c1-($cuota-$interes);

            if($days_late<0){

              $days_ant = (strtotime($amort_date)-strtotime($operation->last_payment_date))/86400;
              $interes = $operation->last_balance*($days_ant/360)*($operation->annual_interest_rate/100);
              //$seguro_desgravamen = $operation->last_balance*($days_ant/360)*($operation->dela_interest_rate/100);
            }
          ?>
            <tr>
              <td>@if($payment->payment<$operation->next_payment) <span class="label label-success">Pagado</span> @elseif($payment->payment==$operation->next_payment) <span class="label label-info">Liquidando</span> @endif</td>
              <td>{{ $payment->payment }} <input type="hidden" name="id_payment_d[]" id="id_payment_d" value="{{ $payment->id }}"><input type="hidden" name="payment_d[]" id="payment_d" value="{{ $payment->payment }}"></td>
              <td>{{ $payment->expiration_date }}</td>
              <td>0 <input type="hidden" name="payment_date_d[]" id="payment_date_d" value="{{ $amort_date }}"><input type="hidden" name="expiration_date_d[]" id="expiration_date_d" value="{{ $payment->expiration_date }}"></td>
              <td>{{ number_format(0, 2, '.', ',') }} <input type="hidden" name="fixed_fee_d[]" id="fixed_fee_d" value="0"></td>
              <td>{{ number_format($operation->last_balance, 2, '.', ',') }} <input type="hidden" name="capital_d[]" id="capital_d" value="{{ $operation->last_balance }}"></td>
              <td>{{ number_format($interes, 2, '.', ',') }} <input type="hidden" name="interest_d[]" id="interest_d" value="{{ $interes }}"></td>
              <td>{{ number_format(0, 2, '.', ',') }} <input type="hidden" name="interest_late_d[]" id="interest_late_d" value="0"></td>
              <td>{{ number_format(0, 2, '.', ',') }} <input type="hidden" name="interest_accrued_d[]" id="interest_accrued_d" value="0"></td>
              <td>{{ $payment->charges }} <input type="hidden" name="charges_d[]" id="charges_d" value="{{ $payment->charges }}"></td>
              <td>{{ $payment->disgrace }} <input type="hidden" name="disgrace_d[]" id="disgrace_d" value="{{ $payment->disgrace }}"></td>
              <td>{{ number_format($operation->last_balance+$interes+$payment->charges+$payment->disgrace, 2, '.', ',') }} <input type="hidden" name="variable_fee_d[]" id="variable_fee_d" value="{{ $operation->last_balance+$interes+$payment->charges+$payment->disgrace }}"></td>
              <td>{{ number_format(0, 2, '.', ',') }} <input type="hidden" name="balance_d[]" id="balance_d" value="0"><input type="hidden" name="amortization_fee_d[]" id="amortization_fee_d" value="0"></td>
            </tr>
          <?php } else {
            $dias = 0;
            $mora = 0;
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
            <td>@if($payment->payment<$operation->next_payment) <span class="label label-success">Pagado</span> @elseif($payment->payment==$operation->next_payment) <span class="label label-info">Liquidando</span> @endif</td>
            <td>{{ $payment->payment }} </td>
            <td>{{ $payment->expiration_date }}</td>
            <td>{{ $dias }} </td>
            <td>{{ $payment->fixed_fee }}</td>
            <td>{{ $payment->capital }}</td>
            <td>{{ $payment->interest }}</td>
            <td>{{ number_format($payment->interest_late+$mora, 2, '.', ',') }}</td>
            <td>{{ number_format($payment->interest_accrued, 2, '.', ',') }}</td>
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
        {!! Form::submit('Procesar', ['id'=>'amort_d', 'name'=>'amort_d', 'class'=>'btn btn-success']) !!}
    </div>
</div>
