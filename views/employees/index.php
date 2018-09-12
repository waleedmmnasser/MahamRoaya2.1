<h1>الموظفون</h1>

<table>
<?php
    foreach($this->employees as $emp) {
        echo '<tr>';
        echo '<td>' . $emp->getFirstName() . '</td>';
        echo '<td>' . $emp->getFatherName() . '</td>';
        echo '<td>' . $emp->getFamilyName() . '</td>';
        echo '<td>
                <a href="'.URL.'employees/edit/'.$emp->getId().'">عدل</a> 
                <a href="'.URL.'employees/delete/'.$emp->getId().'">احذف</a></td>';
        echo '</tr>';
    }
?>
</table>