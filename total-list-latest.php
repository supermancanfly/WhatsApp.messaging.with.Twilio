<?php 

include("main-header.php");

if(isset($_SESSION["user_id"]) && $_SESSION["user_type"]!=GROUP_ADMIN) {
    header("location:tpl.company.inc.php");
} ?>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!--<h5 class="mb-3">Total List</h5>
            <hr>-->
        </div>
        <div class="col-md-6">
            <form id="search_form">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" value="<?php echo(isset($_GET['search'])) ? $_GET['search'] : '' ;?>" Placeholder="Search Contact Name And Designation...">
                    </div>
                    <div class="col-md-3">
                    	<div class="custom-select new" id="custom-select"><b>Select Active</b></div>
                    	<div class="custom-select-option-box">
                    		<div class="custom-select-option">
                    			<input type="checkbox" class="active1 custom-select-option-checkbox" onclick="toggleselect(this)"
                    				value="All" /> <b>All</b>
                    		</div>
                    		<?php
                    			$result = GetAllStaffActive($user);
                    			while($row = mysqli_fetch_array($result)) {
                    				if($row["active"] == "1") {
                    					$checked=false;
                    					if(isset($_GET['sactive'])) {
                    						$sactive='';
                    						foreach($_GET['sactive'] as $checkbox) { 
                    							if($checkbox == $row["short"]) {
                    								$checked=true;
                    								break;
                    							}
                    						}
                    					} else {
                    						if($_SESSION["user_type"] != GROUP_ADMIN || ($_SESSION["user_type"] == GROUP_ADMIN && $row["default"] == "1")) {
                    							$checked=true;
                    						}
                    					} ?>
                    		<div class="custom-select-option">
                    			<input type="checkbox" class="active1 custom-select-option-checkbox" name="sactive[]"
                    				value="<?php echo $row["short"] ?>"
                    			<?php if($checked) echo "checked"?> />
                    			<?php echo $row["name"] ?>
                    		</div>
                    		<?php }
                        } ?>
                    	</div>
                    </div>

                    <div class="col-md-3">
                        <input type="submit" class="btn btn-success" value="Search">
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-4"></div>

        <div class="col-md-2">
            <form id="per_page_form">
                <!--<input type="hidden" name="page" value="<?php echo(isset($_GET['page'])) ? $_GET['page'] : 1 ;?>">-->

                <input type="hidden" name="search" value="<?php echo(isset($_GET['search'])) ? $_GET['search'] : '' ;?>">
                
                <?php
                if(isset($_GET['sactive'])) {
            	    $sactive = "";
            	    foreach($_GET['sactive'] as $checkbox) { ?>
                        <input type="hidden" name="sactive[]" value="<?php echo $checkbox; ?>">
                    <?php }
                } ?>

                <select name="per_page" class="per_page form-control">
            
                    <option value="200">200</option>
                    
                    <option <?php echo ($_GET['per_page'] == 500) ? 'selected' : ''; ?> value="500">500</option>
            
                    <option <?php echo ($_GET['per_page'] == 1000) ? 'selected' : ''; ?> value="1000">1000</option>
            
                    <option <?php echo ($_GET['per_page'] == 2000) ? 'selected' : ''; ?> value="2000">2000</option>
            
                    <option <?php echo ($_GET['per_page'] == 5000) ? 'selected' : ''; ?> value="5000">5000</option>
            
                    <option <?php echo ($_GET['per_page'] == 10000) ? 'selected' : ''; ?> value="10000">10000</option>
            
                    <option <?php echo ($_GET['per_page'] == 20000) ? 'selected' : ''; ?> value="20000">20000</option>
            
                    <option <?php echo ($_GET['per_page'] == 30000) ? 'selected' : ''; ?> value="30000">30000</option>
                </select>
            </form>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Active</th>
                            <th>Company Name</th>
                    		<th>Subsidary Name</th>
<!--                    		<th>ID</th>-->
                    		<th>Contact Name</th>
                    		<th>Designation</th>
                    		<th>WhatsApp</th>
                    		<th>Email Add</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
            		        $i=0;
                            $search = "";
                            if($_GET['search']) {
                                $search = "WHERE contact_name LIKE '%".$_GET['search']."%' OR designation LIKE '%".$_GET['search']."%'";
                            }

                            if(isset($_GET['sactive'])) {
                        	    $sactive = "";
                        	    
                        	    foreach($_GET['sactive'] as $checkbox) {   
                                    $sactive .= "active LIKE '%".$checkbox."%' OR ";
                                }
                                
                                if($_GET['search']) {
                                    $and_or = "OR";
                                } else {
                                    $and_or = "WHERE";
                                }

                                $search .= "$and_or ". rtrim($sactive, " OR");
                            }

                		    $pquery = "SELECT * FROM tbl_address_new $search";

                		    $presult = mysqli_query($conn ,$pquery);
                		    if(!isset($_GET['page'])) {  
                                $page = 1;  
                            } else {
                                $page = $_GET['page'];
                            }
                            
                            if(isset($_GET['per_page'])) { 
                                $results_per_page = $_GET['per_page'];
                            } else {
                                $results_per_page = 200;
                            }
                            $page_first_result = ($page-1) * $results_per_page;
                            $number_of_result = mysqli_num_rows($presult);
        
                            $number_of_page = ceil ($number_of_result / $results_per_page);
        
                            $query = "SELECT tbl_address_new.*, tbl_subsidiary.subsidiary_name FROM tbl_address_new LEFT JOIN tbl_subsidiary ON tbl_subsidiary.subsidiary_id = tbl_address_new.subsidiary $search ORDER BY company ASC, subsidiary_name ASC, active ASC LIMIT " . $page_first_result . ',' . $results_per_page;
        
                		    $t_result = mysqli_query($conn ,$query);
                            while($row = mysqli_fetch_assoc($t_result)) { ?>
                                <tr style="text-align:left;">
                                    <td><?php echo $row["active"]?></td>
                                    <td><?php echo $row["company"]?></td>
                                    <td><?php echo $row["subsidiary_name"] ?></td>
<!--                                    <td><?php echo $row["address_id"] ?></td>-->
                                    <td><?php echo $row["contact_name"] ?></td>
                                    <td><?php echo $row["designation"] ?></td>
                                    <td><?php echo $row["cell"] ?></td>
                                    <td><?php echo $row["email"] ?></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">

            <ul class="pagination">
                <?php
                $pagLink = "";
                
                if(isset($_GET['per_page'])) { 
                    $extra_parameter = "&per_page=". $_GET['per_page'];
                }
                
                if(isset($_GET['search'])) { 
                    $extra_parameter .= "&search=".$_GET['search'];
                }
                
                if(isset($_GET['sactive'])) {
            	    $sactive = "";

            	    foreach($_GET['sactive'] as $checkbox) {   
                        $sactive .= "&sactive[]=".$checkbox;
                    }

                    $extra_parameter .= $sactive;
                }

                if($page >= 2) {
                    echo "<li class='page-item'><a class='page-link' href='?page=".($page-1).$extra_parameter."'>  Prev </a></li>";
                }
        
                for ($i=1; $i<=$number_of_page; $i++) {   
                    if ($i == $page) {
                        $pagLink .= "<li class='page-item'><a class = 'page-link active' href='?page=".$i.$extra_parameter."'>".$i."</a></li>";   
                    } else {
                        $pagLink .= "<li class='page-item'><a href='?page=".$i.$extra_parameter."' class='page-link'>".$i."</a></li>";
                    }
                };
                echo $pagLink;
        
                if($page < $number_of_page) {   
                    echo "<li class='page-item'><a href='?page=".($page+1).$extra_parameter."' class='page-link'>Next</a></li>";
                } ?>
            </ul>
        </div>
    </div>
</div>

<form action="total-list-message.php" method="POST" class="text-center">

    <?php
        $t_result = mysqli_query($conn ,$query);
        while($t_row = mysqli_fetch_assoc($t_result)) {
            if($t_row['cell']) { ?>
            <input type="hidden" name="contract_data[<?php echo $t_row['contact_name']; ?>]" value="<?php echo $t_row['cell']; ?>">
        <?php }
        }

    include("whatsapp-template.php"); ?>

</form>

<?php include("main-footer.php"); ?>

<script>
$(function() {
    $(".per_page").change(function() {
        $("#per_page_form").submit();
    });
});
</script>
