<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />

    <title>Ders Takip Uygulaması</title>
</head>

<body>
    <div class="container">
        <h1 class="h2 center">Ders Takip Uygulaması</h1>
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
                <?php
                $d = 1;
                while ($d <= 5) {
                    $sqlLessName = "SELECT * FROM `lessons` WHERE FkLessonDay='" . $d . "'";
                    $result = $conn->query($sqlLessName);
                    while ($row = $result->fetch_assoc()) {
                        $lessons[] = $row;
                        $LessonName = $row["LessonName"];
                        $LessonTime = $row["LessonTime"];
                        $LessonTime = substr($LessonTime, 0, -3);
                ?>
                        <td><?php echo $LessonName . "<hr>" . "<p class=hidden>$row[id]</p>" . $LessonTime ?></td>

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
                    <?php



                    foreach ($lessons as $lesid) {

                        $lessonid = $lesid['id'];
                        $sqlQuery = "SELECT * from watchstats INNER JOIN weeks on watchstats.FkLessonWeekName=weeks.id WHERE FkLessonId='" . $lessonid . "' and FkLessonWeekName='" . $week . "' ";
                        $resultSet = mysqli_query($conn, $sqlQuery) or die("database error:" . mysqli_error($conn));

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
                                <input id="testName" type="checkbox" name="check[]" value="1" <?php echo $checkcontrol ?>>

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
                        $lessonid2 = $lesid2['id'];
                        $sqlQuery = "UPDATE watchstats INNER JOIN weeks on watchstats.FkLessonWeekName=weeks.id SET watchstats.`Status`='" . $lessoncheck[$i] . "' WHERE FkLessonId='" . $lessonid2 . "' and FkLessonWeekName='" . $week2 . "'  ";
                        $conn->query($sqlQuery);
                        $i++;
                    }
                }
                echo "<meta http-equiv='refresh' content='0'>";
            }
            //----Güncelleme----
        } //function;




        ?>

        <form id="form" action="" method="POST">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>

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
            <input class="btn btn-primary" type="submit" value="Güncelle">


        </form>



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