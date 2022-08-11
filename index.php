<!DOCTYPE html>
<html>
  <head>
    <meta chartset="UTF-8">
    <title>Timon php-demo</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>
  <body>
    <p>Tänään on <?php echo date("j.n.Y"); ?>.</p>

    <?php

    $url = "https://external.api-test.yle.fi/v1/teletext/pages/102.json?app_id=d3aada89&app_key=991240522bbda233ba5f23cccfac6db9";
    if ($_POST['sivunumero'] != ""){
      $url = "https://external.api-test.yle.fi/v1/teletext/pages/".$_POST['sivunumero'].".json?app_id=d3aada89&app_key=991240522bbda233ba5f23cccfac6db9";
    }
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
      "Accept: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($resp);
    $taulukko = $data->teletext->page->subpage[0]->content[0]->line;
    ?>
    <div class="container">
      <h1>Tennilän tietotoimisto</h1>
      <p>Ylen TextiTV:n webbiliittymä</p>

      <div class="row">
        <div class="col">
          <h2>Hae sivua</h2>

          <form action="index.php" method="post">
            <div class="form-group">
              <label for="sivu">Sivu</label>
              <input type="number" name="sivunumero" class="form-control">
            </div>
            <button type="submit" name="hae" class="btn btn-primary">Hae sivu</button>
          </form>
          <?php
            #echo("<p>".$data->teletext->page->subpage[0]->content[0]->line[5]->Text."</p>")
          ?>
        </div>
        <div class="col">
          <h2>Uutiset</h2>

          <ul class="list-group">
    <?php
    foreach ($taulukko as $rivi){
      if ($rivi->Text != ""){
        echo("<li class='list-group-item'>".$rivi->Text."</li>");
      }
    }

    ?>
          </ul>
        </div>
  </body>
</html>