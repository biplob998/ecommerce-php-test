<?php
$mysqli = new mysqli("localhost", "root", "", "ecommerce");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
$sql = "select category.Id, category.Name, catetory_relations.ParentcategoryId, count(item_category_relations.id) as total_item from `category` 
      LEFT JOIN `item_category_relations` ON item_category_relations.categoryId = category.id
      LEFT JOIN catetory_relations ON catetory_relations.categoryId = category.id
      group by category.id order by total_item DESC";

$result = $mysqli->query($sql);
$allCategory = $result->fetch_all();
$filterCategory = [];
foreach ($allCategory as $key => $category) {
    $filterCategory[$category[0]] = $allCategory[$key];
}

foreach ($allCategory as $key => $category) {
    if (!is_null($category[2])) {
        if (array_key_exists($category[2], $filterCategory)) {
            $filterCategory[$category[2]]['child'][] = $filterCategory[$category[0]];
        } else {
            unset($filterCategory[$category[0]]);
        }
    }
}

foreach ($filterCategory as $key => $category) {
    if (array_key_exists(2, $category) && $category[2] != 0 && $category[2] != null) {
        unset($filterCategory[$key]);
    }
}

function printTree($filterCategory = null)
{
    if (!is_null($filterCategory)) {
        echo '<ul>';
        foreach ($filterCategory as $node) {
            echo "<li>" . $node[1] . ' (' . $node[3] . ')';
            printTree($node['child'] ?? null);
            echo '</li>';
        }
        echo '</ul>';
    }
}

echo printTree($filterCategory);
