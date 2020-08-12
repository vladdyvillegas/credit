<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Reporte de seguros automotor</title>
    <link rel="stylesheet" href="assets/css/style.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <!-- <div id="logo">
        <img src="assets/css/logo.png">
      </div> -->
      <h1>SEGURO AUTOMOTOR @if($type=='PROPIO') ENDULZA PROPIOS @else ENDULZA FINANCIERA @endif</h1>
      <h3>Al {{ date('d-m-Y') }}, Expresado en dólares</h3>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">OP.</th>
            <th class="desc">CLIENTE</th>
            <th>SEGURO <br /> AUTOMOTOR</th>
            <th>PAGADO <br /> 2018</th>
            <th>TOTAL PAGADO</th>
            <th>VENCIDO <br /> 2018</th>
            <th>FECHA <br /> VENCIMIENTO</th>
            <th>GESTIÓN 2018</th>
            <th>GESTIÓN 2019</th>
            <th>GESTIÓN 2020</th>
            <th>TOTAL SALDO</th>
          </tr>
        </thead>
        <tbody>
          <?php
              $sum_service_2 = 0;
              $sum_paid = 0;
              $sum_total_paid = 0;
              $sum_expired = 0;
              $sum_year1 = 0;
              $sum_year2 = 0;
              $sum_year3 = 0;
              $sum_tot_saldo = 0;
          ?>
          @foreach($insurances as $insurance)

              <tr>
                <td class="desc">{{ $insurance->operation }}</td>
                <td class="desc">{{ $insurance->name }}</td>
                <td class="unit">{{ number_format($insurance->service_2, 2, '.', ',') }}</td>
                <td class="unit">{{ number_format($insurance->paid, 2, '.', ',') }}</td>
                <td class="unit">{{ number_format($insurance->service_2-($insurance->expired+$insurance->year1+$insurance->year2+$insurance->year3), 2, '.', ',') }}</td>
                <td class="unit">{{ number_format($insurance->expired, 2, '.', ',') }}</td>
                <td class="unit">{{ $insurance->expired_date }}</td>
                <td class="unit">{{ number_format($insurance->year1, 2, '.', ',') }}</td>
                <td class="unit">{{ number_format($insurance->year2, 2, '.', ',') }}</td>
                <td class="unit">{{ number_format($insurance->year3, 2, '.', ',') }}</td>
                <td class="unit">{{ number_format($insurance->expired+$insurance->year1+$insurance->year2+$insurance->year3, 2, '.', ',') }}</td>
              </tr>
              <?php
                  $sum_service_2 = $sum_service_2 + $insurance->service_2;
                  $sum_paid = $sum_paid + $insurance->paid;
                  $sum_total_paid = $sum_total_paid + ($insurance->service_2-($insurance->expired+$insurance->year2+$insurance->year3));
                  $sum_expired = $sum_expired + $insurance->expired;
                  $sum_year1 = $sum_year1 + $insurance->year1;
                  $sum_year2 = $sum_year2 + $insurance->year2;
                  $sum_year3 = $sum_year3 + $insurance->year3;
                  $sum_tot_saldo = $sum_tot_saldo + ($insurance->expired+$insurance->year2+$insurance->year3);
              ?>
          @endforeach
          <tr>
            <td colspan="2" class="grand total">TOTAL</td>
            <td class="grand total">{{ number_format($sum_service_2, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_paid, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_total_paid, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_expired, 2, '.', ',') }}</td>
            <td class="grand total"></td>
            <td class="grand total">{{ number_format($sum_year1, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_year2, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_year3, 2, '.', ',') }}</td>
            <td class="grand total">{{ number_format($sum_tot_saldo, 2, '.', ',') }}</td>
          </tr>
        </tbody>
      </table>
    </main>
    <footer>
      Credit Portfolio Manager by PaperPlane &copy;2017
    </footer>
  </body>
</html>
