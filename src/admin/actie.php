<?php
require './../../helpers/DB.php';

require './layouts/head.php';
require './layouts/nav.php';



$sql = "SELECT * FROM producten WHERE id=:pid";
$query = $conn->prepare($sql);
$query->bindValue(':pid', $_GET['pid']);

if(!$query->execute() || $query->rowCount() <= 0) {
    header("Location: index.php");
}
$producten = $query->fetch();

$sql = "SELECT * FROM producten_voorraad WHERE pid=:pid";
$query = $conn->prepare($sql);
$query->bindValue(':pid', $_GET['pid']);
$query->execute();
$voorraad = $query->fetch();

if(isset($_POST['wijzig'])) {
    $sql = "UPDATE producten SET naam=:naam, body=:body, prijs=:prijs, active=:active WHERE id=:pid";
    $query = $conn->prepare($sql);
    $query->bindValue(':naam', $_POST['naam']);
    $query->bindValue(':body', $_POST['body']);
    $query->bindValue(':prijs', $_POST['prijs']);
    $query->bindValue(':active', $_POST['active']);
    $query->bindValue(':pid', $_GET['pid']);
    if($query->execute()) {
        $sql = "UPDATE producten_voorraad SET voorraad=:voorraad WHERE pid=:pid";
        $query = $conn->prepare($sql);
        $query->bindValue(':voorraad', $voorraad['voorraad']);
        $query->bindValue(':pid', $_GET['pid']);
        if($query->execute()) {
            echo "Product gewijzigd.";
        } else {
            echo "Voorraad is niet geupdate.";
        }

        
    } else {
        echo "Product is niet geupdate.";
    }
}




?>

<form method="POST" class="align-items-center">
  <div class="mb-3">
    <label for="naam" class="form-label">Naam</label>
    <input type="text" class="form-control" id="naam" value="<?php echo $producten['naam'];?>" name="naam"> 
  </div>
  <div class="mb-3">
    <label for="body" class="form-label">Body</label>
    <input type="text" class="form-control" id="body" value="<?php echo $producten['body'];?>" name="body">
  </div>
  <div class="mb-3">
    <input type="number" class="form-number" id="prijs" value="<?php echo $producten['prijs'];?>" name="prijs">
    <label class="form-label" for="prijs">Prijs</label>
  </div>
  <div class="mb-3">
    <select class="form-select" name="active">
        <?php if($producten['active'] == 'Active') { ?>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
        <?php } else { ?>
        <option value="Inactive">Inactive</option>
        <option value="Active">Active</option>
        <?php } ?>
    </select>
  </div>
  <div class="mb-3 form-check">
    <input type="number" class="form-number" id="voorraad" value="<?php echo $voorraad['voorraad'];?>" name="active">
    <label class="form-label" for="voorraad">Voorraad</label>
  </div>
  <button type="submit" class="btn btn-primary" name="wijzig">Wijzig</button>
</form>

























<?php
require './layouts/footer.php';
?>