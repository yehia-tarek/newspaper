<?php
include 'init.php';

$stmt = $conn->prepare("SELECT * FROM news");
    $stmt->execute();
    $result = $stmt->get_result();

    ?>
    <table>
        <tr>
            <th>title</th>
            <th>content</th>
            <th>date</th>
            <th>category</th>
            <th>action</th>
        </tr>
        
        <?php while($row = $result->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $row['title'] ?></td>
            <td><?php echo $row['content'] ?></td>
            <td><?php echo $row['news_date'] ?></td>
            <td><?php 
                        $stmt2 = $conn->prepare('SELECT  category_name 
                        FROM categories as t1
                        LEFT JOIN news_cat as t2 
                        ON t1.id = t2.cat_id
                        WHERE t2.news_id = (?)');
                        $stmt2->bind_param("i",$row['newsID']);
                        $stmt2->execute();
                        $result2 = $stmt2->get_result();
                        
                        while($row2 = $result2->fetch_assoc()){ 
                            echo $row2['category_name']."<br>";
                        }
                ?></td>
            <td>
                <a href="news.php?do=edit&newsID=<?php echo $row['newsID'] ?>">edit</a>
                <a href="news.php?do=delete&newsID=<?php echo $row['newsID'] ?>">delete</a>
            </td>
        </tr>
        <?php } ?>
        
    </table>