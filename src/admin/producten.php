<?php
require './../../helpers/DB.php';

require './layouts/head.php';
require './layouts/nav.php';

$sql = "SELECT * FROM producten";
$query = $conn->prepare($sql);
$query->execute();
$results_product = $query->fetchAll();

?>
<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Naam</th>
            <th scope="col">Body</th>
            <th scope="col">Prijs</th>
            <th scope="col">Active</th>
            <th scope="col">Voorraad</th>
            <th scope="col">Actie</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results_product as $product) {
            $sql = "SELECT * FROM producten_voorraad WHERE pid=:pid";
            $query = $conn->prepare($sql);
            $query->bindValue(':pid', $product['id']);
            $query->execute();
            $voorraad = $query->fetch();
        ?>
            <tr>
                <th scope="row"><?php echo $product['id'] ?></th>
                <td><?php echo $product['naam']; ?></td>
                <td><?php echo $product['body']; ?></td>
                <td>€<?php echo $product['prijs']; ?></td>
                <td><?php echo $product['active']; ?></td>
                <td><?php echo $voorraad['voorraad']; ?></td>
                <td><a href="actie.php?pid=<?php echo $product['id']; ?>">Actie</a></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
























<?php
require './layouts/footer.php';
?>