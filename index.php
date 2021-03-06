<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />

</head>

<title>Ders Takip Uygulaması</title>
</head>

<body style="background-color: #23272b;  color: white;">
  <div class="container">
    <br>
    <h1>Ders Takip Uygulaması</h1>
    <br>
    <?php
    include_once("db_connect.php");

    function findLessonDayCount($LessonDay, $conn)
    {
      $sqlLessonCount = "SELECT COUNT(id) as id FROM lessons WHERE FkLessonDay='" . $LessonDay . "'";
      $result = $conn->query($sqlLessonCount);
      $LessonCount = $result->fetch_assoc();
      $LessonCount = $LessonCount["id"];
      return ($LessonCount);
    };



    function findLessNameTime($conn)
    {
    ?>
      <tr>
        <td></td>
        <td></td>
        <?php
        $d = 1;
        while ($d <= 5) {
          $sqlLessName = "SELECT * FROM `lessons` WHERE FkLessonDay='" . $d . "'";
          $result = $conn->query($sqlLessName);
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $lessons[] = $row;
              $LessonName = $row["LessonName"];
              $LessonTime = $row["LessonTime"];
              $LessonTime = substr($LessonTime, 0, -3);
        ?>
              <td><?php echo $LessonName . "<hr>" . $LessonTime ?></td>

            <?php
            }
          }
          //Gün boşluk kontrol 
          else {
            $lessons[]['emptyday'] = "b";


            ?>
            <td><?php echo "Ders bulunmamaktadır" . "<hr>" ?></td>
        <?php
          }
          $d++;
        } //while d<=

        ?>
      </tr>
      <?php





      $sqlQueryweek = "select * from weeks";
      $resultSetweek = mysqli_query($conn, $sqlQueryweek) or die("database error:" . mysqli_error($conn));
      while ($developerweek = mysqli_fetch_assoc($resultSetweek)) {
        $week = $developerweek['id'];

      ?>
        <tr>
          <td><?php echo $developerweek['WeekName']; ?></td>
          <td><?php echo $developerweek['WeekDate']; ?></td>
          <?php



          foreach ($lessons as $lesid) {

            $lessonid = $lesid['id'];
            $emptyday = $lesid['emptyday'];
            $sqlQuery = "SELECT * from watchstats INNER JOIN weeks on watchstats.FkLessonWeekName=weeks.id WHERE FkLessonId='" . $lessonid . "' and FkLessonWeekName='" . $week . "' ";
            $resultSet = mysqli_query($conn, $sqlQuery) or die("database error:" . mysqli_error($conn));
            //Gün boşluk kontrol
            if ($emptyday == "b") {
          ?>
              <td>
                <input type="checkbox" disabled>
              </td>
            <?php
            }
            while ($developer = mysqli_fetch_assoc($resultSet)) {
              $checkvalue = $developer['Status'];
              $checkcontrol = "";
              if ($checkvalue == 1) {
                $checkcontrol = "checked";
              } elseif ($checkvalue == 0) {
                $checkcontrol = "";
              }
            ?>
              <td>
                <input type="checkbox" name="check[]" value="1" <?php echo $checkcontrol ?>>
              </td>
          <?php
            } //while
          } //foreach lesson
          ?>
        </tr>
        <?php

      } //while devoloperweek

      //----Güncelleme----
      foreach ($_POST['check'] as $lescheck) {
        $lessoncheck[] = $lescheck;
      }
      if (isset($_POST['check'])) {
        $i = 0;
        $sqlQueryweek2 = "select * from weeks";
        $resultSetweek2 = mysqli_query($conn, $sqlQueryweek2) or die("database error:" . mysqli_error($conn));
        while ($developerweek2 = mysqli_fetch_assoc($resultSetweek2)) {
          $week2 = $developerweek2['id'];
          foreach ($lessons as $lesid2) {
            $emptyday = $lesid2['emptyday'];
            $lessonid2 = $lesid2['id'];
            //Gün boşluk kontrol
            if ($emptyday == "b") {
            } else {
              $sqlQuery = "UPDATE watchstats INNER JOIN weeks on watchstats.FkLessonWeekName=weeks.id SET watchstats.`Status`='" . $lessoncheck[$i] . "' WHERE FkLessonId='" . $lessonid2 . "' and FkLessonWeekName='" . $week2 . "'  ";
              $conn->query($sqlQuery);
              $i++;
            }
          }
        }
        echo "<meta http-equiv='refresh' content='0'>";
      }
      //----Güncelleme----
    } //function;




    function addlesson($conn)
    {
      //Hafta Verileri Kontrol
      $sqlcheckweek = "SELECT id FROM weeks";
      $result = $conn->query($sqlcheckweek);
      if ($result->num_rows > 0) {
        $WeekAdded = True;
      }

      if (isset($_POST['addlesson'])) {
        if ($WeekAdded) {
          $lessonname = $_POST['lessonname'];
          $lessondayid = $_POST['lessondayid'];
          $lessontime = $_POST['lesstime'];



          $stmt = $conn->prepare("INSERT INTO lessons(LessonName,FkLessonDay,LessonTime) VALUES (?,?,?)");
          $stmt->bind_param("sss", $lessonname, $lessondayid, $lessontime);
          $stmt->execute();

          $sqlQueryLessonid = "SELECT * FROM lessons ORDER BY id DESC LIMIT 0, 1";
          $resultSetLessonid = mysqli_query($conn, $sqlQueryLessonid) or die("database error:" . mysqli_error($conn));
          $developerlessonid = mysqli_fetch_assoc($resultSetLessonid);
          $lessid = $developerlessonid['id'];


          $sqlQueryweek = "SELECT COUNT(id) AS WeekNumber FROM weeks;";
          $resultSetweek = mysqli_query($conn, $sqlQueryweek) or die("database error:" . mysqli_error($conn));
          $developerweek = mysqli_fetch_assoc($resultSetweek);
          $weeknumber = $developerweek['WeekNumber'];
          $a = 0;
          for ($x = 1; $x <= $weeknumber; $x++) {
            $stmt2 = $conn->prepare("INSERT INTO watchstats(FkLessonId,FkLessonWeekName,`Status`) VALUES (?,?,?)");
            $stmt2->bind_param("sss", $lessid, $x, $a);
            $stmt2->execute();
          }
          echo "<meta http-equiv='refresh' content='0'>";
        } else {
        ?>
          <div class="alert alert-danger alert-dismissible mt-3 fade show" role="alert">
            <strong>Öncelikle haftaları belirleyiniz.</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

    <?php
        }
      }
    }

    function deletelesson($conn)
    {
      if (isset($_POST['deletelesson'])) {
        $lessonid = $_POST['lessonid'];
        $stmt = $conn->prepare("DELETE lessons,watchstats FROM lessons INNER JOIN watchstats on lessons.id=watchstats.FkLessonId where lessons.id=? and watchstats.FkLessonId=?");
        $stmt->bind_param("ss", $lessonid, $lessonid);
        $stmt->execute();
        echo "<meta http-equiv='refresh' content='0'>";
      }
    }

    function addweekdate($conn)
    {
      if (isset($_POST['dateweek'])) {

        $stmt = $conn->prepare("DELETE weeks FROM weeks");
        $stmt2 = $conn->prepare("DELETE lessons FROM lessons");
        $stmt3 = $conn->prepare("DELETE watchstats FROM watchstats");
        $stmt4 = $conn->prepare("ALTER TABLE weeks AUTO_INCREMENT = 1;");
        $stmt->execute();
        $stmt2->execute();
        $stmt3->execute();
        $stmt4->execute();

        foreach ($_POST['weeknames'] as $weekname) {
          $weeknamearray[] = $weekname;
        }

        $i = 0;
        foreach ($_POST['weekdate'] as $weekdate) {
          $stmt5 = $conn->prepare("INSERT INTO weeks(WeekName,WeekDate) VALUES (?,?)");
          $stmt5->bind_param("ss", $weeknamearray[$i], $weekdate);
          $stmt5->execute();
          $i++;
        }
        echo "<meta http-equiv='refresh' content='0'>";
      }
    }



    ?>

    <form id="form" action="" method="POST">
      <table class="table table-dark table-striped ">
        <thead>
          <tr>
            <th>#</th>
            <th></th>
            <?php

            $LessonCount = findLessonDayCount(1, $conn);
            echo '<th scope="col" colspan="' . $LessonCount . '">Pazartesi</th>';
            $LessonCount = findLessonDayCount(2, $conn);
            echo '<th scope="col" colspan="' . $LessonCount . '">Salı</th>';
            $LessonCount = findLessonDayCount(3, $conn);
            echo '<th scope="col" colspan="' . $LessonCount . '">Çarşamba</th>';
            $LessonCount = findLessonDayCount(4, $conn);
            echo '<th scope="col" colspan="' . $LessonCount . '">Perşembe</th>';
            $LessonCount = findLessonDayCount(5, $conn);
            echo '<th scope="col" colspan="' . $LessonCount . '">Cuma</th>';

            ?>

          </tr>
        </thead>
        <tbody>
          <?php findLessNameTime($conn); ?>
        </tbody>
      </table>
      <div class="col-md-12 text-center">
        <input class="btn btn-primary" type="submit" value="Tablo Verilerini Güncelle">
      </div>
    </form>

    <div class="row">

      <?php
      $DisplayForm = True;
      if (isset($_POST['weekcount'])) {
        $DisplayForm = False;
        $weekcount = $_POST['weeknumber'];
      ?>
        <div class="col-md ">
          <form class="mt-3" action="" method="POST">
            <?php
            for ($i = 1; $i <= $weekcount; $i++) {
            ?>
              <div class=form-group>
                <label for="weekname<?php echo $i ?>"> <?php echo $i ?>.Hafta İçin Tarih Aralığı Giriniz: </label>
                <input type="hidden" name="weeknames[]" value="<?php echo $i ?>.Hafta">
                <input type="text" class="form-control bg-secondary text-white col-md" id="weekname<?php echo $i ?>" placeholder="" name="weekdate[]" required>
              </div>

            <?php
            }
            ?>
            <input class="btn btn-primary mt-1" onclick="return confirm('Hafta isimleri, dersler ve ders kayıtları silinecek emin misin?');" type="submit" name="dateweek" value="Tarih Aralıklarını Belirle">
          </form>
        </div>
      <?php
      }
      addweekdate($conn);

      if ($DisplayForm) {
      ?>
        <div class="col-md ">
          <form class="mt-3" action="" method="POST">
            <div class="form-group">
              <label class="font" for="weekcount">Hafta Sayısını Giriniz:</label>
              <input type="number" class="form-control bg-secondary text-white col-md" id="weekcount" name="weeknumber" value="14" min="1" max="20" required>
            </div>
            <input class="btn btn-primary mt-1" type="submit" name="weekcount" value="Hafta Sayısını Belirle">
          </form>
        </div>
      <?php

      }

      ?>




      <div class="col-md">
        <form class="mt-3" action="" method="POST">
          <div class="form-group">
            <label class="font" for="lessname">Ders Adı:</label>
            <input type="text" class="form-control bg-secondary text-white col-md" id="lessname" placeholder="Ders Adını Giriniz" name="lessonname" required>
          </div>
          <div class="form-group">
            <label class="font" for="lessday">Ders Günü:</label>
            <select class="form-control bg-secondary text-white col-md" name="lessondayid" id="lessday">
              <?php
              $sqlQueryDays = "select * from days";
              $resultSetDays = mysqli_query($conn, $sqlQueryDays) or die("database error:" . mysqli_error($conn));
              while ($developerDays = mysqli_fetch_assoc($resultSetDays)) {
                $dayid = $developerDays['id'];
                $dayname = $developerDays['DayName'];
              ?>
                <option value="<?php echo $dayid; ?>"><?php echo $dayname; ?></option>
              <?php

              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label class="font" for="appt">Zaman Seçin:</label>
            <input type="time" id="appt" class="form-control bg-secondary text-white col-md" name="lesstime" required>
          </div>
          <!-- Onay Mesajı Alma -->
          <!-- <input class="btn btn-primary mt-1" onclick="return confirm('Tüm izlenme verileri silinecek emin misin?');" type="submit" value="Hafta Sayısını Güncelle"> -->
          <input class="btn btn-primary mt-1" type="submit" name="addlesson" value="Ders Ekle">
        </form>
        <?php
        addlesson($conn);

        ?>

      </div>
      <div class="col-md">
        <form class="mt-3" action="" method="POST">
          <div class="form-group">
            <label class="font" for="selectlesson">Seçili Dersi Siliniz:</label>
            <select class="form-control bg-secondary text-white col-md" name="lessonid" id="selectlesson" required>
              <?php
              $sqlQueryLessons = "SELECT * FROM lessons";
              $resultSetLessons = mysqli_query($conn, $sqlQueryLessons) or die("database error:" . mysqli_error($conn));
              while ($developerLessons = mysqli_fetch_assoc($resultSetLessons)) {
                $lessonid = $developerLessons['id'];
                $lessonname = $developerLessons['LessonName'];
              ?>
                <option value="<?php echo $lessonid; ?>"><?php echo $lessonname; ?></option>
              <?php
              }

              ?>
            </select>
          </div>
          <!-- Onay Mesajı Alma -->
          <input class="btn btn-primary mt-1" onclick="return confirm('Seçili ders ve derse ait izlenme verileri silinecek emin misin?');" type="submit" name="deletelesson" value="Dersi Sil">

        </form>
        <?php
        deletelesson($conn);
        ?>
      </div>
    </div>

  </div>



  <script src="js/jquery-3.5.1.min.js"></script>
  <script type="text/javascript">
    // when page is ready
    $(document).ready(function() {
      // on form submit
      $("#form").on('submit', function() {
        // to each unchecked checkbox
        $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
      })
    })
  </script>



  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


</body>

</html>