<?php if(isset($_SESSION["user_type"]) && $_SESSION["user_type"] == GROUP_ADMIN) {
?>
<div class="container mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="whatsapp_message">
            
            	<?php
            	include("connection.php");
            	$company_id = $_GET["company"];
            	$query = mysqli_query($conn, "SELECT * FROM wp_message_history where company_id = '$company_id' order by id desc");
            	$history_row = mysqli_fetch_assoc($query);
            
            	if(isset($history_row['company_id'])) {
            	    $template_name = "";
            	    if($history_row['template_name'] == 1) {
            	        $template_name = "SOxNOx - 2023";
            	    } else if($history_row['template_name'] == 2) {
            	        $template_name = "cemCCUS - 2023";
            	    } else if($history_row['template_name'] == 3) {
            	        $template_name = "Gasification India - 2023";
            	    } else if($history_row['template_name'] == 4) {
            	        $template_name = "Hydrogen - 2024";
            	    } else if($history_row['template_name'] == 5) {
            	        $template_name = "W2E";
            	    } else if($history_row['template_name'] == 6) {
            	        $template_name = "Community";
            	    }
            	?>
            		<div class="alert alert-success"><?php echo $history_row['body_message'] . ' <br>' . $history_row['created_at']. ' <br> Template Name: ' . $template_name; ?></div>
            	<?php } ?>
            
            	<?php if(isset($_GET['status'])) { ?>
            		<div class="alert alert-success">All user message send using whatsapp.</div>
            	<?php } ?>

            	<span class="sect_title"><b>WhatsApp Messages</b></span>
            	    
            	    <input type="hidden" name="search" value="<?php echo(isset($_GET['search'])) ? $_GET['search'] : '' ;?>">

            	    <?php
                        /* if(isset($_GET['sactive'])) {
                	    $sactive = "";
                	    foreach($_GET['sactive'] as $checkbox) { ?>
                            <input type="hidden" name="sactive[]" value="<?php echo $checkbox; ?>">
                        <?php }
                    } */ ?>

            		<select id="template" name="template" class="form-control" required>
            		    <option value="">Select Template</option>
            		    <option value="1">SOxNOX - 2023</option>
            		    <option value="2">cemCCUS - 2023</option>
            		    <option value="3">Gasification India - 2023</option>
            		    <option value="4">Hydrogen - 2024</option>
            		    <option value="5">W2E</option>
            		    <option value="6">Community</option>
            		</select>
            		<!-- <input type="number" class="textbox" name="mobile_no" placeholder="Mobile no.">
            		<input type="text" class="textbox" name="header_message" placeholder="Header Message" readonly> -->
            		<textarea name="body_message" rows="13"class="textbox" id="body_message" placeholder="Type your message" style="display:none;"></textarea>
            		<input type="submit" class="btn btn-success" name="submit" value="Send Message">
            <?php } ?>
        </div>
    </div>
</div>