
<!DOCTYPE html>
<html lang="en" class=" ">
<head>
  <meta charset="utf-8" />
  <title>Sudoku Algoritma Genetika</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="css/animate.css" type="text/css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="css/font.css" type="text/css" />
  <link rel="stylesheet" href="css/landing.css" type="text/css" />
  <link rel="stylesheet" href="css/app.css" type="text/css" />
  <link rel="stylesheet" href="css/cube.css" type="text/css" />
</head>
<body class="">
  <section class="vbox">
  <div class="row">
    <div class="col-sm-6 col-sm-offset-3">
      <div class="text-center m-b-lg">
        <h4 class="animated fadeInDownBig">Algen Sudoku</h4>
      </div>
      <section class="panel animated fadeInDownBig panel b-light">
          <div class="panel-heading bg-primary dker no-border">
              <strong>Kotak Sudoku</strong>
          </div>
          <form class="bs-example form-horizontal">
          <div class="panel-body">
            <center>
              <a href="#" id="mudah" class="btn btn-s-md btn-primary btn-rounded">Pemula</a>
              <a href="#" class="btn btn-s-md btn-success btn-rounded" disabled>Mudah</a>
              <a href="#" class="btn btn-s-md btn-info btn-rounded" disabled>Level Koran</a>
              <a href="#" class="btn btn-s-md btn-warning btn-rounded" disabled>Sulit</a>
              <a href="#" class="btn btn-s-md btn-danger btn-rounded" disabled>Sangat Suilit</a>
            </center>
              <div class="line pull-in"></div>
              <table class="table table-bordered">
                  <tbody>
                  <?php
                  for ($i=0; $i<9; $i++) {
                  ?>
                      <tr>
                  <?php
                      for ($j=0; $j<9; $j++) {
                  ?>
                          <td>
                              <input type="text" name="cell-<?php echo $i.'-'.$j ?>" class="cell form-control" id="cell-<?php echo $i.'-'.$j ?>"></input>
                          </td>
                  <?php
                      }
                  ?>
                      </tr>
                  <?php
                  }
                  ?>
                  </tbody>
              </table>
              <div class="line pull-in"></div>
              <div class="form-group">
                <label class="col-lg-4 control-label">Ukuran populasi</label>
                <div class="col-lg-8">
                  <input type="number" name="populasi" class="form-control" value="50">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-4 control-label">Probabilitas penyilangan</label>
                <div class="col-lg-8">
                  <input type="number" name="penyilangan" class="form-control" value="0.3">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-4 control-label">Probabilitas mutasi</label>
                <div class="col-lg-8">
                  <input type="number" name="mutasi" class="form-control" value="0.8">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-4 control-label">Batas generasi</label>
                <div class="col-lg-4">
                  <input type="number" name="generasi" class="form-control" value="5000">
                </div>
                <div class="col-lg-4">
                  <label>
                    <input type="checkbox" name="ketemu" value="1">
                    Sampai ketemu
                  </label>
                </div>
              </div>
          </div>
          <div class="panel-footer">
              <a href="#cari" id="cari" class="btn btn-sm btn-primary">Mulai</a>
          </div>
        </form>
      </section>
    </div>
  </div>
</section>

<div class="modal fade in" id="modal-form" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <center>
            <h4>Loading</h4>
            <div class="uil-cube-css" style="-webkit-transform:scale(0.16)">
              <div></div>
              <div></div>
              <div></div>
              <div></div>
            </div>
          </center>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>

<script src="js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="js/bootstrap.js"></script>
<!-- App -->
<script src="js/app.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('#cari').click(function(){
    $('#modal-form').show();
    var populasi = $("input[name='populasi']").val();
    var penyilangan = $("input[name='penyilangan']").val();
    var mutasi = $("input[name='mutasi']").val();
    var generasi = $("input[name='generasi']").val();
    if ($("input[name='ketemu']").is(':checked')) {
      ketemu = 1;
    } else {
      ketemu = 0;
    }

    var cell_0_0 = $("input[name='cell-0-0']").val();
    var cell_0_1 = $("input[name='cell-0-1']").val();
    var cell_0_2 = $("input[name='cell-0-2']").val();
    var cell_0_3 = $("input[name='cell-0-3']").val();
    var cell_0_4 = $("input[name='cell-0-4']").val();
    var cell_0_5 = $("input[name='cell-0-5']").val();
    var cell_0_6 = $("input[name='cell-0-6']").val();
    var cell_0_7 = $("input[name='cell-0-7']").val();
    var cell_0_8 = $("input[name='cell-0-8']").val();

    var cell_1_0 = $("input[name='cell-1-0']").val();
    var cell_1_1 = $("input[name='cell-1-1']").val();
    var cell_1_2 = $("input[name='cell-1-2']").val();
    var cell_1_3 = $("input[name='cell-1-3']").val();
    var cell_1_4 = $("input[name='cell-1-4']").val();
    var cell_1_5 = $("input[name='cell-1-5']").val();
    var cell_1_6 = $("input[name='cell-1-6']").val();
    var cell_1_7 = $("input[name='cell-1-7']").val();
    var cell_1_8 = $("input[name='cell-1-8']").val();

    var cell_2_0 = $("input[name='cell-2-0']").val();
    var cell_2_1 = $("input[name='cell-2-1']").val();
    var cell_2_2 = $("input[name='cell-2-2']").val();
    var cell_2_3 = $("input[name='cell-2-3']").val();
    var cell_2_4 = $("input[name='cell-2-4']").val();
    var cell_2_5 = $("input[name='cell-2-5']").val();
    var cell_2_6 = $("input[name='cell-2-6']").val();
    var cell_2_7 = $("input[name='cell-2-7']").val();
    var cell_2_8 = $("input[name='cell-2-8']").val();

    var cell_3_0 = $("input[name='cell-3-0']").val();
    var cell_3_1 = $("input[name='cell-3-1']").val();
    var cell_3_2 = $("input[name='cell-3-2']").val();
    var cell_3_3 = $("input[name='cell-3-3']").val();
    var cell_3_4 = $("input[name='cell-3-4']").val();
    var cell_3_5 = $("input[name='cell-3-5']").val();
    var cell_3_6 = $("input[name='cell-3-6']").val();
    var cell_3_7 = $("input[name='cell-3-7']").val();
    var cell_3_8 = $("input[name='cell-3-8']").val();

    var cell_4_0 = $("input[name='cell-4-0']").val();
    var cell_4_1 = $("input[name='cell-4-1']").val();
    var cell_4_2 = $("input[name='cell-4-2']").val();
    var cell_4_3 = $("input[name='cell-4-3']").val();
    var cell_4_4 = $("input[name='cell-4-4']").val();
    var cell_4_5 = $("input[name='cell-4-5']").val();
    var cell_4_6 = $("input[name='cell-4-6']").val();
    var cell_4_7 = $("input[name='cell-4-7']").val();
    var cell_4_8 = $("input[name='cell-4-8']").val();

    var cell_5_0 = $("input[name='cell-5-0']").val();
    var cell_5_1 = $("input[name='cell-5-1']").val();
    var cell_5_2 = $("input[name='cell-5-2']").val();
    var cell_5_3 = $("input[name='cell-5-3']").val();
    var cell_5_4 = $("input[name='cell-5-4']").val();
    var cell_5_5 = $("input[name='cell-5-5']").val();
    var cell_5_6 = $("input[name='cell-5-6']").val();
    var cell_5_7 = $("input[name='cell-5-7']").val();
    var cell_5_8 = $("input[name='cell-5-8']").val();

    var cell_6_0 = $("input[name='cell-6-0']").val();
    var cell_6_1 = $("input[name='cell-6-1']").val();
    var cell_6_2 = $("input[name='cell-6-2']").val();
    var cell_6_3 = $("input[name='cell-6-3']").val();
    var cell_6_4 = $("input[name='cell-6-4']").val();
    var cell_6_5 = $("input[name='cell-6-5']").val();
    var cell_6_6 = $("input[name='cell-6-6']").val();
    var cell_6_7 = $("input[name='cell-6-7']").val();
    var cell_6_8 = $("input[name='cell-6-8']").val();

    var cell_7_0 = $("input[name='cell-7-0']").val();
    var cell_7_1 = $("input[name='cell-7-1']").val();
    var cell_7_2 = $("input[name='cell-7-2']").val();
    var cell_7_3 = $("input[name='cell-7-3']").val();
    var cell_7_4 = $("input[name='cell-7-4']").val();
    var cell_7_5 = $("input[name='cell-7-5']").val();
    var cell_7_6 = $("input[name='cell-7-6']").val();
    var cell_7_7 = $("input[name='cell-7-7']").val();
    var cell_7_8 = $("input[name='cell-7-8']").val();

    var cell_8_0 = $("input[name='cell-8-0']").val();
    var cell_8_1 = $("input[name='cell-8-1']").val();
    var cell_8_2 = $("input[name='cell-8-2']").val();
    var cell_8_3 = $("input[name='cell-8-3']").val();
    var cell_8_4 = $("input[name='cell-8-4']").val();
    var cell_8_5 = $("input[name='cell-8-5']").val();
    var cell_8_6 = $("input[name='cell-8-6']").val();
    var cell_8_7 = $("input[name='cell-8-7']").val();
    var cell_8_8 = $("input[name='cell-8-8']").val();

    $.ajax({
      method: "POST",
      url: "proses.php",
      data: {
        populasi: populasi,
        penyilangan: penyilangan,
        mutasi: mutasi,
        generasi: generasi,
        ketemu: ketemu,
        cell_0_0 : cell_0_0,
        cell_0_1 : cell_0_1,
        cell_0_2 : cell_0_2,
        cell_0_3 : cell_0_3,
        cell_0_4 : cell_0_4,
        cell_0_5 : cell_0_5,
        cell_0_6 : cell_0_6,
        cell_0_7 : cell_0_7,
        cell_0_8 : cell_0_8,

        cell_1_0 : cell_1_0,
        cell_1_1 : cell_1_1,
        cell_1_2 : cell_1_2,
        cell_1_3 : cell_1_3,
        cell_1_4 : cell_1_4,
        cell_1_5 : cell_1_5,
        cell_1_6 : cell_1_6,
        cell_1_7 : cell_1_7,
        cell_1_8 : cell_1_8,

        cell_2_0 : cell_2_0,
        cell_2_1 : cell_2_1,
        cell_2_2 : cell_2_2,
        cell_2_3 : cell_2_3,
        cell_2_4 : cell_2_4,
        cell_2_5 : cell_2_5,
        cell_2_6 : cell_2_6,
        cell_2_7 : cell_2_7,
        cell_2_8 : cell_2_8,

        cell_3_0 : cell_3_0,
        cell_3_1 : cell_3_1,
        cell_3_2 : cell_3_2,
        cell_3_3 : cell_3_3,
        cell_3_4 : cell_3_4,
        cell_3_5 : cell_3_5,
        cell_3_6 : cell_3_6,
        cell_3_7 : cell_3_7,
        cell_3_8 : cell_3_8,

        cell_4_0 : cell_4_0,
        cell_4_1 : cell_4_1,
        cell_4_2 : cell_4_2,
        cell_4_3 : cell_4_3,
        cell_4_4 : cell_4_4,
        cell_4_5 : cell_4_5,
        cell_4_6 : cell_4_6,
        cell_4_7 : cell_4_7,
        cell_4_8 : cell_4_8,

        cell_5_0 : cell_5_0,
        cell_5_1 : cell_5_1,
        cell_5_2 : cell_5_2,
        cell_5_3 : cell_5_3,
        cell_5_4 : cell_5_4,
        cell_5_5 : cell_5_5,
        cell_5_6 : cell_5_6,
        cell_5_7 : cell_5_7,
        cell_5_8 : cell_5_8,

        cell_6_0 : cell_6_0,
        cell_6_1 : cell_6_1,
        cell_6_2 : cell_6_2,
        cell_6_3 : cell_6_3,
        cell_6_4 : cell_6_4,
        cell_6_5 : cell_6_5,
        cell_6_6 : cell_6_6,
        cell_6_7 : cell_6_7,
        cell_6_8 : cell_6_8,

        cell_7_0 : cell_7_0,
        cell_7_1 : cell_7_1,
        cell_7_2 : cell_7_2,
        cell_7_3 : cell_7_3,
        cell_7_4 : cell_7_4,
        cell_7_5 : cell_7_5,
        cell_7_6 : cell_7_6,
        cell_7_7 : cell_7_7,
        cell_7_8 : cell_7_8,

        cell_8_0 : cell_8_0,
        cell_8_1 : cell_8_1,
        cell_8_2 : cell_8_2,
        cell_8_3 : cell_8_3,
        cell_8_4 : cell_8_4,
        cell_8_5 : cell_8_5,
        cell_8_6 : cell_8_6,
        cell_8_7 : cell_8_7,
        cell_8_8 : cell_8_8,
      }
    }).done(function( msg ) {
        var dataObj = JSON.parse(msg);
        var kromosom = 0;
        console.log(dataObj.individu[0].gen);
        for (var i=0; i<9; i++) {
          var index = 0;
          for (var j=0; j<9; j++) {
            if ($("input[name='cell-"+i+"-"+j+"']").val()=='') {
              $("input[name='cell-"+i+"-"+j+"']").val(dataObj.individu[0].gen[i][index]);
              $("input[name='cell-"+i+"-"+j+"']").css("background-color", "#65bd77");
              console.log(dataObj.individu[0].gen[i][index]);
              kromosom++;
              index++;
            }
          }
        }
        alert("Fitnes = "+dataObj.individu[0].fitnes+" Ukuran kromosom = "+kromosom);
        $('#modal-form').hide();
    });
  });
  $('#mudah').click(function(){
    $("input[name='cell-0-0']").val(9);
    $("input[name='cell-0-2']").val(5);
    $("input[name='cell-0-3']").val(8);
    $("input[name='cell-0-4']").val(3);
    $("input[name='cell-0-5']").val(6);

    $("input[name='cell-1-0']").val(7);
    $("input[name='cell-1-2']").val(2);
    $("input[name='cell-1-3']").val(1);
    $("input[name='cell-1-4']").val(9);
    $("input[name='cell-1-6']").val(6);
    $("input[name='cell-1-7']").val(3);
    $("input[name='cell-1-8']").val(8);

    $("input[name='cell-2-1']").val(3);
    $("input[name='cell-2-2']").val(8);
    $("input[name='cell-2-4']").val(7);
    $("input[name='cell-2-5']").val(4);

    $("input[name='cell-3-1']").val(8);
    $("input[name='cell-3-2']").val(3);
    $("input[name='cell-3-3']").val(6);
    $("input[name='cell-3-5']").val(1);
    $("input[name='cell-3-7']").val(2);
    $("input[name='cell-3-8']").val(9);

    $("input[name='cell-4-1']").val(7);
    $("input[name='cell-4-3']").val(9);
    $("input[name='cell-4-6']").val(3);
    $("input[name='cell-4-7']").val(8);
    $("input[name='cell-4-8']").val(4);

    $("input[name='cell-5-0']").val(2);
    $("input[name='cell-5-1']").val(9);
    $("input[name='cell-5-2']").val(4);
    $("input[name='cell-5-3']").val(7);
    $("input[name='cell-5-5']").val(3);
    $("input[name='cell-5-6']").val(1);

    $("input[name='cell-6-1']").val(2);
    $("input[name='cell-6-3']").val(4);
    $("input[name='cell-6-5']").val(8);
    $("input[name='cell-6-6']").val(5);
    $("input[name='cell-6-8']").val(6);

    $("input[name='cell-7-1']").val(5);
    $("input[name='cell-7-2']").val(1);
    $("input[name='cell-7-4']").val(6);
    $("input[name='cell-7-5']").val(7);
    $("input[name='cell-7-6']").val(4);
    $("input[name='cell-7-7']").val(9);

    $("input[name='cell-8-1']").val(6);
    $("input[name='cell-8-2']").val(7);
    $("input[name='cell-8-4']").val(2);
    $("input[name='cell-8-5']").val(9);
    $("input[name='cell-8-7']").val(1);
    $("input[name='cell-8-8']").val(3);
  });
});
</script>
</body>
</html>
