<?php 
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include("$root/scripts/db-connection.php"); 
include("$root/scripts/settings.php");
include("$root/scripts/header.php"); 

if ($_SESSION["tag_added"]==0) {
	header("Location: tagoverlay.php");
	exit();
}
?>
		<h1>Visual Dictionary</h1>

		<section style="padding-top:1em;">
			<div class="translatebar">
			<div id="sites">
			From<br>
			<?php
			$stmt=$dbh->prepare("SELECT * FROM `languages`");
			$stmt->execute();
		
			while ($row = $stmt->fetch()) {			
if (1==1) {
			echo '			<input type="radio" class="leftradio" name="site" id="'.$row["accro"].'" value="'.$row["accro"].'"/><label title="'.$row["fulltext"].'" id="'.$row["accro"].'21" for="'.$row["accro"].'"><img src="/static/img/flags/'.$row["flagurl"].'"  /></label>';
} else {
			echo '			<input type="radio" class="leftradio" name="site" id="'.$row["accro"].'" value="'.$row["accro"].'"  checked="checked" /><label title="'.$row["fulltext"].'" id="'.$row["accro"].'21" class="selected" for="'.$row["accro"].'"><img src="/static/img/flags/'.$row["flagurl"].'"  /></label>';
}
			}
			
			?>
			</div>
			</div>
			
			<div id="switch">
			<a class="button" title="Swap Languages" id="invertbutton" ><i class="icon-exchange icon-2x"></i></a>
			</div>
			
			<div class="translatebar">
			<div id="sites2">
			To<br>
						<?php
			$stmt=$dbh->prepare("SELECT * FROM `languages`");
			$stmt->execute();
		
			while ($row = $stmt->fetch()) {		
if (1==1) {			
echo '			<input type="radio" class="rightradio" name="site2" id="'.$row["accro"].'2" value="'.$row["accro"].'"/><label title="'.$row["fulltext"].'" id="'.$row["accro"].'22" for="'.$row["accro"].'2"><img src="/static/img/flags/'.$row["flagurl"].'"   /></label>';
} else {
echo '			<input type="radio" class="rightradio" name="site2" id="'.$row["accro"].'2" value="'.$row["accro"].'" checked="checked"/><label title="'.$row["fulltext"].'" id="'.$row["accro"].'22" class="selected" for="'.$row["accro"].'2"><img src="/static/img/flags/'.$row["flagurl"].'"  /></label>';
}
			}
			
			?>			</div></div>
			<br>
			<center>
			<input style="" id="searchbox" type="text" placeholder="Type Search Here" />
			<button style="padding:0.5em;" class="button" id="searchbutton" >Search </button><br><br>
			
			</center>
			
			<div class="tag-image-wrapper" id="image-workspace" style="text-align:center;">
			</div>
			
			<br>
			<div id="resultslist" class="tag-image-wrapper"></div>
		
		</section>
		<div style="margin:auto;max-width:900px;text-align:right">
		<a href="tag.php">Tag more images</a> to improve translation accuracy
		</div>
		
		<script>
		$("#image-workspace").hide();
		$("#resultslist").hide();
		
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
					$("#image-workspace").append('<span style="text-align:left;float:left;color:#999">Showing Results For "'+objjy.val()+'"</span><br>')
					for(var s in data.images) {
						$("#image-workspace").append('<img onclick="imageclick(this)" style="margin:0.4em;min-width:100px;max-width:160px;width:40%;" src="'+data.images[s]+'" />')
					}
					$("#image-workspace").append('<br><span style="text-align:left;margin: 0">Click on multiple images relevant to your query to get translation</span><br>')
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
		
		$("#searchbutton").click(function() {

			$("#image-workspace").slideUp({"queue":true});
			if ($("#searchbox").val()!="") {
				alert("hi");
			var objjy=$("#searchbox");

			
			$.getJSON('api.php?type=searchimages&query='+$("#searchbox").val()+'&from='+$("input[type='radio'].leftradio:checked").val()+'&to='+$("input[type='radio'].rightradio:checked").val(), function(data) {
				
				if (data.error===undefined) {
					$("#image-workspace").empty();
					$("#image-workspace").append('<span style="text-align:left;float:left;color:#999">Showing Results For "'+objjy.val()+'"</span><br>')
					for(var s in data.images) {
						$("#image-workspace").append('<img onclick="imageclick(this)" style="margin:0.4em;" width="20%" src="'+data.images[s]+'" />')
					}
					$("#image-workspace").append('<br><span style="text-align:left;margin: 0">Click on multiple images relevant to your query to get translation</span><br>')
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
			
			

		});
		
		
		
		$('.workimage').click(function() {
			alert("hi");
			
		});
		
		function imageclick(elem){	
			
			$("#resultslist").slideUp({"queue":true});
			
			$(elem).toggleClass("hover");
			
			var thing = new Object();
			thing.images = new Array();
			var i;
			
			$('.hover').each(function(i, obj) {
				thing.images[i]=$(this).attr("src");
				i++;
			});
			
			var array = $.toJSON( thing );
			
						
			if ($(elem).attr("class")=="hover") {
			
			$.getJSON('api.php?type=translate&array='+array+'&from='+$("input[type='radio'].leftradio:checked").val()+'&to='+$("input[type='radio'].rightradio:checked").val(), function(data) {
			
			if (data.results!==undefined) {
			
			$("#resultslist").empty();
							
				for(var s in data.results) {
					$("#resultslist").append('<span style="float:left;">'+data.results[s]+'</span><br>')						
				}
				
			$("#resultslist").slideDown();

			}
			
			});
			
			}

		}
		
		</script>

<?php 
include("$root/scripts/footer.php"); 
?>