<!doctype html>
<?php
echo $this->Html->css("app.css");
echo $this->Html->css("foundation.css");
echo $this->Html->script('app');
echo $this->Html->script('what-input');
echo $this->Html->script('foundation');
echo $this->Html->script('jquery');
?>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSP Library</title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			var delay = (function(){
			var timer = 0;
			return function(callback, ms){
			clearTimeout (timer);
			timer = setTimeout(callback, ms);
			};
			})();
			$('#qs_all').keyup(function() {
			delay(function(){
			document.frm1.submit();
			}, 1500 );
			});
			$('#submit_search').click(function()
			{
				var all=$('.all').val();
				var title=$('.title').val();
				var crop=$('.crop').val();
				var journal=$('.journal').val();
				var author=$('.author').val();
				var subcrop=$('.subcrop').val();
				if((title=='')&&(journal=='')&&(author=='')&&(subcrop =='')&&(crop==''))
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
			$('#searchfilter').click(function()
			{		
				//alert('search');
				//var all=$('.all').val();
				var all=$('.input-group-field').val();
				var title=$('.title').val();
				var crop_search=$('.crop').val();
				var journal=$('.journal').val();
				var author=$('.author').val();
				var subcrop=$('.subcrop').val();
				var concat='';
				 $("input:checkbox[class=checkcrop]:checked").each(function () {
					//alert($(this).val());
					concat+=$(this).val()+'|';
					//alert(concat);
				});
				//alert(concat);
										
				$.ajax
				({
					url : 'genotype_search',
					type: 'POST',
					data: {crop:concat,variable:'filter',qs_all:all,title:title,journal:journal,qs_author:author,subcrop:subcrop},
					success : function(response)
					{
						console.log(response);
						//alert(response);
						//$('#userinfo').html(response);
						var temp = $(response);
						temp.find('.refine-search,#topsearch1,#topsearch2').remove();
						$('#userinfo').css({'margin-left':'0px'});    
						$('#userinfo').css({'margin-top':'-5px'}); 
						$('#userinfo').empty().append(temp);
					}
				});
			});
			$('#btnreset').click(function()
			{
				location.reload();
		 
			});
			$('#accordion-search').click(function()
			{
				
				if($('#search-content').css('display') == 'none')
				{
					$("#search-content").css("display", "block");
					$(".accordion-title.before").css("content", "-");
					
				}
				else
					$("#search-content").css("display", "none");
			});
			$('#accordion-filter').click(function()
			{
				
				if($('#filter-content').css('display') == 'none')
					$("#filter-content").css("display", "block");
				else
					$("#filter-content").css("display", "none");
			});
			
		});
	</script>
	
  </head>
  <body class="filter">
   <div class="large-9 cell search-results">
          <!-- <div class="grid-x grid-padding-x grid-padding-y hide">
            <div class="large-12 cell">
              <p class="filter-by-title">Filter By</p>
              <form>
                <fieldset>
                  <div class="grid-x grid-padding-x small-up-1 medium-up-2 large-up-3">
                    <div class="cell">
                      <input id="checkbox1" type="checkbox"><label for="checkbox1">Pellentesque Sollicitudin Tellus</label>
                    </div>
                    <div class="cell">
                      <input id="checkbox1" type="checkbox"><label for="checkbox1">Egestas Cras Sollicitudin Vehicula Risus</label>
                    </div>
                    <div class="cell">
                      <input id="checkbox1" type="checkbox"><label for="checkbox1">Amet Commodo Nibh</label>
                    </div>
                    <div class="cell">
                      <input id="checkbox1" type="checkbox"><label for="checkbox1">Nullam Ligula Tortor Ultricies Pharetra</label>
                    </div>
                    <div class="cell">
                      <input id="checkbox1" type="checkbox"><label for="checkbox1">Ligula Ornare Bibendum</label>
                    </div>
                    <div class="cell">
                      <input id="checkbox1" type="checkbox"><label for="checkbox1">Quam Lorem Ligula Amet Pellentesque</label>
                    </div>
                  </div>
                  <div class="grid-x grid-padding-x">
                    <div class="large-12 cell">
                      <a class="button" href="#">Reset</a>
                    </div>
                  </div>
                </fieldset>
              </form>
            </div>
            </div>-->

          <div id='userinfo'>
            <div class="grid-x grid-padding-x grid-margin-x">
              <div class="large-12 cell">
                <br />
              	<form  id='frm1' name="frm1" >
	                <div id="mainSearch" class="input-group main-search">
	                  <input class="input-group-field" id='qs_all' name='qs_all' placeholder="Keywords" value='<?php echo $all;?>'>
	                  <input type="hidden" name="formval" id="formval" value='formval'/>
	                  <div class="input-group-button">
	                    <input type="submit" class="button large" value="Search">
	                  </div>
	                </div>
	              </form>
                <p class="results">Results: <span id="results"><?php echo count($rowvalue); ?></span> Found</p>
              </div>
            </div>
            <article>
              <div class="grid-x grid-padding-x grid-padding-y" >
                <div class="large-12 cell">
                  <span id='checkedtarget' style='display:none'>
                  <?php 
                    if(substr_count($targets,',')>3)
                    {
                    	$arr = explode(",", $targets);
                    	echo $arr[0].','.$arr[1].','.$arr[2].','.$arr[3];
                    }
                    else
                    	echo $targets;
                    ?>
                  </span>
                  <?php 
                    if($rowvalue!='')
                    {	
                    	$i=0;
                    	for($i=0;$i<count($rowvalue); $i++)
                    	{
                    		if(strlen($rowvalue[$i]['t']['Article_ID'])<3)
                    		{						
                    			if(strlen($rowvalue[$i]['t']['Article_ID'])==1)
                    			{	
                    				$conc = '00'.$rowvalue[$i]['t']['Article_ID'];
                    			}
                    			else
                    				$conc = '0'.$rowvalue[$i]['t']['Article_ID'];
                    		}
                    		else
                    			
                    			$conc = $rowvalue[$i]['t']['Article_ID'];
                    		
                    		if($rowvalue[$i]['p']['In_use']=='')
                    			$checkbox = '';
                    		else
                    			$checkbox = '<input type="checkbox" name="checkbox" style="margin: 5px 6px -6px -20px;cursor: auto;" disabled=true checked> ';
                    		?>
                  <?php 
                    if($rowvalue[$i]['j']['Title']!= $rowvalue[$i-1]['j']['Title'])
                    {
                    	$rowvalue[$i]['j']['Title'] = preg_replace('/[\^????T?~?|+??]/', '', $rowvalue[$i]['j']['Title']);
                    	?>
                  <br><br>
                  <p class="article-title">
					<!--<a id="articleTitle" href="detail?id=<?php echo $rowvalue[$i]['j']['Article_ID'];?> ">
                    <?php echo $rowvalue[$i]['j']['Title'];?>
					</a>-->
					<?php echo $this->Html->link($rowvalue[$i]['j']['Title'],
						array('controller' => 'Users', 'action' => 'detail?id='.$rowvalue[$i]['j']['Article_ID']),
						array('id'=>'articleTitle'));
					?>
                  </p>
                  <br>
                  <ul class="no-bullet">
                    <?php 
                      $rowvalue[$i]['j']['Journal'] = preg_replace('/[\^????T?~?|+??]/', '', $rowvalue[$i]['j']['Journal']);
                      $rowvalue[$i]['j']['Author'] = preg_replace('/[\^????T?~?|+??]/', '', $rowvalue[$i]['j']['Author']);
                      
                      ?>
                    <li id="authorName"><?php echo $rowvalue[$i]['j']['Author'];?></li>
                    <li id="journal"><?php echo $rowvalue[$i]['j']['Journal'];?></li>
                    <?php if($rowvalue[$i]['t']['Target_name'] !='') { ?>
                    <li id="target"><?php echo $checkbox;?><?php echo $rowvalue[$i]['t']['Target_name'];?>&nbsp;&nbsp;&nbsp;
                      <?php }
                        if($rowvalue[$i]['t']['Acronym'] !='') {
                        ?>
                      <span id="acronym"> <?php echo $rowvalue[$i]['t']['Acronym'];?></span>
                    </li>
                    <?php 
                      }
                      }?>
                    <?php
                      if($rowvalue[$i]['j']['Title']!= $rowvalue[$i-1]['j']['Title'])
                      {
                      	foreach(glob('Articles/'.$conc.'*') as $filename)
                      	{ 
                      		$file = explode('/', $filename);
                      	?>
                    <li><span ><a href="<?php echo $this->webroot;?><?php echo $filename;?>" id="supplementalFile"><?php echo $file[1];?></a></span></li>
                    <?php 
                      } 
                      }
                      ?>
                  </ul>
                  <?php					
                    }
                    //endforeach; 
                    }?>
                </div>
              </div>
            </article>
          </div>
  </body>
</html>
