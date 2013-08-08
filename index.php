<?php 
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$pagetitle="Add Tag";
include("$root/scripts/db-connection.php"); 
include("$root/scripts/settings.php");
include("$root/scripts/header.php"); 

?>
		<h1>Visual Dictionary</h1>

		<section style="max-width:900px;padding-top:1em;">
			<div style="text-align:center;width:40%;float:left;">
			<div id="sites">
			From<br>
			<?php
			$stmt=$dbh->prepare("SELECT * FROM `languages`");
			$stmt->execute();
		
			while ($row = $stmt->fetch()) {			
echo '			<input type="radio" class="leftradio" name="site" id="'.$row["accro"].'" value="'.$row["accro"].'"/><label title="'.$row["fulltext"].'" id="'.$row["accro"].'21" for="'.$row["accro"].'"><img src="/static/img/flags/'.$row["flagurl"].'"  /></label>';
			}
			
			?>
			</div>
			</div>
			
			<div style="text-align:center;width:20%;float:left;">
			<br>
			<a class="button" id="invertbutton" style="padding:0.8em;padding-bottom:0.3em"><i class="icon-exchange icon-2x"></i></a>
			</div>
			
			<div style="text-align:center;width:40%;float:left;">
			<div id="sites2">
			To<br>
						<?php
			$stmt=$dbh->prepare("SELECT * FROM `languages`");
			$stmt->execute();
		
			while ($row = $stmt->fetch()) {			
echo '			<input type="radio" class="rightradio" name="site2" id="'.$row["accro"].'2" value="'.$row["accro"].'"/><label title="'.$row["fulltext"].'" id="'.$row["accro"].'22" for="'.$row["accro"].'2"><img src="/static/img/flags/'.$row["flagurl"].'"   /></label>';
			}
			
			?>			</div></div>
			
			<br><br><br><br>
			<input style="padding:" id="searchbox" type="text" placeholder="Type Translation Here" /><br><br>
			
			<div class="tag-image-wrapper" id="image-workspace" style="text-align:center;">
			</div>
			
			<br>
			<span id="resultslist"></span>
		
		</section>
		<div style="margin:auto;max-width:900px;text-align:right">
		<a href="#">Tag more images</a> to improve translation accuracy
		</div>
		
		<script>
		$("#image-workspace").hide();
		
		$('#sites input:radio').addClass('input_hidden');
		$('#sites label').click(function() {
			$(this).addClass('selected').siblings().removeClass('selected');
		});
		$('#sites2 input:radio').addClass('input_hidden');
		$('#sites2 label').click(function() {
			$(this).addClass('selected').siblings().removeClass('selected');
		});
		
		$('#invertbutton').click(function() {
			if($("input[type='radio'].leftradio").is(':checked')) {
				var card_type = $("input[type='radio'].leftradio:checked").val();
				var card_type2 = $("input[type='radio'].rightradio:checked").val();
								
				$('input.leftradio').val([card_type2]);
				$('input.rightradio').val([card_type]);
				
				//$("input[type='radio'].rightradio").filter('[value="'+card_type+'"]').attr('checked', true);

				$("#"+card_type2+"21").addClass('selected').siblings().removeClass('selected');
				$("#"+card_type+"22").addClass('selected').siblings().removeClass('selected');
			}

		})
		
		$("#searchbox").keyup(function(e) {
		 if (e.which == 13) {
			$("#image-workspace").slideUp({"queue":true});
			if ($(this).val()!="") {
			
			var objjy=$(this);
			
			$.getJSON('api.php?type=searchimages&query='+$(this).val()+'&from='+$("input[type='radio'].leftradio:checked").val()+'&to='+$("input[type='radio'].rightradio:checked").val(), function(data) {
				
				if (data.error===undefined) {
					$("#image-workspace").empty();
					$("#image-workspace").append('<span style="text-align:left;float:left;">Showing Results For "'+objjy.val()+'"</span><br>')
					for(var s in data.images) {
						$("#image-workspace").append('<img onclick="imageclick(this)" style="margin:0.4em;" width="20%" src="'+data.images[s]+'" />')
					}
				} else {
						$("#image-workspace").empty();
						$("#image-workspace").append(data.error)
			}
			$("#image-workspace").slideDown({"queue":true});
			
			});
			
			} else {
				$("#image-workspace").empty();
				//$("#image-workspace").slideDown({"queue":true});
			}
			
			}

		});
		
		$('.workimage').click(function() {
			alert("hi");
			
		});
		
		function imageclick(elem){	
			$(elem).toggleClass("hover");
			
			var thing = new Object();
			thing.images = new Array();
			var i;
			
			$('.hover').each(function(i, obj) {
				thing.images[i]=$(this).attr("src");
				i++;
			});
			
			var array = $.toJSON( thing );
			
			$.getJSON('api.php?type=translate&array='+array+'&from='+$("input[type='radio'].leftradio:checked").val()+'&to='+$("input[type='radio'].rightradio:checked").val(), function(data) {
			
			$("#resultslist").empty();
							
				for(var s in data.results) {
						$("#resultslist").append('<span>'+data.results[s]+'</span><br>')
				}

			
			});
			

		}
		
		</script>

<?php 
include("$root/scripts/footer.php"); 
?>