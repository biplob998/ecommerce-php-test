<?php
$mysqli = new mysqli("localhost", "root", "", "ecommerce");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
$sql = "select category.Name, count(item_category_relations.id) as total_item from `category` 
      LEFT JOIN `item_category_relations` ON item_category_relations.categoryId = category.id
      group by category.id order by total_item DESC";

$result = $mysqli->query($sql);
$allCategory = $result->fetch_all();
?>

<table border="1">
    <thead>
        <tr>
            <th>Category Name</th>
            <th>Total Items</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if(count($allCategory)>0) {
    foreach ($allCategory as $category) {
        ?>
        <tr>
            <td><?php echo $category[0]?></td>
            <td><?php echo $category[1]?></td>
        </tr>
        <?php
    }
    }else{?>
        <tr>
            <td colspan="2">No Data Found</td>
        </tr>
    <?php }
    ?>
    </tbody>
</table>