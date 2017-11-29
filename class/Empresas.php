<?php

    class Empresas {

        private $db; 

        function __construct($db_conn) {

        	$this->db = $db_conn;

        }

        public function empresaslist($query) {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
        
            if($stmt->rowCount()>0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    ?>

                    <tr>
                        <td><?php print($row['emp_id']); ?></td>
                        <td><?php print($row['emp_nombre']); ?></td>
                        <td><?php print($row['emp_fecha_alta']); ?></td>
                        <td><?php print($row['emp_activa']); ?></td>
                       	<td><?php print($row['usu_clave']); ?></td>
                        <td>
                        <button type="button" class="btn btn-info btn-xs edit_button" 
                            data-toggle="modal" data-target="#myModalEdit"
                            data-nombre="<?php print($row['emp_nombre']);?>"
                            data-fecha="<?php print($row['emp_fecha_alta']);?>"
                            data-activa="<?php print($row['emp_activa']);?>"
                            data-usu="<?php print($row['usu_clave']);?>"
                            data-id="<?php print($row['emp_id']); ?>">
                            Edit
                        </button>
                        <a href="#" data-href="empresas_del.php?id=<?php print($row['emp_id']); ?>" data-toggle="modal" data-nombre="<?php print($row['emp_nombre']);?>" data-target="#confirm-delete" class="btn btn-danger btn-xs">Remove</a>	
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

        public function insertEmp($fields = array()) {

            $keys = array_keys($fields);

            $values = "'" . implode( "','", $fields ) . "'";

            $sql = "INSERT INTO empresas (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;

        }

        public function editEmp($fields = array(), $id) {

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
            $sql = "UPDATE empresas SET {$set} WHERE emp_id = {$id}";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;
        }

        public function delEmp($emp_id) {
            $stmt = $this->db->prepare("DELETE FROM empresas WHERE emp_id=:emp_id");
            $stmt->bindparam(":emp_id",$emp_id);
            $stmt->execute();
            return true;
        }

        function paging($query,$records_per_page)
        {
            $starting_position=0;
            if(isset($_GET["page_no"]))
            {
                $starting_position=($_GET["page_no"]-1)*$records_per_page;
            }
            $query2=$query." limit $starting_position,$records_per_page";
            return $query2;
        }

        function paginglink($query,$records_per_page)
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