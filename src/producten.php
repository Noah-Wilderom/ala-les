<?php
require './include.php';
if(!isset($_SESSION)) session_start();

if(isset($_POST['submit_winkelmandje'])) {
    if(isset($_SESSION['winkelmandje'][$_POST['product_naam']])) {
        $_SESSION['winkelmandje'][$_POST['product_naam']]++;
    } else {
        $_SESSION['winkelmandje'][$_POST['product_naam']] = 1;
    }
}
if(isset($_SESSION['winkelmandje'])) print_r($_SESSION['winkelmandje']);
require './layouts/head.php';
require './layouts/nav.php';

$sql = "SELECT * FROM producten";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_OBJ);


?>

<div class="container">
    <div class="row justify-content-center ">

        <?php
        foreach($results as $result) {
            // Krijg de images van aparte tabel
            $sql = "SELECT * FROM producten_images WHERE pid= :pid";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':pid', $result->id);
            $stmt->execute();
            $img = $stmt->fetch(PDO::FETCH_OBJ);

            // Kijken of de voorraad nog genoeg is
            $sql = "SELECT * FROM producten_voorraad WHERE pid= :pid";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':pid', $result->id);
            $stmt->execute();
            $voorraad = $stmt->fetch(PDO::FETCH_OBJ);
        ?>

        <div class="col-4 pt-4">
            <div class="card text-center text-white bg-dark border border-dark border-5 rounded" style="width: 18rem;">
                <img src="./../assets/img/<?php echo $img->img_url; ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $result->naam;?></h5>
                    <p class="card-text"><?php echo $result->body;?></p>
                    <form method="POST">
                        <p class="<?php if($voorraad->voorraad <= 0) {echo 'text-danger'; }?>"><?php if($voorraad->voorraad <= 0) {echo 'Uitverkocht!'; }?></p>
                    <input type="hidden" name="product_naam" value="<?php echo $result->naam; ?>">
                    <button class="btn btn-primary mt-3 mb-3 <?php if($voorraad->voorraad <= 0) {echo 'disabled'; }?>" type="submit" name="submit_winkelmandje"><i class="fa fa-shopping-cart pe-2"></i>Winkelmandje</button>
                    </form>
                </div>
            </div>
        </div>

        <?php
        }
        ?>



    </div>
</div>
























<?php
require './layouts/footer.php';
?>