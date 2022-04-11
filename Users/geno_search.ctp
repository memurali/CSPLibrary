<?php
echo $this->Html->css("reveal.css");
echo $this->Html->script('toggle');
echo $this->Html->script('crop');
echo $this->Html->script("jquery-1.4.2.min"); 
echo $this->Html->script("jquery.reveal.js");
echo $this->Html->script("jquery-2.0.2.min.js");
$this->Paginator->options(array('update' => '#content','evalScripts' => true));
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" >
<html>
<head>
<style type="text/css">
	.UserInfoDiv
		{
			float: left;
			margin-left: -10px;
			width:100%;
			padding:10px 2%;
			font-size: 12px;
			font-family: Tahoma;
			
		}
		
</style>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#submit_search').click(function()
			{
				var all=$('.all').val();
				var title=$('.title').val();
				var crop=$('.crop').val();
				var journal=$('.journal').val();
				var author=$('.author').val();
				var subcrop=$('.subcrop').val();
				if((all=='')&&(title=='')&&(journal=='')&&(author=='')&&(subcrop =='')&&(crop==''))
				{
					alert('Search with any one field value');
					return false;
				}
				else
				{
					document.frm.method="POST";
					var str= window.location.href;	
					document.frm.action=str;		  
					document.frm.submit();
				}
			});
			$('.checkcrop').click(function()
			{		
				
				var all=$('.all').val();
				var title=$('.title').val();
				var crop_search=$('.crop').val();
				var journal=$('.journal').val();
				var author=$('.author').val();
				var subcrop=$('.subcrop').val();
				var validate=$('#checkcrop').is(':checked');
				if($(this).is(':checked'))
				{
					var previous =$('#prevalue').val();	
					var targ = $(this).parent().attr('id')+'|'+previous;
					$('input[name=prevalue]').val(targ);
					
					//local add storage on checked crop value
					var previousval =$('#prevalue1').val();
					if(previousval!='')
						var data=$(this).attr('id')+'|'+previousval;
					else
						var data=$(this).attr('id')+'|'+localStorage.getItem('checkcrop');
					if (data.indexOf("null") >= 0)
						 data = data.replace("null", "");
					$('input[name=prevalue1]').val(data);
					localStorage.setItem('checkcrop',data);
				}
				else
				{
					var previous =$('#prevalue').val();
					var text = $(this).parent().attr('id');			
					var targ =previous.replace(text, '');
					targ =targ.replace('||', '|'); 			
					 if ( targ.charAt( 0 ) == '|' )
					  targ=targ.substring(1);			
					$('input[name=prevalue]').val(targ);
					
					//local remove storage on unchecked company value
					var previousval =$('#prevalue1').val();			
					var previousval1=localStorage.getItem('checkcrop');			
					var data=$(this).attr('id');
					if(previousval!='')
					var tarval =previousval.replace(data, '');
					else
					var tarval =previousval1.replace(data, '');
					tarval =tarval.replace('||', '|'); 			
					if ( tarval.charAt( 0 ) == '|' )
					tarval=tarval.substring(1);
					if (tarval.indexOf("null") >= 0)
					tarval = tarval.replace("null", "");
					$('input[name=prevalue1]').val(tarval);
					localStorage.setItem('checkcrop',tarval);
				}
				var cropval=$('#prevalue').val();
				$.ajax
				({
					url : 'geno_search',
					type: 'POST',
					data: {crop:cropval,qs_all:all,title:title,journal:journal,qs_author:author,subcrop:subcrop},
					success : function(response)
					{
						console.log(response);
						var temp = $(response);
						//$('#userinfo').html(response);
						temp.find('#filtermenu,#headtitle,#quicksearch').remove();
						$('#userinfo').css({'margin-left':'0px'});    
						$('#userinfo').css({'margin-top':'-60px'}); 
						$('#userinfo').empty().append(temp);
					}
				});
			});
			$('.btnreset').click(function()
			{
				location.reload();
		 
			});
		});
	</script>
</head>
<body bgcolor="#ffffff">
<center> <span class='headtitle' id='headtitle'>CSP labs Digital Library</span> </center>
<div id='maindiv'>
	<br><br><br>
	<center>
		<div class="quicksearch" id="quicksearch">
			<form  id='frm' name="frm" >
				<input type="hidden" name="formval" id="formval" value='formval'/>
				<div class="searchtbl">
					<table>
						<tr>
							<td><input class="all" placeholder="Search all fields" aria-label="Search all fields" type="text" name="qs_all" id="qs_all" value="<?php echo $all;?>" size="34" maxlength="450" ></td>
							<td><input class="crop" placeholder="Crop" aria-label="Search all fields" type="text" name="crop" id="crop" value="<?php echo $crop;?>" size="34" maxlength="450" title="Crop"></td>
							<td><input class="author" placeholder="Author name" aria-label="Author name" type="text" name="qs_author" id="qs_author" value="<?php echo $author;?>" size="13" maxlength="450" title="e.g. J S Smith or John Smith or Smith JS" style="_width:100%"></td>
							<td><input class="journal" placeholder="Journal" aria-label="Journal or book title" type="text" id="journal" name="journal" value="<?php echo $journal;?>" size="13" maxlength="450" title="For example: journal of molecular biology" autocomplete="off"></td>
							<td><input class="title" placeholder="Title" aria-label="title"  type="text" name="title" id="title" value="<?php echo $title;?>" size="10" maxlength="10"></td>
							<td><input class="subcrop" placeholder="SubCrop" aria-label="subcrop"  type="text" name="subcrop" id="subcrop" value="<?php echo $subcrop;?>" size="20" maxlength="100"></td>
							<td><input class="submit_search" id="submit_search" type="button" alt="Submit Quick Search" value="Search" title="Submit Quick Search" name="sdSearch"></td>
						</tr>
					</table>
				</div>
			</form>
		</div>
	</center>
	<div id='filtermenu' style='margin-left:50px;position: relative;float: left;width: 300px; margin-top: 20px;'>
	<span style="font-size: 14px;font-family: Tahoma;"><?php echo $this->Html->link( "Back",   array('action'=>'geno') ); ?></span>
	<br><br>
		<span><b style="font-size: 14px;font-family: Tahoma;">Crop</b></span><br>
		<div  id="test1" style="display:visible;overflow: auto; max-height: 350px;" class="company">
			<input type="hidden" name="paramval" id="paramval" value="<?php echo isset($_GET['filter'])?>"/>
			<input type="hidden" name="prevalue" id="prevalue"/>
			<input type="hidden" name="prevalue1" id="prevalue1"/>
			<table>
				<?php 
				$i=0;
				 if(isset($filterval)!=''){
					foreach($filterval as $rowvalues):
					$Crop=$rowvalues['p']['Crop'];?>
					<tr><td>
						<div id="<?php echo $Crop; ?>">
							<input type="checkbox" name="checkcrop" class="checkcrop" id="checkcrop<?php echo $i; ?>">
							<label for="gwt-uid-48" class="table2"><?php echo $Crop; ?></label>
						</div>
					</td></tr>
					<?php 
					$i++; 
					endforeach;	
				}?>
			</table>	
		</div>
		<br><hr><br>
		<input type="submit" id="btnreset" class="btnreset" value="Reset">
	</div>
</div>

	<div id='userinfo' style="margin-left:400px;padding: 18px;margin-top: 30px;">
	    <span id='sorted' style='float: left; font-size: 18px;font-family: Tahoma;'>Filter by</span><br><br>
		<span id='checkedcrop'>
			<?php 
			if(substr_count($crops,',')>3)
			{
				$arr = explode(",", $crops);
				echo $arr[0].','.$arr[1].','.$arr[2].','.$arr[3];
			}
			else
				echo $crops;
			?>
		</span>
		<br><br><hr> 
		<div class="UserInfoDiv" id="UserInfoDiv">
		<?php 
			if($rowvalue!='')
			{	
				$i=0;
				for($i=0;$i<count($rowvalue); $i++)
				{
					if(strlen($rowvalue[$i]['j']['Article_ID'])<3)
					{						
						if(strlen($rowvalue[$i]['j']['Article_ID'])==1)
						{	
							$conc = '00'.$rowvalue[$i]['j']['Article_ID'];
						}
						else
							$conc = '0'.$rowvalue[$i]['j']['Article_ID'];
					}
					else
						$conc = $rowvalue[$i]['j']['Article_ID'];
					
					
					if($rowvalue[$i]['p']['In_use']=='')
						$checkbox = '';
					else
						$checkbox = '<input type="checkbox" name="checkbox" style="margin: 5px 6px -6px -20px;" checked>';
					?>
				
					<?php 
					if($rowvalue[$i]['j']['Title']!= $rowvalue[$i-1]['j']['Title'])
					{
						$rowvalue[$i]['j']['Title'] = preg_replace('/[\^Â£Ã‡¥$�~?|+Â¬]/', '', $rowvalue[$i]['j']['Title'])
						?>
						<br>
						<span style='font-size: 14px;font-family: Tahoma;' id='filter_title'><?php echo $rowvalue[$i]['j']['Title'];?></span><br><br>
						<?php 
											
						foreach(glob('Articles/'.$conc.'*') as $filename)
						{ 
							$file = explode('/', $filename);
						?>
							<a class="cLink" rel="nofollow" href="<?php echo $this->webroot;?><?php echo $filename;?>" target="_blank"><?php echo $file[1];?></a><br><br>
						<?php 
						} 
						$rowvalue[$i]['j']['Journal'] = preg_replace('/[\^Â£Ã‡¥$�~?|+Â¬]/', '', $rowvalue[$i]['j']['Journal']);
						$rowvalue[$i]['j']['Author'] = preg_replace('/[\^Â£Ã‡¥$�~?|+Â¬]/', '', $rowvalue[$i]['j']['Author']);
						?>
						<span class='search' name ='filter_author' id='filter_author'><?php echo $rowvalue[$i]['j']['Author'];?></span><br>
						<span class='search' id='filter_journal'><?php echo $rowvalue[$i]['j']['Journal'];?></span> <br>
					<?php 
					}?>
					<?php echo $checkbox;?><span class='search' id='filter_crop'><?php echo $rowvalue[$i]['p']['Crop'];?></span>&nbsp;<span>-</span>				
					<span class='search' id='filter_subcrop'><?php echo $rowvalue[$i]['p']['Subcrop'];?></span><br>
					<?php
						
				}
				
			}?>
		</div>
	</div>
</body>
</html>
