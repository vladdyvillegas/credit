@extends('layouts.blank')

@section('title', 'Inicio')

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Indicadores <small> </small></h3>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
          <div class="col-md-7 col-sm-5 col-xs-12">
            <div class="x_panel">
              {{-- <div class="x_title">
                <h2>Line Graph</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#">Settings 1</a>
                      </li>
                      <li><a href="#">Settings 2</a>
                      </li>
                    </ul>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div> --}}
              <div class="x_content">

                <div id="bar_propio" style="height:350px;"></div>

              </div>
            </div>
          </div>

          <div class="col-md-5 col-sm-7 col-xs-12">
            <div class="x_panel">
              {{-- <div class="x_title">
                <h2>Pie Graph</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#">Settings 1</a>
                      </li>
                      <li><a href="#">Settings 2</a>
                      </li>
                    </ul>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div> --}}
              <div class="x_content">

                <div id="pie_propio" style="height:350px;"></div>

              </div>
            </div>
          </div>

          <div class="col-md-7 col-sm-5 col-xs-12">
            <div class="x_panel">
              {{-- <div class="x_title">
                <h2>Line Graph</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#">Settings 1</a>
                      </li>
                      <li><a href="#">Settings 2</a>
                      </li>
                    </ul>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div> --}}
              <div class="x_content">

                <div id="bar_financial" style="height:350px;"></div>

              </div>
            </div>
          </div>

          <div class="col-md-5 col-sm-7 col-xs-12">
            <div class="x_panel">
              {{-- <div class="x_title">
                <h2>Pie Graph</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#">Settings 1</a>
                      </li>
                      <li><a href="#">Settings 2</a>
                      </li>
                    </ul>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div> --}}
              <div class="x_content">

                <div id="pie_financial" style="height:350px;"></div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /page content -->

    <!-- footer content -->
    <footer>
        <div class="pull-right">
            Credit Portfolio Manager by <a href="https://www.paperplane.com.bo">PaperPlane</a>
        </div>
        <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->

@endsection

@push('scripts')
    <!-- ECharts -->
    <script src="{{ asset("echarts/dist/echarts.min.js") }}"></script>

    <script type="text/javascript">
        // based on prepared DOM, initialize echarts instance
        var chart = echarts.init(document.getElementById('pie_propio'));
        var pieProp = <?php echo json_encode($pie_prop); ?>;

        // specify chart configuration item and data
        chart.setOption({
          title: {
              text: 'INDICE DE MOROSIDAD <?php echo $period_name." ".$gestion_open; ?>',
              subtext: 'Cartera Propia',
              left: 'center'
          },
          tooltip: {
              trigger: 'item',
              formatter: "{b}: {c} ({d}%)"
          },
          legend: {
              orient: 'horizontal',
              bottom: 10,
              data:['En mora','Al día','Mora=1m','Mora=2m','Mora>3m']
          },
          series: [
              {
                  name:'A',
                  type:'pie',
                  selectedMode: 'single',
                  radius: [0, '30%'],
                  label: {
                      normal: {
                          position: 'inner'
                      }
                  },
                  labelLine: {
                      normal: {
                          show: false
                      }
                  },
                  data:[
                      {name:'En mora', value:pieProp[0].enMora},
                      {name:'Al día', value:pieProp[0].alDia}
                  ]
              },
              {
                  name:'B',
                  type:'pie',
                  radius: ['40%', '55%'],
                  label: {
                      normal: {
                          formatter: ' {c}  ({d}%)',
                          backgroundColor: '#eee',
                          borderColor: '#aaa',
                          borderWidth: 1,
                          borderRadius: 4,
                          rich: {
                              a: {
                                  color: '#999',
                                  lineHeight: 22,
                                  align: 'center'
                              },
                              b: {
                                  fontSize: 16,
                                  lineHeight: 33
                              },
                              per: {
                                  color: '#eee',
                                  backgroundColor: '#334455',
                                  padding: [2, 4],
                                  borderRadius: 2
                              }
                          }
                      }
                  },
                  data:[
                      {name:'Mora=1m', value:pieProp[0].mora1},
                      {name:'Mora=2m', value:pieProp[0].mora2},
                      {name:'Mora>3m', value:pieProp[0].mora3},
                      {name:'Sin mora', value:pieProp[0].alDia}
                  ]
              }
          ]
        })

        // use configuration item and data specified to show chart
        myChart.setOption(option);
    </script>

    <script type="text/javascript">
        // based on prepared DOM, initialize echarts instance
        var chart = echarts.init(document.getElementById('pie_financial'));
        var pieFinan = <?php echo json_encode($pie_finan); ?>;

        // specify chart configuration item and data
        chart.setOption({
          title: {
              text: 'INDICE DE MOROSIDAD <?php echo $period_name." ".$gestion_open; ?>',
              subtext: 'Financiera',
              left: 'center'
          },
          tooltip: {
              trigger: 'item',
              formatter: "{b}: {c} ({d}%)"
          },
          legend: {
              orient: 'horizontal',
              bottom: 10,
              data:['En mora','Al día','Mora=1m','Mora=2m','Mora>3m']
          },
          series: [
              {
                  name:'A',
                  type:'pie',
                  selectedMode: 'single',
                  radius: [0, '30%'],
                  label: {
                      normal: {
                          position: 'inner'
                      }
                  },
                  labelLine: {
                      normal: {
                          show: false
                      }
                  },
                  data:[
                      {name:'En mora', value:pieFinan[0].enMora},
                      {name:'Al día', value:pieFinan[0].alDia}
                  ]
              },
              {
                  name:'B',
                  type:'pie',
                  radius: ['40%', '55%'],
                  label: {
                      normal: {
                          formatter: ' {c}  ({d}%)',
                          backgroundColor: '#eee',
                          borderColor: '#aaa',
                          borderWidth: 1,
                          borderRadius: 4,
                          rich: {
                              a: {
                                  color: '#999',
                                  lineHeight: 22,
                                  align: 'center'
                              },
                              b: {
                                  fontSize: 16,
                                  lineHeight: 33
                              },
                              per: {
                                  color: '#eee',
                                  backgroundColor: '#334455',
                                  padding: [2, 4],
                                  borderRadius: 2
                              }
                          }
                      }
                  },
                  data:[
                      {name:'Mora=1m', value:pieFinan[0].mora1},
                      {name:'Mora=2m', value:pieFinan[0].mora2},
                      {name:'Mora>3m', value:pieFinan[0].mora3},
                      {name:'Sin mora', value:pieFinan[0].alDia}
                  ]
              }
          ]
        })

        // use configuration item and data specified to show chart
        myChart.setOption(option);
    </script>

    <script type="text/javascript">
        // based on prepared DOM, initialize echarts instance
        var chart = echarts.init(document.getElementById('bar_propio'));
        var barProp = <?php echo json_encode($bar_prop); ?>;

        var iAlDia = [];
        for (i in barProp) {
          iAlDia.push(barProp[i].indice);
        }
        var iMora = [];
        for (i in barProp) {
          iMora.push(barProp[i].indice_mora);
        }
        var iMora1 = [];
        for (i in barProp) {
          iMora1.push(barProp[i].indice_mora1);
        }
        var iMora2 = [];
        for (i in barProp) {
          iMora2.push(barProp[i].indice_mora2);
        }
        var iMora3 = [];
        for (i in barProp) {
          iMora3.push(barProp[i].indice_mora3);
        }

        var labelOption = {
            normal: {
                show: true,
                position: 'insideTop',
                formatter: '{c}',
                fontSize: 12,
                rich: {
                    name: {
                        textBorderColor: '#fff'
                    }
                }
            }
        };
        // specify chart configuration item and data
        chart.setOption({
          title: {
              text: 'INDICE DE MOROSIDAD MENSUAL <?php echo $gestion_open; ?>',
              subtext: 'Cartera Propia',
              left: 'center'
          },
          color: ['#2f4554', '#c23531', '#61a0a8', '#d48265', '#91c7ae'],
          tooltip : {
              trigger: 'axis',
              axisPointer : {
                  type : 'shadow'
              }
          },
          legend: {
              orient: 'horizontal',
              bottom: 10,
              data:['Al día','En mora','Mora=1m','Mora=2m','Mora>3m']
          },
          grid: {
              left: '3%',
              right: '4%',
              bottom: '15%',
              containLabel: true
          },
          xAxis : [
              {
                  type : 'category',
                  data : ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC']
              }
          ],
          yAxis : [
              {
                  type : 'value'
              }
          ],
          series : [
              {
                  name:'Al día',
                  type:'bar',
                  barGap: 0,
                  //label: labelOption,
                  data:iAlDia
              },
              {
                  name:'En mora',
                  type:'bar',
                  //label: labelOption,
                  data:iMora,
                  markLine : {
                      lineStyle: {
                          normal: {
                              type: 'dashed'
                          }
                      }

                  }
              },
              {
                  name:'Mora=1m',
                  type:'bar',
                  barWidth : 8,
                  stack: 'En mora',
                  data:iMora1
              },
              {
                  name:'Mora=2m',
                  type:'bar',
                  stack: 'En mora',
                  data:iMora2
              },
              {
                  name:'Mora>3m',
                  type:'bar',
                  stack: 'En mora',
                  data:iMora3
              }
          ]
        })

        // use configuration item and data specified to show chart
        myChart.setOption(option);
    </script>

    <script type="text/javascript">
        // based on prepared DOM, initialize echarts instance
        var chart = echarts.init(document.getElementById('bar_financial'));
        var barProp = <?php echo json_encode($bar_finan); ?>;

        var iAlDia = [];
        for (i in barProp) {
          iAlDia.push(barProp[i].indice);
        }
        var iMora = [];
        for (i in barProp) {
          iMora.push(barProp[i].indice_mora);
        }
        var iMora1 = [];
        for (i in barProp) {
          iMora1.push(barProp[i].indice_mora1);
        }
        var iMora2 = [];
        for (i in barProp) {
          iMora2.push(barProp[i].indice_mora2);
        }
        var iMora3 = [];
        for (i in barProp) {
          iMora3.push(barProp[i].indice_mora3);
        }

        var labelOption = {
            normal: {
                show: true,
                position: 'insideTop',
                formatter: '{c}',
                fontSize: 12,
                rich: {
                    name: {
                        textBorderColor: '#fff'
                    }
                }
            }
        };
        // specify chart configuration item and data
        chart.setOption({
          title: {
              text: 'INDICE DE MOROSIDAD MENSUAL <?php echo $gestion_open; ?>',
              subtext: 'Financiera',
              left: 'center'
          },
          color: ['#2f4554', '#c23531', '#61a0a8', '#d48265', '#91c7ae'],
          tooltip : {
              trigger: 'axis',
              axisPointer : {
                  type : 'shadow'
              }
          },
          legend: {
              orient: 'horizontal',
              bottom: 10,
              data:['Al día','En mora','Mora=1m','Mora=2m','Mora>3m']
          },
          grid: {
              left: '3%',
              right: '4%',
              bottom: '15%',
              containLabel: true
          },
          xAxis : [
              {
                  type : 'category',
                  data : ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC']
              }
          ],
          yAxis : [
              {
                  type : 'value'
              }
          ],
          series : [
              {
                  name:'Al día',
                  type:'bar',
                  barGap: 0,
                  //label: labelOption,
                  data:iAlDia
              },
              {
                  name:'En mora',
                  type:'bar',
                  //label: labelOption,
                  data:iMora,
                  markLine : {
                      lineStyle: {
                          normal: {
                              type: 'dashed'
                          }
                      }

                  }
              },
              {
                  name:'Mora=1m',
                  type:'bar',
                  barWidth : 8,
                  stack: 'En mora',
                  data:iMora1
              },
              {
                  name:'Mora=2m',
                  type:'bar',
                  stack: 'En mora',
                  data:iMora2
              },
              {
                  name:'Mora>3m',
                  type:'bar',
                  stack: 'En mora',
                  data:iMora3
              }
          ]
        })

        // use configuration item and data specified to show chart
        myChart.setOption(option);
    </script>
@endpush
