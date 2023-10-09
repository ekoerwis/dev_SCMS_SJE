	</div><!-- cotent-wrapper -->
	</div><!-- cotent -->
	</div><!-- site-content -->
	
<!-- <script src="<?=$config->baseURL . '/public/vendors/materialdashboard/js/plugins/chartist.min.js' ?>"></script> -->
	<footer>
		<div class="footer-copyright">
			<div class="wrapper">
				<?=str_replace('{{YEAR}}', date('Y'), $settingWeb->footer_app)?>
			</div>
		</div>
	</footer>
</body>
</html>

<!-- tambahan eko untuk get size -->
<script>	
	$(document).ready(function() {
		// offsetHeight clientHeight
		var height_body = document.body.offsetHeight;
		var height_site_content = document.querySelector('.site-content').offsetHeight  ;
		var width_site_content = document.querySelector('.site-content').offsetWidth  ;
		
		var height_content = document.querySelector('.content').offsetHeight  ;
		var width_content = document.querySelector('.content').offsetWidth  ;

		var height_breadcrumb = document.querySelector('.breadcrumb').offsetHeight  ;
		var width_breadcrumb = document.querySelector('.breadcrumb').offsetWidth  ;
		
		var height_content_wrapper = document.querySelector('.content-wrapper').offsetHeight  ;
		var width_content_wrapper = document.querySelector('.content-wrapper').offsetWidth  ;
		// alert('<?php //$current_module['NAMA_MODULE'] ?>');

		// alert('height_body : '+height_body +' , site_content : '+height_site_content +' , content : '+height_content +' , content-wrapper : '+ height_content_wrapper+', breadcrumb : '+height_breadcrumb + ',total ='+height_content);

		$.ajax({
			url: "<?php echo site_url().'/../'.$current_module['NAMA_MODULE'].'/setSizeContentSession'; ?>",
			data: { 
				height_site_content:height_site_content,
				width_site_content:width_site_content,
				height_content:height_content,
				width_content:width_content,
				height_breadcrumb:height_breadcrumb,
				width_breadcrumb:width_breadcrumb,
				height_content_wrapper:height_content_wrapper,
				width_content_wrapper:width_content_wrapper
				},
			type: 'post',
			success: function(response) {    
				// hidupkan bila tidak memiliki welcome page atau first page (default page) datagrid easyui
				// if(response == 'needrefresh'){
				// 	location.reload();
				// } 
				// batas hidupkan bila tidak memiliki welcome page atau first page (default page) datagrid easyui                 
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert("error set session size content wrapper");
			}
		});

		const observer = new ResizeObserver(resizeDataGrid);

		if (document.querySelectorAll(".content-wrapper")[0]) {
			observer.observe(document.querySelectorAll(".content-wrapper")[0]);
		}

	});

		let resize = null;

		function resizeDataGrid(entries) {
			clearTimeout(resize);
			let idGrid = null;

			document.querySelectorAll("table").forEach(item => {
				if (item.classList.contains("easyui-datagrid")) {
					idGrid = item.id
				}
			});

			resize = setTimeout(() => {
				$(`#${idGrid}`).datagrid('resize');
			}, 300);
		}

</script>
<!-- batas tambahan eko untuk get size -->