<!doctype html>
<?php
  echo $this->Html->css("app.css");
  echo $this->Html->css("foundation.css");
  echo $this->Html->script('jquery');
  echo $this->Html->script('app');
  echo $this->Html->script('what-input');
  echo $this->Html->script('foundation');
  
  ?>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSP Library</title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.4/jquery.min.js"></script>
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
      		var target=$('.target').val();
      		var journal=$('.journal').val();
      		var author=$('.author').val();
      		var acronym=$('.acronym').val();
      		if((title=='')&&(journal=='')&&(author=='')&&(acronym =='')&&(target==''))
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
      		var all=$('.input-group-field').val();
      		var title=$('.title').val();
      		var target_search=$('.target').val();
      		var journal=$('.journal').val();
      		var author=$('.author').val();
      		var acronym=$('.acronym').val();
      		var concat='';
      		 $("input:checkbox[class=checktarget]:checked").each(function () {
      			//alert($(this).val());
      			concat+=$(this).val()+'|';
      			//alert(concat);
      		});
      		//alert(concat);
      								
      		$.ajax
      		({
      			url : 'molecular_search',
      			type: 'POST',
      			data: {target:concat,variable:'filter',qs_all:all,title:title,journal:journal,qs_author:author,acronym:acronym},
      			success : function(response)
      			{
      				console.log(response);
      				$('#userinfo').html(response);
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
  <body class="filter search">
    <div class="grid-x">
      <div class="medium-3 cell callout logo-container">
        <!--<a href="/CSPLibrary/"> <h1>CSP Digital Library</h1></a>-->
		<?php echo $this->Html->link('<h1> CSP Labs Digital Library </h1>',
			array('controller' => 'Users', 'action' => 'home'),
			array('escape' => FALSE));
		?>
        <a id=smoothScroll class="scroll-to-top" href="#mainSearch"><img src="../assets/icon.up-arrow.png"></a>
      </div>
      <div class="medium-9 cell nav">
        <div class="grid-x">
          <div class="large-12 cell">
            <div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="large">
              <button class="menu-icon" type="button" data-toggle="responsive-menu"></button>
              <div class="title-bar-title">Menu</div>
            </div>
            <div class="top-bar" id="responsive-menu">
              <div class="top-bar-left">
                <ul class="dropdown menu" data-dropdown-menu>
                  <li>
                    <a class="active" href="/CSPLibrary/users/molecular">Molecular Lab</a>
                   <!-- <ul class="menu">
                      <li><a href="#">Item 1A</a></li>
                     
                    </ul>-->
                  </li>
                  <li>
                    <a href="/CSPLibrary/users/genotype">Genotyping Lab</a>
                   <!-- <ul class="menu">
                      <li><a href="#">Item 1A</a></li>
                     
                    </ul>-->
                  </li>
                  <!--<li><a href="#">Item 2</a></li>
                  <li><a href="#">Item 3</a></li>
                  <li><a href="#">Item 4</a></li>-->
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="grid-x" style="width: 100%;">
        <div class="large-3 cell" id='topsearch2'>
          <div class="refine-search">
            <ul class="accordion" data-accordion data-allow-all-closed="true" data-multi-expand="true">
              <li class="accordion-item" data-accordion-item>
                <!-- Accordion tab title -->
                <a href="#" class="accordion-title" id='accordion-search'>Search By</a>
                <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                <div class="accordion-content" id='search-content' style='display:none' data-tab-content>
                  <form id='frm' name='frm'>
                    <input type="hidden" name="formval" id="formval" value='formval'/>
                    <div class="grid-container">
                      <div class="grid-x grid-padding-x">
                        <div class="large-12 cell">
                          <label>Title
                          <input type="text" name="title" id="title" class="title" value="<?php echo $title;?>">
                          </label>
                        </div>
                      </div>
                      <div class="grid-x grid-padding-x">
                        <div class="large-12 cell">
                          <label>Author Name
                          <input type="text" name="qs_author" id="qs_author" class="qs_author" value="<?php echo $author;?>">
                          </label>
                        </div>
                      </div>
                      <div class="grid-x grid-padding-x">
                        <div class="large-12 cell">
                          <label>Journal
                          <input type="text" id="journal" name="journal" class="journal" value="<?php echo $journal;?>">
                          </label>
                        </div>
                      </div>
                      <div class="grid-x grid-padding-x">
                        <div class="large-12 cell">
                          <label>Target
                          <input type="text" name="target" id="target" class="target" value="<?php echo $target;?>">
                          </label>
                        </div>
                      </div>
                      <div class="grid-x grid-padding-x">
                        <div class="large-12 cell">
                          <label>Acronym
                          <input type="text" name="acronym" id="acronym" class="acronym" value="<?php echo $acronym;?>">
                          </label>
                        </div>
                      </div>
                      <div class="grid-x grid-padding-x">
                        <div class="large-12 cell">
                          <a class="button expanded" href="#" id='submit_search'>Search</a>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </li>
              <li class="accordion-item is-active filter-by" data-accordion-item>
                <!-- Accordion tab title -->
                <a href="#" class="accordion-title" id='accordion-filter'>Filter By</a>
				<a href="#" class="accordion-title" id='accordion-filter'>TARGET</a>
                <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                <div class="accordion-content" id='filter-content' style='display:block' data-tab-content>
                  <form>
                    <fieldset>
                      <div class="grid-container">
                        <div class="grid-x grid-padding-x">
                          <input type="hidden" name="paramval" id="paramval" value="<?php echo isset($_GET['filter'])?>"/>
                          <input type="hidden" name="prevalue" id="prevalue"/>
                          <input type="hidden" name="prevalue1" id="prevalue1"/>
                          <?php 
                            $i=0;
                             if(isset($filterval)!=''){
                            	foreach($filterval as $rowvalues):
                            	$Target=$rowvalues['t']['Target_name'];
                            	if(trim($Target) !='')
                            	{?>
                          <div class="cell" id="<?php echo $Target; ?>">
                            <input type="checkbox" name="checktarget" class="checktarget" value='<?php echo $Target; ?>' id="checktarget<?php echo $i; ?>">
                            <label for="checkbox1"  class="table2" ><?php echo $Target; ?></label>
                          </div>
                          <?php 
                            $i++; 
                            }
                            endforeach;	
                            }?>
                        </div>
                        <div class="grid-x grid-padding-x">
                          <div class="large-12 cell">
                            <div class="button-group expanded">
                              <a class="button" id='searchfilter'>Search</a>
                              <a class="button reset" id="btnreset">Reset</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                  </form>
                </div>
              </li>
            </ul>
          </div>
        </div>
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
                    	$rowvalue[$i]['j']['Title'] = preg_replace('/[\^£ÇT?~?|+¬]/', '', $rowvalue[$i]['j']['Title']);
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
                      $rowvalue[$i]['j']['Journal'] = preg_replace('/[\^£ÇT?~?|+¬]/', '', $rowvalue[$i]['j']['Journal']);
                      $rowvalue[$i]['j']['Author'] = preg_replace('/[\^£ÇT?~?|+¬]/', '', $rowvalue[$i]['j']['Author']);
                      
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
        </div>
      </div>
    </div>
    <!----<script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
    <script src="js/app.js"></script>---->
    <script>
      function uncheckAll() {
        $("input[type='checkbox']:checked").prop("checked", false)
      }
      $('.reset').on('click', uncheckAll)
    </script>
  </body>
</html>