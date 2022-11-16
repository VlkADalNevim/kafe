
<?php 
require_once "db.php";

$query=mysqli_query($connection,"SELECT types.typ, count(drinks.ID) as pocet, people.name as jmeno 
                                 FROM drinks
                                 INNER JOIN people ON drinks.id_people = people.ID
                                 INNER JOIN types ON drinks.id_types = types.ID
                                 GROUP BY people.name");
          
$jmena=mysqli_query($connection,"SELECT name as jmeno FROM people");

if (isset($_GET['submit'])) {
    $vypis = $_GET['uzivatele'];
    $vypisQuery=mysqli_query($connection,"SELECT types.typ, count(drinks.ID) as pocet, people.name as jmeno 
                                     FROM drinks
                                     INNER JOIN people ON drinks.id_people = people.ID
                                     INNER JOIN types ON drinks.id_types = types.ID
                                     WHERE people.name = '$vypis'
                                     GROUP BY types.typ");
    $utf8_string = utf8_encode($vypisQuery);
    echo bin2hex($utf8_string), "\n";
    }
?>

<!DOCTYPE html>
<html>
	<head>
        <meta charset="UTF-8">
        <!-- Responsive Design -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/9526c175c2.js" crossorigin="anonymous"></script>
        <!-- CSS -->
        <link href="css/index.css" rel="stylesheet" type="text/css">

	</head>

	<body>
        <div class="table">
            <table>
                <tr>
                    <th>Kdo</th>
                    <th>Pocet</th>
                </tr>
                <?php while ($row = mysqli_fetch_array($query)) { ?>
                    <tr>
                        <td><?php echo $row['jmeno']; ?></td>
                        <td><?php echo $row['pocet']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <div class="option">
            <form action="index.php" method="GET">
                    <select id="uzivatele" name="uzivatele">
                        <?php while ($vypisjmen = mysqli_fetch_array($jmena)) { ?>
                            <option name="option"value="<?php echo $vypisjmen['jmeno']; ?>"><?php echo $vypisjmen['jmeno']; ?></option>
                        <?php } ?>
                    </select>
                <input type="submit" name="submit">
            </form>
            <p>Vybran: <?php echo $vypis; ?></p>
        </div>

        <div class="vypis">
            <table>
                    <tr>
                        <th>Typ</th>
                        <th>Pocet</th>
                    </tr>
                    <?php while ($vypisRow = mysqli_fetch_array($vypisQuery)) { ?>
                        <tr>
                            <td><?php echo $vypisRow['typ']; ?></td>
                            <td><?php echo $vypisRow['pocet']; ?></td>
                        </tr>
                    <?php } ?>
            </table>
        </div>

	</body>
</html>
