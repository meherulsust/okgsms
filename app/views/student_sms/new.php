<div class="box box-primary">
  <div class="box-header">
    <i class="fa fa-pencil-square-o"></i>
    <h3 class="box-title"><?php echo $page_title; ?></h3>
      <div class="box-tools pull-right">
        <a class="ajax_link" href="<?=$site_url . $link_action;?>">
          <button class="btn btn-primary btn-xs" type="button"><i class='fa fa-bars'></i>
            <?php echo $link_title; ?></button>
        </a>
      </div>
    </div>
  <form class="ajax_submit" role="form" action="<?=$site_url . $active_controller?>/add" method="post"
    enctype="multipart/form-data">
    <table class="form_table">
      <tr>
				<td>title :</td>
				<td>
					<select name="message_id" class="form-control message">
						<option value="">---- None ----</option>
						<?php echo html_options($message_options,set_value('message_id'));?>
					</select>
				</td>
			</tr>	
			<tr>
				<td>Full Message :</td>
				<td>
					<textarea type="text" class="form-control full_message" rows="10" name="full_message"><?=set_value('full_message'); ?></textarea>
					<span class="error">* <?php echo form_error('full_message'); ?></span>
					<div id="charNum">(Maximum 480 characters)</div> 
				</td>
			</tr>
      <tr>
				<td>Class :</td>
				<td>
					<select name='class_id' class='form-control' id="class_id" required>
						<option value="" >---- Select Class ----</option>
						<?php echo html_options($class_options,set_value('class_id')); ?>
					</select>
					<span class='error'>* <?php echo form_error('class_id'); ?> </span>
				</td>
				<input type="hidden" name="class_code" id="class_code" />
			</tr>
      <tr>
        <td></td>
        <td>
          <button type="submit" class="btn btn-sm btn-primary">Submit</button>
          <button type="reset" class="btn btn-sm btn-danger">Reset</button>
        </td>
      </tr>
    </table>
  </form>
</div>

<script>

	$(document).ready(function() {

		$(".ickeck").iCheck({
      checkboxClass: 'icheckbox_minimal group',
      radioClass: 'iradio_minimal'
    });

		// get full message

		$('.message').change(function(){
			var message_id = $(this).val();
			$.ajax(
			{
				url : "<?php echo $site_url;?>StudentSms/get_full_message",
				type: "POST",
				data : 'message_id='+message_id,
				success: function(response)
				{
					var len = response.length;
					$('#charNum').html(count_character(len));
					$(".full_message").val(response);
				}				

			});

      });

		

		// get student list

		$('#class').change(function(){

			var class_id = $(this).val();
			$.ajax(
			{
				url : "<?php echo $site_url;?>sms_notification/get_student_list",
				type: "POST",
				data : 'id='+class_id,
				success: function(response)
				{
					$("#student_list").html(response);
				}

			});

    });

    $('.full_message').on("change input paste keyup", function() {
    var len = $(this).val().length;
    $('#charNum').html(count_character(len));

		});



	function count_character(len)
  {
    var max = 480;
    if (len >= max) {
      return '<span style="color:red">You have reached the limit.</span>';
    } else {
      var char = max - len;
      return '<span style="color:green">'+ char + ' characters left.</span>';
    }
  }

    });

</script>