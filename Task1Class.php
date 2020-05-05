<?php

class Task1Class
{
    public function __construct()
    {
        $this->mysqli = new mysqli("localhost", "root", "", "ecommerce");

        if ($this->mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
            exit();
        }
    }

    private function getData()
    {
        $sql = "select category.Name, count(item_category_relations.id) as total_item from `category` 
      LEFT JOIN `item_category_relations` ON item_category_relations.categoryId = category.id
      group by category.id order by total_item DESC";

        $result = $this->mysqli->query($sql);
        $allCategory = $result->fetch_all();
        return $allCategory;
    }

    function printData()
    {
        $allCategory = $this->getData();

        echo "<table border=\"1\">
    <thead>
        <tr>
            <th>Category Name</th>
            <th>Total Items</th>
        </tr>
    </thead>
    <tbody>";
        if (count($allCategory) > 0) {
            foreach ($allCategory as $category) {
                echo "<tr>
            <td>$category[0]</td>
            <td>$category[1]</td>
        </tr>";
            }
        } else {
            echo "<tr>
            <td colspan=\"2\">No Data Found</td>
        </tr>";
        }
    }

}
$obj = new Task1Class();
$obj->printData();