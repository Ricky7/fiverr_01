<?php

    class Checklist {

        private $db; 

        function __construct($db_conn) {

            $this->db = $db_conn;

        }

        public function getEmpresas() {

            try {
                // Ambil data kategori dari database
                $query = $this->db->prepare("SELECT * FROM empresas");
                $query->execute();
                return $query->fetchAll();
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function checklist($query) {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
        
            if($stmt->rowCount()>0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    ?>

                    <tr>
                        <td><?php print($row['che_id']); ?></td>
                        <td><?php print($row['che_nombre']); ?></td>
                        <td><?php print($row['emp_nombre']); ?></td>
                        <td><?php print($row['che_activo']); ?></td>
                        <td><?php print($row['che_tipo']); ?></td>
                        <td>
                        <button type="button" class="btn btn-info btn-xs edit_button" 
                            data-toggle="modal" data-target="#myModalEdit"
                            data-empnombre="<?php print($row['emp_nombre']);?>"
                            data-empid="<?php print($row['emp_id']);?>"
                            data-cheactivo="<?php print($row['che_activo']);?>"
                            data-chetipo="<?php print($row['che_tipo']);?>"
                            data-chenombre="<?php print($row['che_nombre']);?>"
                            data-id="<?php print($row['che_id']); ?>">
                            Edit
                        </button>
                        <a href="#" data-href="checklist_del.php?id=<?php print($row['che_id']); ?>" data-toggle="modal" data-nombre="<?php print($row['che_nombre']);?>" data-target="#confirm-delete" class="btn btn-danger btn-xs">Remove</a> 
                        </td> 
                    </tr>
                    <?php
                }
            }
            else
            {
                ?>
                <tr>
                <td>Tidak ditemukan....</td>
                </tr>
                <?php
            }

        }

        public function insertCheck($fields = array()) {

            $keys = array_keys($fields);

            $values = "'" . implode( "','", $fields ) . "'";

            $sql = "INSERT INTO checklist (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;

        }

        public function editCheck($fields = array(), $id) {

            $set = '';
            $x = 1;

            foreach ($fields as $name => $value) {
                $set .= "{$name} = '{$value}'";
                if($x < count($fields)) {
                    $set .= ', ';
                }
                $x++;
            }

            //var_dump($set);
            $sql = "UPDATE checklist SET {$set} WHERE che_id = {$id}";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;
        }

        public function delCheck($che_id) {
            $stmt = $this->db->prepare("DELETE FROM checklist WHERE che_id=:che_id");
            $stmt->bindparam(":che_id",$che_id);
            $stmt->execute();
            return true;
        }

        public function paging($query,$records_per_page)
        {
            $starting_position=0;
            if(isset($_GET["page_no"]))
            {
                $starting_position=($_GET["page_no"]-1)*$records_per_page;
            }
            $query2=$query." limit $starting_position,$records_per_page";
            return $query2;
        }

        public function paginglink($query,$records_per_page)
        {
            
            $self = $_SERVER['PHP_SELF'];
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            $total_no_of_records = $stmt->rowCount();
            
            if($total_no_of_records > 0)
            {
                ?><ul class="pagination"><?php
                $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
                $current_page=1;
                if(isset($_GET["page_no"]))
                {
                    $current_page=$_GET["page_no"];
                }
                if($current_page!=1)
                {
                    $previous =$current_page-1;
                    echo "<li><a href='".$self."?page_no=1'>First</a></li>";
                    echo "<li><a href='".$self."?page_no=".$previous."'>Previous</a></li>";
                }
                for($i=1;$i<=$total_no_of_pages;$i++)
                {
                    if($i==$current_page)
                    {
                        echo "<li><a href='".$self."?page_no=".$i."' style='color:red;'>".$i."</a></li>";
                    }
                    else
                    {
                        echo "<li><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
                    }
                }
                if($current_page!=$total_no_of_pages)
                {
                    $next=$current_page+1;
                    echo "<li><a href='".$self."?page_no=".$next."'>Next</a></li>";
                    echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last</a></li>";
                }
                ?></ul><?php
            }
        }


    }
?>