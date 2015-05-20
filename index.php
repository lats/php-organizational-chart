<?php
//includes
include('create_chart.php');
include('create_skill_list.php');
include('get_info.php');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <link type="text/css" rel="stylesheet" href="index.css"/>
	<script type="text/javascript">
	//Click position -> Get skills
	var skills = <?php echo json_encode($skill_sets); ?>;
	console.log(skills);
	$(window).load(function(){
		$('.orgchart').on('click','.charttext',function () {
			var divid = $(this).attr('id'); 
			divid = divid.replace(/\s+/g, '');
			var ids = skills[divid];
			var arids = ids.split(' ');
			$.each(arids,function(key,value){
				$(":not('#'+value)").css('background-color','');
				$(":not('#'+value)").css('box-shadow','');
			});
			$.each(arids,function(key,value){
				$('#'+value).css('background-color','#024');
				$('#'+value).css('box-shadow','1px 1px 1px 1px #000');
			});
			$(this).parents().find('.charttext').css('background-color', '');
			$(this).css('background-color', '#F00');
		});
	//Click Skill -> Get position
		$('.skills').on('click','.skill',function(){
			var sid = $(this).attr('id');
			var on = [];
			var off = [];
			$(":not(this)").css('background-color','');
			$(":not(this)").css('box-shadow','');
			$(this).css('background-color','#024');
			$(this).css('box-shadow','1px 1px 1px 1px #000');
			$.each(skills, function(key, value){				
				if (value.match(new RegExp(sid))){
					var nospace = key;
					nospace = nospace.replace(/\s+/g, '');
					on.push(nospace);
				} else {	
					var nospace = key;
					nospace = nospace.replace(/\s+/g, '');
					off.push(nospace);
				}
			});
			$.each(off,function(key,value){
				$('#'+value).css('background-color','');
			});	
			$.each(on,function(key,value){
				$('#'+value).css('background-color','#F00');
			});
			console.log(on);
		});
	});
	</script>
</head>
<body>
<div id="container">
<?php
//array creation
	echo '<div id="right" class="orgchart ">';
	PHPtoOrgChart($data);
	echo '</div>';
//Skill Chart. We use the display: types of CSS and some clever java OnClick events to hide/show the needed divs.
	echo '<div id="left" class="skills">';
	echo create_list($list);	
	echo '</div>';
?>
</div>
</body>
</html>
