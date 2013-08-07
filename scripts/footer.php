		<!-- Javascript At End -->
 		<script src="/static/js/vendor/less-1.3.3.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="/static/js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <script src="/static/js/plugins.js"></script>
        <script src="/static/js/main.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){

				$("#settings").hide();
				$("#settingsbutton").show();

				$('#settingsbutton').click(function(){
				$("#settings").slideToggle();
				});

			});
		</script>
		
    </body>
</html>