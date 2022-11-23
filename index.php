<?php 
header('Content-type: text/html; charset=utf-8');
require_once "db.php";

// Vsichni dohromady
$celkove=mysqli_query($connection,"SELECT count(drinks.ID) as pocet, people.name as jmeno 
                                    FROM drinks
                                    INNER JOIN people ON drinks.id_people = people.ID
                                    INNER JOIN types ON drinks.id_types = types.ID
                                    GROUP BY people.name");
// Select uzivatele    
$jmena=mysqli_query($connection,"SELECT name as jmeno FROM people");

// Vypis jednotlice
if (isset($_GET['submit'])) {
    $id = $_GET['uzivatele'];
    $vypisJednotlive=mysqli_query($connection,"SELECT types.typ, count(drinks.ID) as pocet
                                                FROM drinks
                                                INNER JOIN people ON drinks.id_people = people.ID
                                                INNER JOIN types ON drinks.id_types = types.ID
                                                WHERE people.name = '$id'
                                                GROUP BY types.typ");




    }

?>

<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <!-- Responsive Design -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSS -->
        <link href="css/index.css" rel="stylesheet" type="text/css">

	</head>

	<body>
        <!-- Vsichni dohromady -->
        <div class="table">
            <table>
                <tr>
                    <th>Kdo</th>
                    <th>Pocet</th>
                </tr>
                <?php while ($vypisCelkove = mysqli_fetch_array($celkove)) { ?>
                    <tr>
                        <td><?php echo $vypisCelkove['jmeno']; ?></td>
                        <td><?php echo $vypisCelkove['pocet']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Select uzivatele -->
        <div class="option">
            <form action="index.php" method="GET">
                    <select id="uzivatele" name="uzivatele">
                        <?php while ($vypisjmen = mysqli_fetch_array($jmena)) { ?>
                            <option value="<?php echo $vypisjmen['jmeno']; ?>"><?php echo $vypisjmen['jmeno']; ?></option>
                        <?php } ?>
                    </select>
                <input type="submit" name="submit" value="Vypsat">
            </form>
            <p>Vybran: <?php echo $id; ?></p>
        </div>

        <!-- Vypis jednotlice -->
        <div class="vypis">
            <table>
                    <tr>
                        <th>Typ</th>
                        <th>Pocet</th>
                    </tr>
                    <?php while ($vypisRow = mysqli_fetch_array($vypisJednotlive)) { ?>
                        <tr>
                            <td><?php echo $vypisRow['typ']; ?></td>
                            <td><?php echo $vypisRow['pocet']; ?></td>
                            <?php $celk_cena = $celk_cena + count_all($vypisRow['typ'],$vypisRow['pocet']);?>
                        </tr>
                    <?php }?>
            </table>

            <!-- Vypis ceny pro jednotlivce -->
            <a>Propito celkem: </a>
            <a><?php echo round($celk_cena,2) . "Kč"; ?></a>

        </div>
	</body>
</html>

<?php 
function count_all($typ,$pocet){
    $cena = 0;
    switch ($typ) {
        case 'Mléko':
            $cena = ($pocet * 13.5);
            break;
            
        case 'Espresso':
            $cena = ($pocet * 0.3);
            break;

        case 'Coffe':
            $cena = ($pocet * 0.3);
            break;
    
        case 'Long':
            $cena = ($pocet * 0.3);
            break;

        case 'Doppio+':
            $cena = ($pocet * 0.3);
            break;
        
        default:
            return 0;
            break;
    }
    return $cena;
}
?>